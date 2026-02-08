<?php

namespace App\Http\Controllers;

use App\Models\Perkara;
use App\Models\Jaksa;
use App\Models\Tahapan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PerkaraController extends Controller
{
    /**
     * Halaman Utama Pantauan Perkara (Monitoring Operasional)
     */
    public function index()
    {
        $perkaras = Perkara::with(['jaksa', 'tahapans'])->latest()->get();
        return view('admin.perkara.index', compact('perkaras'));
    }

    /**
     * Halaman PUSAT DATA & ARSIP (Dashboard Laporan & Dokumentasi)
     */
    public function pusatArsip(Request $request)
    {
        $query = Perkara::with('jaksa');

        if ($request->filled('jenis')) {
            $query->where('jenis_perkara', $request->jenis);
        }

        $perkaras = $query->latest()->get();
        $total_arsip = Perkara::where('status_akhir', 'Selesai')->count();

        return view('admin.arsip.index', compact('perkaras', 'total_arsip'));
    }

    /**
     * [LAPORAN ANALITIS 4] Rekap Arsip Selesai (INKRACHT)
     * Menghasilkan daftar seluruh perkara yang telah tuntas ditangani
     */
    public function cetakArsip()
    {
        $perkara_selesai = Perkara::with('jaksa')
            ->where('status_akhir', 'Selesai')
            ->orderBy('updated_at', 'desc')
            ->get();

        $pdf = Pdf::loadView('admin.arsip.arsip_pdf', compact('perkara_selesai'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan_Arsip_Perkara_Selesai.pdf');
    }

    /**
     * [LAPORAN ANALITIS 1] Kinerja Personel JPN
     */
    public function cetakKinerjaJPN()
    {
        $jaksas = Jaksa::with(['perkaras'])->withCount('perkaras')->get();
        $pdf = Pdf::loadView('admin.arsip.pdf_kinerja_jpn', compact('jaksas'))
            ->setPaper('a4', 'portrait');
        return $pdf->stream('Laporan_Kinerja_JPN_Banjarmasin.pdf');
    }

    /**
     * [LAPORAN ANALITIS 2] Durasi Penanganan (Aging)
     */
    public function cetakDurasi()
    {
        $perkaras = Perkara::with('jaksa')
            ->where('status_akhir', 'Selesai')
            ->get()
            ->map(function ($perkara) {
                $tglMasuk = Carbon::parse($perkara->tanggal_masuk);
                $tglSelesai = $perkara->updated_at;
                $perkara->durasi_hari = $tglMasuk->diffInDays($tglSelesai);
                return $perkara;
            });

        $rata_rata = $perkaras->count() > 0 ? round($perkaras->avg('durasi_hari')) : 0;
        $pdf = Pdf::loadView('admin.arsip.pdf_durasi', compact('perkaras', 'rata_rata'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan_Durasi_Penanganan.pdf');
    }

    /**
     * [LAPORAN ANALITIS 3] Evaluasi Stagnansi
     */
    public function cetakStagnansi()
    {
        $perkaras = Perkara::with(['jaksa', 'tahapans'])
            ->where('status_akhir', 'Proses')
            ->get()
            ->filter(function ($perkara) {
                $lastUpdate = $perkara->tahapans->max('tanggal_tahapan') ?? $perkara->tanggal_masuk;
                return Carbon::parse($lastUpdate)->diffInDays(now()) > 14;
            })
            ->map(function ($perkara) {
                $lastUpdate = $perkara->tahapans->max('tanggal_tahapan') ?? $perkara->tanggal_masuk;
                $perkara->hari_stagnan = Carbon::parse($lastUpdate)->diffInDays(now());
                $perkara->update_terakhir = Carbon::parse($lastUpdate)->translatedFormat('d F Y');
                return $perkara;
            });

        $pdf = Pdf::loadView('admin.arsip.pdf_stagnansi', compact('perkaras'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan_Evaluasi_Stagnansi.pdf');
    }

    /**
     * Menyimpan Progres Tahapan & Cek Toggle Selesaikan Perkara
     */
    public function storeTahapan(Request $request)
    {
        $request->validate([
            'perkara_id'      => 'required|exists:perkaras,id',
            'tanggal_tahapan' => 'required|date',
            'nama_tahapan'    => 'required|string|max:255',
        ]);

        Tahapan::create($request->all());

        if ($request->has('set_selesai')) {
            Perkara::findOrFail($request->perkara_id)->update(['status_akhir' => 'Selesai']);
            $msg = 'Progres berhasil ditambah & Perkara telah diselesaikan!';
        } else {
            $msg = 'Progres tahapan berhasil ditambahkan!';
        }

        return redirect()->back()->with('success', $msg);
    }

    /**
     * Menyimpan Registrasi Perkara Baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomor_perkara' => 'required|unique:perkaras,nomor_perkara',
            'jaksa_id'      => 'required|exists:jaksas,id',
            'penggugat'     => 'required|string|max:255',
            'tergugat'      => 'required|string|max:255',
            'jenis_perkara' => 'required',
            'tanggal_masuk' => 'required|date',
        ]);

        Perkara::create(array_merge($request->all(), ['status_akhir' => 'Proses']));
        return redirect()->route('perkara.index')->with('success', 'Registrasi Perkara Berhasil Disimpan!');
    }

    /**
     * FITUR CETAK STANDAR
     */
    public function cetakDetail($id)
    {
        $perkara = Perkara::with(['jaksa', 'tahapans'])->findOrFail($id);
        $namaFileClean = str_replace(['/', '\\'], '-', $perkara->nomor_perkara);
        $pdf = Pdf::loadView('admin.perkara.monitoring_pdf', compact('perkara'))->setPaper('a4', 'portrait');
        return $pdf->stream('Detail_Perkara_' . $namaFileClean . '.pdf');
    }

    public function cetakPeriode(Request $request)
    {
        $request->validate([
            'tgl_mulai'   => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
        ]);

        $perkaras = Perkara::with('jaksa')
            ->whereBetween('tanggal_masuk', [$request->tgl_mulai, $request->tgl_selesai])
            ->orderBy('tanggal_masuk', 'asc')
            ->get();

        $pdf = Pdf::loadView('admin.perkara.cetak_rekap_pdf', [
            'perkaras' => $perkaras,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('Rekap_Laporan_DATUN.pdf');
    }

    public function cetakStatistik()
    {
        $total = Perkara::count();
        $perdata = Perkara::where('jenis_perkara', 'PERDATA')->count();
        $tun = Perkara::where('jenis_perkara', 'TATA USAHA NEGARA')->count();
        $daftar_perkara = Perkara::with('jaksa')->orderBy('jenis_perkara')->get();

        return Pdf::loadView('admin.perkara.statistik_pdf', compact('total', 'perdata', 'tun', 'daftar_perkara'))
            ->setPaper('a4', 'portrait')
            ->stream('Laporan_Statistik_Perkara.pdf');
    }

    public function show($id)
    {
        $perkara = Perkara::with(['jaksa', 'tahapans' => function ($query) {
            $query->orderBy('tanggal_tahapan', 'desc');
        }])->findOrFail($id);
        return view('admin.perkara.monitoring', compact('perkara'));
    }

    public function updateStatus($id)
    {
        Perkara::findOrFail($id)->update(['status_akhir' => 'Selesai']);
        return redirect()->back()->with('success', 'Perkara berhasil diarsipkan.');
    }

    public function destroy($id)
    {
        Perkara::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data perkara telah berhasil dihapus.');
    }
}
