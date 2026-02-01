<?php

namespace App\Http\Controllers;

use App\Models\Jaksa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class JaksaController extends Controller
{
    /**
     * Menampilkan Daftar Jaksa (JPN)
     */
    public function index()
    {
        // Menggunakan relasi 'perkaras' (jamak) sesuai model Jaksa
        $jaksas = Jaksa::with('perkaras')->latest()->get();
        return view('admin.jaksa.index', compact('jaksas'));
    }

    /**
     * Menyimpan Data Jaksa Baru
     * Perbaikan: Mengatasi error 'pangkat_golongan' doesn't have a default value
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_jaksa' => 'required|string|max:255',
            'nip'        => 'required|string|unique:jaksas,nip',
        ]);

        // Simpan dengan menyertakan kolom pangkat agar database tidak error
        Jaksa::create([
            'nama_jaksa'       => $request->nama_jaksa,
            'nip'              => $request->nip,
            'pangkat_golongan' => '-', // Nilai default agar tidak error SQL
        ]);

        return redirect()->route('jaksa.index')->with('success', 'Personel Jaksa berhasil didaftarkan!');
    }

    /**
     * Menghapus Data Jaksa
     */
    public function destroy($id)
    {
        $jaksa = Jaksa::findOrFail($id);
        $jaksa->delete();

        return redirect()->route('jaksa.index')->with('success', 'Data jaksa telah dihapus.');
    }

    /**
     * Fitur Cetak Daftar Jaksa
     * Perbaikan: Sinkronisasi nama file view sesuai folder
     */
    public function cetakJaksa()
    {
        // Hitung total perkara yang ditangani per jaksa
        $jaksas = Jaksa::withCount('perkaras')->get();

        // Nama view disesuaikan dengan image_5cb2be.png yaitu 'cetak_jaksa_pdf'
        $pdf = Pdf::loadView('admin.jaksa.cetak_jaksa_pdf', compact('jaksas'))
                ->setPaper('a4', 'portrait');

        return $pdf->stream('Daftar_Jaksa_JPN.pdf');
    }
}