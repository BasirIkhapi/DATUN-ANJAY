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
        // Mengambil data jaksa terbaru beserta relasi perkara untuk indikator beban kerja
        $jaksas = Jaksa::with('perkaras')->latest()->get();
        return view('admin.jaksa.index', compact('jaksas'));
    }

    /**
     * Menyimpan Data Jaksa Baru
     * Mendukung input Pangkat/Golongan otomatis dari Dropdown
     */
    public function store(Request $request)
    {
        // 1. Validasi Input termasuk field pangkat_golongan
        $request->validate([
            'nama_jaksa'       => 'required|string|max:255',
            'nip'              => 'required|string|unique:jaksas,nip',
            'pangkat_golongan' => 'required|string|max:255',
        ]);

        // 2. Simpan ke Database menggunakan Mass Assignment
        Jaksa::create([
            'nama_jaksa'       => $request->nama_jaksa,
            'nip'              => $request->nip,
            'pangkat_golongan' => $request->pangkat_golongan,
        ]);

        return redirect()->route('jaksa.index')->with('success', 'Personel JPN Berhasil Diregistrasi.');
    }

    /**
     * Menghapus Data Jaksa
     */
    public function destroy($id)
    {
        $jaksa = Jaksa::findOrFail($id);

        // Menghapus data personel secara permanen
        $jaksa->delete();

        return redirect()->route('jaksa.index')->with('success', 'Data Personel Berhasil Dihapuskan.');
    }

    /**
     * Fitur Cetak Daftar Jaksa Berformat PDF
     */
    public function cetakJaksa()
    {
        // Menggunakan withCount agar di laporan PDF muncul jumlah beban perkara tiap jaksa
        $jaksas = Jaksa::withCount('perkaras')->get();

        $pdf = Pdf::loadView('admin.jaksa.cetak_jaksa_pdf', compact('jaksas'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('SIM-DATUN_Daftar_Jaksa_JPN.pdf');
    }
}
