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
     * Menampilkan statistik card dan grafik tren perkara bulanan (Perdata vs TUN)
     */
    public function index()
    {
        $tahunSekarang = date('Y');

        // 1. Ambil data statistik untuk card dashboard
        $total_perkara = Perkara::count();
        $perdata       = Perkara::whereIn('jenis_perkara', ['PERDATA', 'Perdata'])->count();
        $tun           = Perkara::whereIn('jenis_perkara', ['TATA USAHA NEGARA', 'TUN', 'Tata Usaha Negara'])->count();
        $proses        = Perkara::where('status_akhir', 'Proses')->count();
        $selesai       = Perkara::where('status_akhir', 'Selesai')->count();

        // 2. Logika Grafik Terpisah: Perdata vs TUN
        $dataGrafikPerdata = [];
        $dataGrafikTun = [];

        for ($m = 1; $m <= 12; $m++) {
            // Hitung Perdata per bulan
            $dataGrafikPerdata[] = Perkara::whereIn('jenis_perkara', ['PERDATA', 'Perdata'])
                ->whereYear('tanggal_masuk', $tahunSekarang)
                ->whereMonth('tanggal_masuk', $m)
                ->count();

            // Hitung TUN per bulan
            $dataGrafikTun[] = Perkara::whereIn('jenis_perkara', ['TATA USAHA NEGARA', 'TUN', 'Tata Usaha Negara'])
                ->whereYear('tanggal_masuk', $tahunSekarang)
                ->whereMonth('tanggal_masuk', $m)
                ->count();
        }

        // 3. Ambil data perkara terbaru untuk tabel pantauan real-time
        $perkaras = Perkara::with('jaksa')->latest()->take(10)->get();

        // 4. Kirim data ke view dashboard
        return view('dashboard', compact(
            'total_perkara',
            'perdata',
            'tun',
            'proses',
            'selesai',
            'perkaras',
            'dataGrafikPerdata', // Array data Perdata untuk Chart.js
            'dataGrafikTun',     // Array data TUN untuk Chart.js
            'tahunSekarang'
        ));
    }

    /**
     * Fitur Data Jaksa (Manajemen Personel JPN)
     */
    public function jaksaIndex()
    {
        $jaksas = Jaksa::withCount('perkaras')->get();
        return view('admin.jaksa.index', compact('jaksas'));
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
