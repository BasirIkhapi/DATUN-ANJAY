<!DOCTYPE html>
<html>
<head>
    <title>Daftar Jaksa JPN - SIM-DATUN</title>
    <style>
        /* Standar Font Resmi Kejaksaan */
        body { 
            font-family: 'Times New Roman', Times, serif; 
            font-size: 11pt; 
            line-height: 1.4; 
            color: #000; 
        }
        
        /* Kop Surat Berjenjang */
        .kop-surat { 
            border-bottom: 3px double #000; 
            padding-bottom: 5px; 
            margin-bottom: 20px; 
            text-align: center; 
            position: relative; 
        }
        .logo-kejaksaan { 
            position: absolute; 
            left: 10px; 
            top: 0; 
            width: 70px; 
        }
        .header-text h2 { 
            margin: 0; 
            font-size: 13pt; 
            text-transform: uppercase; 
        }
        .header-text h1 { 
            margin: 0; 
            font-size: 15pt; 
            text-transform: uppercase; 
        }
        .header-text p { 
            margin: 0; 
            font-size: 9pt; 
            font-style: italic; 
        }
        
        /* Judul Dokumen */
        .judul-laporan { 
            text-align: center; 
            text-decoration: underline; 
            font-weight: bold; 
            margin-bottom: 25px; 
            text-transform: uppercase; 
            font-size: 12pt; 
        }
        
        /* Tabel Data Formal */
        .tabel-resmi { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px; 
        }
        .tabel-resmi th { 
            background-color: #f2f2f2; 
            border: 1px solid #000; 
            padding: 10px 8px; 
            font-size: 10pt; 
            text-transform: uppercase; 
        }
        .tabel-resmi td { 
            border: 1px solid #000; 
            padding: 10px 8px; 
            font-size: 11pt; 
            vertical-align: middle; 
        }
        
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        
        /* Bagian Tanda Tangan */
        .footer { 
            margin-top: 30px; 
        }
        .ttd-box { 
            float: right; 
            width: 45%; 
            text-align: center; 
            margin-top: 30px; 
        }
        .clear { 
            clear: both; 
        }
    </style>
</head>
<body>
    {{-- KOP SURAT STANDAR KEJAKSAAN --}}
    <div class="kop-surat">
        <img src="{{ public_path('img/logo jaksa.png') }}" class="logo-kejaksaan">
        <div class="header-text">
            <h2>KEJAKSAAN AGUNG REPUBLIK INDONESIA</h2>
            <h1>KEJAKSAAN NEGERI BANJARMASIN</h1>
            <p>Jl. Adhyaksa No.1, Kayu Tangi, Kec. Banjarmasin Utara, Kota Banjarmasin</p>
        </div>
    </div>

    <div class="judul-laporan">DAFTAR PERSONEL JAKSA PENGACARA NEGARA (JPN) AKTIF</div>

    <table class="tabel-resmi">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="40%">Nama Lengkap Personel</th>
                <th width="25%">NIP / NRP</th>
                <th width="30%">Pangkat / Golongan</th>
                {{-- Kolom Beban Kerja Telah Dihapus --}}
            </tr>
        </thead>
        <tbody>
            @forelse($jaksas as $index => $jaksa)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td><strong>{{ strtoupper($jaksa->nama_jaksa) }}</strong></td>
                <td class="text-center">{{ $jaksa->nip ?? '-' }}</td>
                <td class="text-center italic">{{ $jaksa->pangkat_golongan ?? '-' }}</td>
                {{-- Data Beban Kerja Telah Dihapus --}}
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center"><em>Data personel JPN tidak ditemukan.</em></td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- PENUTUP LAPORAN --}}
    <div class="footer">
        <div class="ttd-box">
            <p>Banjarmasin, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p>Kepala Seksi Perdata dan TUN,</p>
            <br><br><br><br>
            <p><strong>......................................................</strong></p>
            <p>Jaksa Utama Pratama / NIP.</p>
        </div>
        <div class="clear"></div>
    </div>
</body>
</html>