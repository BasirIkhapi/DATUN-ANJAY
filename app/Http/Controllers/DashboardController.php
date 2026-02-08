<?php

namespace App\Http\Controllers;

use App\Models\Perkara;
use App\Models\Jaksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    /**
     * Dashboard Utama SIM-DATUN
     * Menampilkan statistik dan tabel pantauan real-time untuk semua user
     */
    public function index()
    {
        // 1. Ambil data statistik untuk card mewah
        // Disinkronkan dengan input kapital (PERDATA/TATA USAHA NEGARA)
        $total_perkara = Perkara::count();
        $perdata       = Perkara::where('jenis_perkara', 'PERDATA')->count();
        $tun           = Perkara::where('jenis_perkara', 'TATA USAHA NEGARA')->count();
        $proses        = Perkara::where('status_akhir', 'Proses')->count();
        $selesai       = Perkara::where('status_akhir', 'Selesai')->count();

        // 2. Ambil data tabel dengan relasi jaksa (Eager Loading)
        // Menggunakan latest() agar perkara baru yang kamu simpan muncul paling atas
        $perkaras = Perkara::with('jaksa')->latest()->get();

        // 3. Gabungkan data ke dalam satu array untuk dikirim ke view
        $data = [
            'total_perkara' => $total_perkara,
            'perdata'       => $perdata,
            'tun'           => $tun,
            'proses'        => $proses,
            'selesai'       => $selesai,
            'perkaras'      => $perkaras,
        ];

        // 4. Kirim data ke view dashboard
        return view('dashboard', $data);
    }

    /**
     * REPORT: Cetak Rekapitulasi Seluruh Perkara (PDF)
     */
    public function cetakRekap()
    {
        $semua_perkara = Perkara::with('jaksa')->orderBy('tanggal_masuk', 'desc')->get();

        $pdf = Pdf::loadView('admin.perkara.rekap_pdf', compact('semua_perkara'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('Rekapitulasi_Perkara_DATUN.pdf');
    }
}
