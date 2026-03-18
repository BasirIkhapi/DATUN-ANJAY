<?php

namespace App\Http\Controllers;

use App\Models\Perkara;
use App\Models\Tahapan;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MonitoringController extends Controller
{
    /**
     * TAMPILAN MONITORING UTAMA
     * Menampilkan semua perkara untuk dipantau oleh Staff atau Admin.
     */
    public function index()
    {
        // Menggunakan relasi 'tahapans' sesuai dengan koding di PerkaraController
        $perkaras = Perkara::with(['jaksa', 'tahapans'])->latest()->get();
        return view('admin.perkara.monitoring', compact('perkaras'));
    }

    /**
     * DETAIL PERKARA
     */
    public function show($id)
    {
        $perkara = Perkara::with(['jaksa', 'tahapans'])->findOrFail($id);
        return view('admin.perkara.show', compact('perkara'));
    }

    /**
     * VERIFIKASI BERKAS OLEH STAFF
     * Disesuaikan dengan alur verifikasi dan pencatatan log aktivitas.
     */
    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:setuju,tolak',
            'alasan_penolakan' => 'required_if:status,tolak|nullable|string',
        ]);

        $perkara = Perkara::findOrFail($id);
        $isSetuju = $request->status === 'setuju';

        $perkara->update([
            'is_verified' => $isSetuju,
            'alasan_penolakan' => $isSetuju ? null : $request->alasan_penolakan,
            'status_akhir' => 'Proses'
        ]);

        // Mencatat aktivitas verifikasi ke dalam activity_logs
        ActivityLog::create([
            'user_id' => Auth::id(),
            'perkara_id' => $perkara->id,
            'deskripsi' => "Staff memverifikasi berkas perkara nomor: " . $perkara->nomor_perkara . " (Status: " . ucfirst($request->status) . ")"
        ]);

        return back()->with('success', 'Status verifikasi berkas berhasil diperbarui.');
    }

    /**
     * INPUT TAHAPAN SIDANG
     * Menggunakan model Tahapan yang merujuk pada tabel 'tahapan_perkaras'.
     */
    public function storeTahapan(Request $request)
    {
        $request->validate([
            'perkara_id' => 'required|exists:perkaras,id',
            'tanggal_tahapan' => 'required|date',
            'nama_tahapan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $tahapan = Tahapan::create([
            'perkara_id' => $request->perkara_id,
            'tanggal_tahapan' => $request->tanggal_tahapan,
            'nama_tahapan' => strtoupper($request->nama_tahapan),
            'keterangan' => strtoupper($request->keterangan),
        ]);

        // Mencatat aktivitas penambahan tahapan
        ActivityLog::create([
            'user_id' => Auth::id(),
            'perkara_id' => $request->perkara_id,
            'deskripsi' => "Staff menambahkan tahapan sidang: " . strtoupper($request->nama_tahapan)
        ]);

        return back()->with('success', 'Tahapan sidang berhasil ditambahkan!');
    }

    /**
     * FUNGSI CETAK MONITORING INDIVIDUAL (Output PDF)
     */
    public function cetakPDF($id)
    {
        $perkara = Perkara::with(['jaksa', 'tahapans'])->findOrFail($id);

        $pdf = Pdf::loadView('admin.perkara.monitoring_pdf', compact('perkara'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Monitoring_Perkara_' . str_replace('/', '-', $perkara->nomor_perkara) . '.pdf');
    }

    /**
     * LAPORAN TAMBAHAN UNTUK SKRIPSI: DURASI PENYELESAIAN
     */
    public function cetakDurasi()
    {
        $perkaras = Perkara::with(['tahapans'])
            ->where('status_akhir', 'Selesai')
            ->get()
            ->map(function ($perkara) {
                $tglMasuk = Carbon::parse($perkara->tanggal_masuk);
                // Mengambil tanggal tahapan terakhir sebagai waktu selesai
                $tglSelesai = Carbon::parse($perkara->tahapans->max('tanggal_tahapan'));
                $perkara->durasi_hari = $tglMasuk->diffInDays($tglSelesai);
                return $perkara;
            });

        return Pdf::loadView('admin.arsip.pdf_durasi', compact('perkaras'))
            ->setPaper('a4', 'landscape')
            ->stream('Laporan_Durasi_Penyelesaian_Perkara.pdf');
    }
}
