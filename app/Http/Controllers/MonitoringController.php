<?php

namespace App\Http\Controllers;

use App\Models\Perkara;
use App\Models\Tahapan; // Pastikan ini merujuk ke TahapanPerkara jika itu tabel riwayatnya
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class MonitoringController extends Controller
{
    /**
     * TAMPILAN MONITORING (Untuk Staff)
     */
    public function index()
    {
        // Menampilkan semua perkara untuk dipantau oleh Staff
        $perkaras = Perkara::with(['jaksa', 'tahapanPerkaras'])->latest()->get();
        return view('admin.perkara.monitoring', compact('perkaras'));
    }

    public function show($id)
    {
        // Pastikan nama relasi di model Perkara adalah 'tahapanPerkaras'
        $perkara = Perkara::with(['jaksa', 'tahapanPerkaras'])->findOrFail($id);
        return view('admin.perkara.show', compact('perkara'));
    }

    /**
     * TUGAS STAFF: VERIFIKASI BERKAS & UPLOAD SKK
     * Ini fungsi penting agar alur aplikasi dianggap jelas oleh dosen.
     */
    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'file_skk' => 'required|mimes:pdf|max:2048', // Validasi file PDF maks 2MB
        ]);

        $perkara = Perkara::findOrFail($id);

        if ($request->hasFile('file_skk')) {
            // Hapus file lama jika ada
            if ($perkara->file_skk) {
                Storage::delete($perkara->file_skk);
            }

            // Simpan file baru
            $path = $request->file('file_skk')->store('public/skk');
            
            $perkara->update([
                'file_skk' => $path,
                'is_verified' => true, // Tandai sudah diverifikasi
                'status_akhir' => 'Proses'
            ]);
        }

        return back()->with('success', 'Berkas perkara telah diverifikasi oleh Staff.');
    }

    /**
     * TUGAS STAFF: INPUT TAHAPAN SIDANG
     */
    public function storeTahapan(Request $request)
    {
        $request->validate([
            'perkara_id' => 'required|exists:perkaras,id',
            'tanggal_tahapan' => 'required|date',
            'nama_tahapan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        // Menggunakan Model Tahapan (Pastikan fillable sudah benar)
        Tahapan::create([
            'perkara_id' => $request->perkara_id,
            'tanggal_tahapan' => $request->tanggal_tahapan,
            'nama_tahapan' => strtoupper($request->nama_tahapan),
            'keterangan' => strtoupper($request->keterangan),
        ]);

        return back()->with('success', 'Tahapan sidang berhasil ditambahkan oleh Staff!');
    }

    /**
     * FUNGSI CETAK PDF (Output Akhir)
     */
    public function cetakPDF($id)
    {
        $perkara = Perkara::with(['jaksa', 'tahapanPerkaras'])->findOrFail($id);
        
        $pdf = Pdf::loadView('admin.perkara.monitoring_pdf', compact('perkara'))
                ->setPaper('a4', 'portrait');

        return $pdf->stream('Monitoring_Perkara_' . $perkara->nomor_perkara . '.pdf');
    }
}