<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Durasi Penanganan Perkara - SIM-DATUN</title>
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; font-size: 11px; color: #333; margin: 0; padding: 0; }
        
        /* Kop Surat Resmi dengan Logo */
        .header-container { 
            text-align: center; 
            margin-bottom: 20px; 
            position: relative; 
            padding-top: 10px;
            min-height: 80px; /* Memberi ruang untuk logo */
        }
        .logo-instansi {
            position: absolute;
            left: 20px;
            top: 10px;
            width: 70px; /* Ukuran logo disesuaikan */
            height: auto;
        }
        .header-container h2 { margin: 0; font-size: 16px; text-transform: uppercase; letter-spacing: 1px; }
        .header-container h1 { margin: 2px 0; font-size: 20px; text-transform: uppercase; }
        .header-container p { margin: 2px 0 0; font-size: 10px; font-style: italic; }
        
        /* Garis Khas Surat Dinas */
        .line-double { border-bottom: 3px solid #000; margin-top: 10px; }
        .line-single { border-bottom: 1px solid #000; margin-top: 2px; }

        /* Judul Laporan */
        .title-container { text-align: center; margin-bottom: 25px; text-transform: uppercase; }
        .title-container h4 { margin: 0; font-size: 14px; text-decoration: underline; }
        .title-container p { margin: 5px 0; font-size: 10px; font-weight: bold; }

        /* Tabel Styling */
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background-color: #f2f2f2; border: 1px solid #000; padding: 10px 5px; text-transform: uppercase; font-size: 9px; }
        td { border: 1px solid #000; padding: 8px 5px; vertical-align: middle; }
        
        .text-center { text-align: center; }
        .text-uppercase { text-transform: uppercase; }
        .font-bold { font-weight: bold; }
        .italic { font-style: italic; }

        /* Summary Box */
        .avg-box { background-color: #f9fafb; border: 1px solid #000; padding: 12px; margin-top: 10px; width: fit-content; }

        /* Tanda Tangan */
        .footer-sign { margin-top: 40px; width: 100%; }
        .sign-table { width: 100%; border: none; }
        .sign-table td { border: none; text-align: center; padding: 0; }
        .space-ttd { height: 75px; }
    </style>
</head>
<body>

    {{-- KOP SURAT DENGAN LOGO --}}
    <div class="header-container">
        {{-- Menggunakan base_path atau public_path untuk rendering PDF yang lebih stabil --}}
        <img src="{{ public_path('img/logo jaksa.png') }}" class="logo-instansi">
        
        <h2>KEJAKSAAN AGUNG REPUBLIK INDONESIA</h2>
        <h1>KEJAKSAAN NEGERI BANJARMASIN</h1>
        <p>Jl. Adhyaksa No.1, Kayu Tangi, Banjarmasin, Kalimantan Selatan 70123</p>
        <div class="line-double"></div>
        <div class="line-single"></div>
    </div>

    <div class="title-container">
        <h4>LAPORAN DURASI PENANGANAN PERKARA (AGING REPORT)</h4>
        <p>PERIODE DATA: S.D {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="24%">Nomor Perkara</th>
                <th width="24%">Jaksa Pengacara Negara</th>
                <th width="16%">Tanggal Masuk</th>
                <th width="16%">Tanggal Selesai</th>
                <th width="16%">Durasi Efektif</th>
            </tr>
        </thead>
        <tbody>
            @forelse($perkaras as $index => $perkara)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="font-bold text-uppercase italic">{{ $perkara->nomor_perkara }}</td>
                    <td class="text-uppercase">{{ $perkara->jaksa->nama_jaksa ?? 'TIDAK TERSEDIA' }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($perkara->tanggal_masuk)->format('d/m/Y') }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($perkara->updated_at)->format('d/m/Y') }}</td>
                    <td class="text-center font-bold">
                        {{ $perkara->durasi_hari }} Hari
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center italic" style="padding: 20px;">Data perkara selesai tidak ditemukan dalam database.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="avg-box">
        <span class="font-bold uppercase">Rata-Rata Waktu Penyelesaian: {{ $rata_rata }} Hari Kerja</span>
    </div>

    {{-- TANDA TANGAN --}}
    <div class="footer-sign">
        <table class="sign-table">
            <tr>
                <td width="60%"></td>
                <td width="40%">
                    <p>Banjarmasin, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                    <p class="font-bold text-uppercase">Kepala Seksi Perdata dan TUN</p>
                    <div class="space-ttd"></div>
                    <p class="font-bold text-uppercase" style="text-decoration: underline;">......................................................</p>
                    <p>Jaksa Utama Pratama / NIP.</p>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>