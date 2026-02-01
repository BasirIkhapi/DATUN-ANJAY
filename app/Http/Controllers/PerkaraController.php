<?php

namespace App\Http\Controllers;

use App\Models\Perkara;
use App\Models\Jaksa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class PerkaraController extends Controller
{
    /**
     * Menampilkan Form Tambah Perkara Baru
     */
    public function create()
    {
        $jaksas = Jaksa::all();
        return view('admin.perkara.create', compact('jaksas'));
    }

    /**
     * Menyimpan Data Perkara Baru ke Database
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

        try {
            Perkara::create([
                'nomor_perkara' => $request->nomor_perkara,
                'jaksa_id'      => $request->jaksa_id,
                'penggugat'     => strtoupper($request->penggugat),
                'tergugat'      => strtoupper($request->tergugat),
                'jenis_perkara' => $request->jenis_perkara,
                'tanggal_masuk' => $request->tanggal_masuk,
                'status_akhir'  => 'Proses',
            ]);

            return redirect()->route('dashboard')->with('success', 'Data Perkara Berhasil Disimpan ke SIM-DATUN!');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal simpan ke database: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Fitur Baru: Menampilkan Halaman Monitoring Detail Perkara
     * Mengambil data perkara beserta riwayat tahapannya (Timeline)
     */
    public function monitoring($id)
    {
        // Menggunakan eager loading 'with' agar data Jaksa dan Tahapans terpanggil otomatis
        $perkara = Perkara::with(['jaksa', 'tahapans'])->findOrFail($id);
        
        return view('admin.perkara.monitoring', compact('perkara'));
    }

    /**
     * Fitur Baru: Update Status Perkara ke Selesai
     * Digunakan oleh tombol "Tandai Selesai" di halaman monitoring
     */
    public function updateStatus($id)
    {
        $perkara = Perkara::findOrFail($id);
        $perkara->update(['status_akhir' => 'Selesai']);

        return redirect()->route('dashboard')->with('success', 'Status perkara berhasil diperbarui ke Selesai.');
    }

    /**
     * Menghapus Data Perkara dari Sistem
     */
    public function destroy($id)
    {
        $perkara = Perkara::findOrFail($id);
        $perkara->delete();

        return redirect()->route('dashboard')->with('success', 'Data perkara telah berhasil dihapus.');
    }

    /**
     * Fitur Cetak Statistik Perkara (Format PDF Portrait)
     */
    public function cetakStatistik()
    {
        $total = Perkara::count();
        $perdata = Perkara::where('jenis_perkara', 'PERDATA')->count();
        $tun = Perkara::where('jenis_perkara', 'TATA USAHA NEGARA')->count();
        $daftar_perkara = Perkara::with('jaksa')->orderBy('jenis_perkara')->get();

        $pdf = Pdf::loadView('admin.perkara.statistik_pdf', compact('total', 'perdata', 'tun', 'daftar_perkara'))
                    ->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan_Statistik_Perkara_DATUN.pdf');
    }

    /**
     * Fitur Cetak Arsip Perkara yang Sudah Selesai (Format PDF Landscape)
     */
    public function cetakArsip()
    {
        $perkara_selesai = Perkara::with('jaksa')
            ->where('status_akhir', 'Selesai')
            ->orderBy('tanggal_masuk', 'desc')
            ->get();
        
        $pdf = Pdf::loadView('admin.perkara.arsip_pdf', compact('perkara_selesai'))
                    ->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan_Arsip_Perkara_Selesai.pdf');
    }
}