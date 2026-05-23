<?php

namespace App\Http\Controllers;

use App\Models\Perkara;
use App\Models\Jaksa;
use App\Models\Tahapan;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PerkaraController extends Controller
{
    /**
     * TAMPILAN UTAMA: Pantauan Perkara
     */
    public function index()
    {
        $perkaras = Perkara::with(['jaksa', 'tahapans'])->latest()->get();
        return view('admin.perkara.index', compact('perkaras'));
    }

    /**
     * TAMPILAN PUSAT ARSIP
     */
    public function pusatArsip(Request $request)
    {
        $query = Perkara::with(['jaksa', 'tahapans'])->where('status_akhir', 'Selesai');

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_masuk', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_masuk', $request->tahun);
        }

        $perkaras = $query->latest()->get();
        return view('admin.arsip.index', compact('perkaras'));
    }

    /**
     * REGISTRASI PERKARA: Khusus Admin
     */
    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('perkara.index')->with('error', 'Hanya Admin yang dapat meregistrasi.');
        }
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
            'jenis_perkara' => 'required|in:Perdata,Tata Usaha Negara',
            'tanggal_masuk' => 'required|date',
            'file_skk'      => 'required|mimes:pdf|max:5120',
        ]);

        $filenameSKK = 'SKK_' . time() . '_' . Str::random(5) . '.pdf';
        $request->file('file_skk')->storeAs('skk', $filenameSKK, 'public');

        $perkara = Perkara::create([
            'nomor_perkara' => $request->nomor_perkara,
            'jaksa_id'      => $request->jaksa_id,
            'penggugat'     => $request->penggugat,
            'tergugat'      => $request->tergugat,
            'jenis_perkara' => $request->jenis_perkara,
            'tanggal_masuk' => $request->tanggal_masuk,
            'status_akhir'  => 'Proses',
            'file_skk'      => $filenameSKK,
            'is_verified'   => false
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'perkara_id' => $perkara->id,
            'deskripsi' => "Admin meregistrasi perkara baru: " . $perkara->nomor_perkara
        ]);

        return redirect()->route('perkara.index')->with('success', 'Perkara Berhasil Diregistrasi!');
    }

    /**
     * VERIFIKASI BERKAS: Khusus Staff
     */
    public function verifikasi(Request $request, $id)
    {
        if (Auth::user()->role !== 'staff') {
            return redirect()->back()->with('error', 'Otoritas verifikasi hanya untuk Staff.');
        }

        $perkara = Perkara::findOrFail($id);
        $status = $request->status === 'setuju';

        $perkara->update([
            'is_verified' => $status,
            'alasan_penolakan' => $status ? null : $request->alasan_penolakan
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'perkara_id' => $perkara->id,
            'deskripsi' => "Staff melakukan verifikasi berkas pada perkara: " . $perkara->nomor_perkara
        ]);

        return redirect()->back()->with('success', 'Status verifikasi berhasil diperbarui.');
    }

    /**
     * UPLOAD/REVISI SKK DI MODAL: Khusus Admin
     */
    public function uploadSKK(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Otoritas unggah hanya untuk Admin.');
        }

        $request->validate(['file_skk' => 'required|mimes:pdf|max:5120']);
        $perkara = Perkara::findOrFail($id);

        if ($request->hasFile('file_skk')) {
            if ($perkara->file_skk) {
                Storage::disk('public')->delete('skk/' . $perkara->file_skk);
            }
            $filename = 'SKK_REV_' . time() . '_' . Str::slug($perkara->nomor_perkara) . '.pdf';
            $request->file('file_skk')->storeAs('skk', $filename, 'public');

            $perkara->update([
                'file_skk' => $filename,
                'is_verified' => false,
                'alasan_penolakan' => null
            ]);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'perkara_id' => $perkara->id,
                'deskripsi' => "Admin merevisi berkas SKK: " . $perkara->nomor_perkara
            ]);
        }

        return redirect()->back()->with('success', 'Berkas SKK Berhasil Diperbarui!');
    }

    /**
     * OPERASIONAL PROGRES SIDANG
     */
    public function storeTahapan(Request $request)
    {
        $perkara = Perkara::findOrFail($request->perkara_id);

        if (Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Hanya Admin yang berhak menginput progres.');
        }

        $request->validate([
            'perkara_id'      => 'required|exists:perkaras,id',
            'nama_tahapan'    => 'required|string|max:255',
            'tanggal_tahapan' => 'required|date',
        ]);

        $filename = null;
        if ($request->hasFile('file_tahapan')) {
            $filename = 'SIDANG_' . time() . '_' . Str::random(5) . '.pdf';
            $request->file('file_tahapan')->storeAs('dokumen_tahapan', $filename, 'public');
        }

        Tahapan::create([
            'perkara_id'      => $request->perkara_id,
            'nama_tahapan'    => $request->nama_tahapan,
            'tanggal_tahapan' => $request->tanggal_tahapan,
            'keterangan'      => $request->keterangan,
            'file_tahapan'    => $filename,
        ]);

        if ($request->has('set_selesai')) {
            $perkara->update(['status_akhir' => 'Selesai', 'file_putusan' => $filename]);
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'perkara_id' => $perkara->id,
            'deskripsi' => "Admin menambahkan tahapan: " . $request->nama_tahapan
        ]);

        return redirect()->back()->with('success', 'Tahapan sidang berhasil ditambahkan.');
    }

    /**
     * ==========================================
     * KUMPULAN LAPORAN (REPORT)
     * ==========================================
     */

    public function cetakDetail($id)
    {
        $perkara = Perkara::with(['jaksa', 'tahapans'])->findOrFail($id);

        // Perbaikan: Menambahkan variabel judulLaporan yang dipanggil di file blade
        $data = [
            'perkara' => $perkara,
            'judulLaporan' => 'LAPORAN DETAIL PEMANTAUAN TAHAPAN PERKARA'
        ];

        return Pdf::loadView('admin.perkara.pdf_detail', $data)
            ->setPaper('a4', 'portrait')->stream('Detail_Perkara.pdf');
    }

    public function cetakLabel($id)
    {
        $perkara = Perkara::with('jaksa')->findOrFail($id);
        $data = ['perkara' => $perkara, 'tanggal_cetak' => now()->translatedFormat('d F Y')];
        return Pdf::loadView('admin.perkara.pdf_label', $data)
            ->setPaper([0, 0, 600, 400], 'portrait')->stream('Label_Map.pdf');
    }

    /**
     * FIX LAPORAN STATISTIK: Menambahkan variabel $daftar_perkara
     */
    public function cetakStatistik()
    {
        $daftar_perkara = Perkara::with('jaksa')->latest()->get();

        $data = [
            'daftar_perkara' => $daftar_perkara, // Variabel yang dibutuhkan oleh @forelse di Blade
            'total'          => $daftar_perkara->count(),
            'perdata'        => $daftar_perkara->where('jenis_perkara', 'Perdata')->count(),
            'tun'            => $daftar_perkara->where('jenis_perkara', 'Tata Usaha Negara')->count(),
            'selesai'        => $daftar_perkara->where('status_akhir', 'Selesai')->count(),
            'proses'         => $daftar_perkara->where('status_akhir', 'Proses')->count(),
        ];

        return Pdf::loadView('admin.arsip.statistik_pdf', $data)->stream('Statistik_Perkara.pdf');
    }

    public function cetakKinerja()
    {
        $jaksas = Jaksa::withCount('perkaras')->get();
        return Pdf::loadView('admin.arsip.pdf_kinerja', compact('jaksas'))->stream('Kinerja_JPN.pdf');
    }

    public function cetakStagnansi()
    {
        $perkaras = Perkara::with(['tahapans'])->where('status_akhir', 'Proses')->get()
            ->filter(fn($p) => Carbon::parse($p->tahapans->max('tanggal_tahapan') ?? $p->tanggal_masuk)->diffInDays(now()) > 14);
        return Pdf::loadView('admin.arsip.pdf_stagnansi', compact('perkaras'))->setPaper('a4', 'landscape')->stream('Stagnansi.pdf');
    }

    public function cetakArsip()
    {
        $perkara_selesai = Perkara::with('jaksa')->where('status_akhir', 'Selesai')->get();
        return Pdf::loadView('admin.arsip.arsip_pdf', compact('perkara_selesai'))->setPaper('a4', 'landscape')->stream('Arsip_Perkara.pdf');
    }

    public function cetakMonitoring()
    {
        $perkaras = Perkara::with(['jaksa', 'tahapans'])->latest()->get();
        return Pdf::loadView('admin.perkara.monitoring_pdf', compact('perkaras'))->setPaper('a4', 'landscape')->stream('Monitoring_Sistem.pdf');
    }

    /**
     * LAPORAN DURASI PENYELESAIAN (AGING REPORT)
     */
    public function cetakDurasi()
    {
        $perkaras = Perkara::with(['tahapans'])->where('status_akhir', 'Selesai')->get()
            ->map(function ($perkara) {
                $tglMasuk = Carbon::parse($perkara->tanggal_masuk);
                $tglSelesaiRaw = $perkara->tahapans->max('tanggal_tahapan');

                if ($tglSelesaiRaw) {
                    $tglSelesai = Carbon::parse($tglSelesaiRaw);
                    $perkara->setAttribute('selisih', $tglMasuk->diffInDays($tglSelesai));
                } else {
                    $perkara->setAttribute('selisih', 0);
                }
                return $perkara;
            });

        $rata_rata = $perkaras->count() > 0 ? round($perkaras->avg('selisih'), 1) : 0;

        return Pdf::loadView('admin.perkara.pdf_durasi', compact('perkaras', 'rata_rata'))
            ->setPaper('a4', 'landscape')->stream('Laporan_Durasi_Penyelesaian.pdf');
    }

    /**
     * LAPORAN AUDIT LOG
     */
    public function cetakLogAktivitas()
    {
        $logs = ActivityLog::with('user')->latest()->get();
        return Pdf::loadView('admin.perkara.pdf_log', compact('logs'))
            ->setPaper('a4', 'portrait')->stream('Laporan_Audit_Log.pdf');
    }
}
