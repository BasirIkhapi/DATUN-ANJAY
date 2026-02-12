<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Evaluasi Stagnansi Perkara - SIM-DATUN</title>
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; font-size: 10px; color: #333; margin: 0; padding: 0; }
        
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
            left: 30px; 
            top: 10px;
            width: 60px;
            height: auto;
        }
        .header-container h2 { margin: 0; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; }
        .header-container h1 { margin: 2px 0; font-size: 18px; text-transform: uppercase; }
        .header-container p { margin: 2px 0 0; font-size: 9px; font-style: italic; }
        
        /* Garis Khas Surat Dinas */
        .line-double { border-bottom: 3px solid #000; margin-top: 10px; }
        .line-single { border-bottom: 1px solid #000; margin-top: 2px; }

        /* Judul Laporan */
        .title-container { text-align: center; margin-bottom: 25px; text-transform: uppercase; }
        .title-container h4 { margin: 0; font-size: 12px; text-decoration: underline; }
        .title-container p { margin: 5px 0; font-size: 9px; font-weight: bold; color: #dc2626; }

        /* Tabel Styling */
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th { background-color: #f2f2f2; border: 1px solid #000; padding: 8px 5px; text-transform: uppercase; font-size: 8px; }
        td { border: 1px solid #000; padding: 6px 5px; vertical-align: top; line-height: 1.3; font-size: 9px; }
        
        .text-center { text-align: center; }
        .text-uppercase { text-transform: uppercase; }
        .font-bold { font-weight: bold; }
        .italic { font-style: italic; }

        /* Indikator Peringatan */
        .warning-badge { color: #dc2626; font-weight: bold; }

        /* Tanda Tangan */
        .footer-sign { margin-top: 30px; width: 100%; }
        .sign-table { width: 100%; border: none; }
        .sign-table td { border: none !important; text-align: center; padding: 0; }
        .space-ttd { height: 60px; }
    </style>
</head>
<body>

    {{-- KOP SURAT BERLOGO --}}
    <div class="header-container">
        {{-- Gunakan path absolut untuk PDF --}}
        <img src="{{ public_path('img/logo jaksa.png') }}" class="logo-instansi">
        <h2>KEJAKSAAN AGUNG REPUBLIK INDONESIA</h2>
        <h1>KEJAKSAAN NEGERI BANJARMASIN</h1>
        <p>Jl. Adhyaksa No.1, Kayu Tangi, Banjarmasin, Kalimantan Selatan 70123</p>
        <div class="line-double"></div>
        <div class="line-single"></div>
    </div>

    <div class="title-container">
        <h4>LAPORAN EVALUASI STAGNANSI PERKARA (OUTSTANDING REPORT)</h4>
        <p>KRITERIA: PERKARA AKTIF TANPA PROGRES LEBIH DARI 14 HARI</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="18%">Nomor Perkara</th>
                <th width="20%">Para Pihak (P/T)</th>
                <th width="18%">Jaksa Pengacara Negara</th>
                <th width="12%">Tgl Registrasi</th>
                <th width="15%">Update Terakhir</th>
                <th width="13%">Masa Vakum</th>
            </tr>
        </thead>
        <tbody>
            @forelse($perkaras as $index => $perkara)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="font-bold text-uppercase italic">{{ $perkara->nomor_perkara }}</td>
                    <td>
                        <span class="font-bold">P:</span> {{ $perkara->penggugat }}<br>
                        <span class="font-bold">T:</span> {{ $perkara->tergugat }}
                    </td>
                    <td class="text-uppercase">{{ $perkara->jaksa->nama_jaksa ?? 'TIDAK TERSEDIA' }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($perkara->tanggal_masuk)->format('d/m/Y') }}</td>
                    <td class="text-center">
                        {{-- Mengambil tanggal update terakhir sesuai attribute di Model --}}
                        {{ $perkara->tgl_akhir ?? \Carbon\Carbon::parse($perkara->tanggal_masuk)->format('d/m/Y') }}
                    </td>
                    <td class="text-center warning-badge italic">
                        {{ $perkara->hari_stagnan }} Hari
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center italic" style="padding: 25px; font-size: 11px; color: #059669;">
                        Hasil Evaluasi: Tidak ditemukan perkara yang mengalami stagnansi (macet) pada periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="font-size: 8px; font-style: italic; color: #666; margin-top: -5px;">
        * Laporan ini dihasilkan otomatis oleh sistem SIM-DATUN sebagai instrumen Early Warning System (EWS) untuk menjaga akurasi data.
    </div>

    {{-- TANDA TANGAN --}}
    <div class="footer-sign">
        <table class="sign-table">
            <tr>
                <td width="65%"></td>
                <td width="35%">
                    <p>Banjarmasin, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                    <p class="font-bold text-uppercase">Kepala Seksi Perdata dan TUN</p>
                    <div class="space-ttd"></div>
                    <p class="font-bold text-uppercase" style="text-decoration: underline;">H. AKHMAD BUDI S., S.H., M.H.</p>
                    <p>Jaksa Utama Pratama / NIP. 19780521 200212 1 002</p>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>