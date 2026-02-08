<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Efektivitas Kinerja JPN - SIM-DATUN</title>
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; font-size: 11px; color: #333; margin: 0; padding: 0; }
        
        /* Kop Surat Resmi dengan Logo */
        .header-container { 
            text-align: center; 
            margin-bottom: 20px; 
            position: relative; 
            padding-top: 10px;
            min-height: 80px; 
        }
        .logo-instansi {
            position: absolute;
            left: 20px;
            top: 10px;
            width: 70px;
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

        /* Warna Performa */
        .high-performance { color: #059669; font-weight: bold; } /* Hijau untuk performa >= 75% */
        .normal-performance { color: #000; }

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
        {{-- Pastikan path logo benar --}}
        <img src="{{ public_path('img/logo jaksa.png') }}" class="logo-instansi">
        
        <h2>KEJAKSAAN AGUNG REPUBLIK INDONESIA</h2>
        <h1>KEJAKSAAN NEGERI BANJARMASIN</h1>
        <p>Jl. Adhyaksa No.1, Kayu Tangi, Banjarmasin, Kalimantan Selatan 70123</p>
        <div class="line-double"></div>
        <div class="line-single"></div>
    </div>

    <div class="title-container">
        <h4>LAPORAN EFEKTIVITAS KINERJA JAKSA PENGACARA NEGARA</h4>
        <p>DATA TER-UPDATE: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="35%">Nama Personel JPN</th>
                <th width="15%">Beban Perkara</th>
                <th width="15%">Selesai</th>
                <th width="15%">Proses</th>
                <th width="15%">Efektivitas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jaksas as $index => $jaksa)
                @php
                    $total = $jaksa->perkaras_count;
                    $selesai = $jaksa->perkaras->where('status_akhir', 'Selesai')->count();
                    $proses = $total - $selesai;
                    $persen = $total > 0 ? round(($selesai / $total) * 100) : 0;
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="font-bold text-uppercase">{{ $jaksa->nama_jaksa }}</td>
                    <td class="text-center">{{ $total }}</td>
                    <td class="text-center">{{ $selesai }}</td>
                    <td class="text-center">{{ $proses }}</td>
                    <td class="text-center {{ $persen >= 75 ? 'high-performance' : 'normal-performance' }}">
                        {{ $persen }}%
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

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