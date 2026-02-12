<?php

namespace App\Http\Controllers;

use App\Models\Jaksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class JaksaController extends Controller
{
    /**
     * TAMPILAN UTAMA: Daftar Jaksa JPN
     */
    public function index()
    {
        $jaksas = Jaksa::latest()->get();
        return view('admin.jaksa.index', compact('jaksas'));
    }

    /**
     * FITUR CETAK: Laporan Daftar Jaksa (PDF)
     */
    public function cetak()
    {
        $jaksas = Jaksa::latest()->get();
        $pdf = Pdf::loadView('admin.jaksa.pdf', compact('jaksas'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Daftar_Jaksa_JPN_Banjarmasin.pdf');
    }

    /**
     * SIMPAN DATA: Tambah Jaksa Baru
     * Disesuaikan dengan kolom: nip, pangkat_golongan
     */
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Otoritas Gagal: Hanya Admin yang dapat menambah personel Jaksa.');
        }

        // VALIDASI: Menggunakan 'nip' sesuai struktur database kamu
        $request->validate([
            'nama_jaksa'       => 'required|string|max:255',
            'nip'              => 'required|string|unique:jaksas,nip',
            'pangkat_golongan' => 'required|string',
        ]);

        // CREATE: Memastikan field matching dengan database
        Jaksa::create([
            'nama_jaksa' => strtoupper($request->nama_jaksa),
            'nip'              => $request->nip,
            'pangkat_golongan' => $request->pangkat_golongan,
        ]);

        return redirect()->back()->with('success', 'Data Jaksa berhasil disimpan!');
    }

    /**
     * UPDATE DATA: Perbarui Profil Jaksa
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Otoritas ditolak.');
        }

        $jaksa = Jaksa::findOrFail($id);

        $request->validate([
            'nama_jaksa'       => 'required|string|max:255',
            'nip'              => 'required|string|unique:jaksas,nip,' . $id,
            'pangkat_golongan' => 'required|string',
        ]);

        $jaksa->update($request->all());

        return redirect()->route('jaksa.index')->with('success', 'Data Jaksa berhasil diperbarui.');
    }

    /**
     * HAPUS DATA: Hapus Personel Jaksa
     */
    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Otoritas ditolak.');
        }

        $jaksa = Jaksa::findOrFail($id);
        $jaksa->delete();

        return redirect()->route('jaksa.index')->with('success', 'Data Jaksa telah berhasil dihapus.');
    }
}
