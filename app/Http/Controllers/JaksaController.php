<?php

namespace App\Http\Controllers;

use App\Models\Jaksa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class JaksaController extends Controller
{
    /**
     * Menampilkan Daftar Personel JPN
     */
    public function index()
    {
        // Mengambil data jaksa beserta relasi perkara
        $jaksas = Jaksa::with('perkaras')->latest()->get();
        
        // Mengarahkan ke folder admin/jaksa sesuai struktur foldermu
        return view('admin.jaksa.index', compact('jaksas'));
    }

    /**
     * Menyimpan Data Jaksa Baru
     * PERBAIKAN: Menghapus manipulasi strtoupper agar penulisan gelar akademik rapi
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_jaksa' => 'required|string|max:255',
            'nip'        => 'required|string|unique:jaksas,nip',
        ]);

        Jaksa::create([
            // Disimpan sesuai inputan user (mendukung huruf besar-kecil untuk gelar)
            'nama_jaksa'       => $request->nama_jaksa,
            'nip'              => $request->nip,
            'pangkat_golongan' => '-', 
        ]);

        return redirect()->route('jaksa.index')->with('success', 'Personel JPN Berhasil Diregistrasi.');
    }

    /**
     * Menghapus Data Jaksa
     */
    public function destroy($id)
    {
        $jaksa = Jaksa::findOrFail($id);
        $jaksa->delete();

        return redirect()->route('jaksa.index')->with('success', 'Data Personel Telah Berhasil Dihapuskan.');
    }

    /**
     * Fitur Cetak Daftar Jaksa Berformat PDF
     * Menggunakan format resmi Kejaksaan Negeri Banjarmasin
     */
    public function cetakJaksa()
    {
        // Menggunakan withCount agar data total perkara akurat di laporan PDF
        $jaksas = Jaksa::withCount('perkaras')->get();

        // Memanggil file cetak_jaksa_pdf di folder admin/jaksa
        $pdf = Pdf::loadView('admin.jaksa.cetak_jaksa_pdf', compact('jaksas'))
                ->setPaper('a4', 'portrait');

        return $pdf->stream('SIM-DATUN_Daftar_Jaksa_JPN.pdf');
    }
}