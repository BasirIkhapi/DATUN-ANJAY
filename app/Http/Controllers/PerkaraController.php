<?php

namespace App\Http\Controllers;

use App\Models\Perkara;
use App\Models\Jaksa;
use App\Models\Tahapan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PerkaraController extends Controller
{
    /**
     * Menampilkan Daftar Seluruh Perkara (Halaman Tabel Monitoring)
     */
    public function index()
    {
        $perkaras = Perkara::with('jaksa')->latest()->get();
        return view('admin.perkara.monitoring', compact('perkaras'));
    }

    /**
     * Menampilkan Detail Progres Satu Perkara (Halaman Timeline)
     */
    public function show($id)
    {
        $perkara = Perkara::with(['jaksa', 'tahapans'])->findOrFail($id);
        return view('admin.perkara.monitoring', compact('perkara'));
    }

    /**
     * Fitur: Cetak Progres Perkara Individu (Format PDF)
     */
    public function cetakDetail($id)
    {
        $perkara = Perkara::with(['jaksa', 'tahapans'])->findOrFail($id);
        $namaFileClean = str_replace(['/', '\\'], '-', $perkara->nomor_perkara);

        $pdf = Pdf::loadView('admin.perkara.monitoring_pdf', compact('perkara'))
                  ->setPaper('a4', 'portrait');

        return $pdf->stream('Progres_Perkara_' . $namaFileClean . '.pdf');
    }

    /**
     * FITUR BARU: Cetak Laporan Rekapitulasi Berdasarkan Periode (Eksklusif Pimpinan)
     *
     */
    public function cetakPeriode(Request $request)
    {
        // Validasi input tanggal
        $request->validate([
            'tgl_mulai'   => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
        ]);

        $tgl_mulai = $request->tgl_mulai;
        $tgl_selesai = $request->tgl_selesai;

        // Ambil data perkara dalam rentang tanggal tersebut
        $perkaras = Perkara::with('jaksa')
                    ->whereBetween('tanggal_masuk', [$tgl_mulai, $tgl_selesai])
                    ->orderBy('tanggal_masuk', 'asc')
                    ->get();

        // Load view PDF khusus rekap
        $pdf = Pdf::loadView('admin.perkara.cetak_rekap_pdf', compact('perkaras', 'tgl_mulai', 'tgl_selesai'))
                  ->setPaper('a4', 'landscape'); // Landscape agar tabel muat banyak kolom

        return $pdf->stream('Rekap_Laporan_DATUN_' . $tgl_mulai . '_sd_' . $tgl_selesai . '.pdf');
    }

    /**
     * Menyimpan Tahapan/Progres Sidang Baru
     */
    public function storeTahapan(Request $request)
    {
        $request->validate([
            'perkara_id'      => 'required|exists:perkaras,id',
            'tanggal_tahapan' => 'required|date',
            'nama_tahapan'    => 'required|string|max:255',
            'keterangan'      => 'nullable|string',
        ]);

        Tahapan::create($request->all());

        return redirect()->back()->with('success', 'Progres sidang berhasil ditambahkan!');
    }

    public function create()
    {
        $jaksas = Jaksa::all();
        return view('admin.perkara.create', compact('jaksas'));
    }

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

        Perkara::create([
            'nomor_perkara' => $request->nomor_perkara,
            'jaksa_id'      => $request->jaksa_id,
            'penggugat'     => $request->penggugat, // Dihapus strtoupper agar fleksibel
            'tergugat'      => $request->tergugat,   // Dihapus strtoupper agar fleksibel
            'jenis_perkara' => $request->jenis_perkara,
            'tanggal_masuk' => $request->tanggal_masuk,
            'status_akhir'  => 'Proses',
        ]);

        return redirect()->route('dashboard')->with('success', 'Data Perkara Berhasil Disimpan!');
    }

    public function updateStatus($id)
    {
        $perkara = Perkara::findOrFail($id);
        $perkara->update(['status_akhir' => 'Selesai']);

        return redirect()->back()->with('success', 'Status perkara diperbarui ke Selesai.');
    }

    public function destroy($id)
    {
        $perkara = Perkara::findOrFail($id);
        $perkara->delete();

        return redirect()->route('dashboard')->with('success', 'Data perkara telah dihapus.');
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

    public function cetakArsip()
    {
        $perkara_selesai = Perkara::with('jaksa')->where('status_akhir', 'Selesai')->get();
        
        return Pdf::loadView('admin.perkara.arsip_pdf', compact('perkara_selesai'))
                ->setPaper('a4', 'landscape')
                ->stream('Laporan_Arsip_Selesai.pdf');
    }
}