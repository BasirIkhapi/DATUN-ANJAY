<!DOCTYPE html>
<html>
<head>
    <title>Daftar Jaksa JPN - SIM-DATUN</title>
    <style>
        /* Standar Font Resmi Kejaksaan */
        body { 
            font-family: 'Times New Roman', Times, serif; 
            font-size: 12pt; 
            line-height: 1.5; 
            color: #333; 
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
            left: 0; 
            top: 0; 
            width: 80px; 
        }
        .header-text h2 { 
            margin: 0; 
            font-size: 14pt; 
            text-transform: uppercase; 
        }
        .header-text h1 { 
            margin: 0; 
            font-size: 16pt; 
            text-transform: uppercase; 
        }
        .header-text p { 
            margin: 0; 
            font-size: 10pt; 
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
            padding: 10px; 
            font-size: 10pt; 
            text-transform: uppercase; 
        }
        .tabel-resmi td { 
            border: 1px solid #000; 
            padding: 10px; 
            font-size: 10pt; 
            vertical-align: top; 
        }
        
        /* Bagian Tanda Tangan */
        .footer { 
            margin-top: 30px; 
        }
        .ttd-box { 
            float: right; 
            width: 40%; 
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
                <th>Nama Lengkap Personel</th>
                <th width="25%">NIP / NRP</th>
                <th width="20%">Total Perkara</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jaksas as $index => $jaksa)
            <tr>
                <td align="center">{{ $index + 1 }}</td>
                <td><strong>{{ strtoupper($jaksa->nama_jaksa) }}</strong></td>
                <td align="center">{{ $jaksa->nip ?? '-' }}</td>
                <td align="center">{{ $jaksa->perkaras_count ?? 0 }} Perkara</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" align="center"><em>Data personel JPN tidak ditemukan.</em></td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- PENUTUP LAPORAN --}}
    <div class="footer">
        <div class="ttd-box">
            <p>Banjarmasin, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p>Admin SIM-DATUN,</p>
            <br><br><br>
            <p><strong>{{ auth()->user()->name }}</strong></p>
            <p>NIP. {{ auth()->user()->nip ?? '..........................' }}</p>
        </div>
        <div class="clear"></div>
    </div>
</body>
</html>