<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekapitulasi Perkara - SIM-DATUN</title>
    <style>
        /* Pengaturan Halaman Resmi Landscape */
        @page { 
            size: landscape;
            margin: 1.5cm; 
        }
        body { 
            font-family: 'Times New Roman', Times, serif; 
            font-size: 11pt; 
            line-height: 1.5;
            color: #000;
        }

        /* Kop Surat Berjenjang Standar Kejaksaan */
        .kop-surat { 
            border-bottom: 3px double #000; 
            padding-bottom: 5px; 
            margin-bottom: 20px; 
            text-align: center; 
            position: relative;
        }
        .logo-kejaksaan { 
            position: absolute; 
            left: 50px; 
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
            text-transform: uppercase; 
            font-size: 12pt; 
            font-weight: bold; 
            margin-bottom: 25px; 
            text-decoration: underline;
        }

        /* Tabel Rekapitulasi Formal */
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px;
        }
        th { 
            background-color: #f2f2f2; 
            color: #000; 
            padding: 10px 5px; 
            text-align: center; 
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10pt;
            border: 1px solid #000;
        }
        td { 
            border: 1px solid #000; 
            padding: 8px; 
            vertical-align: top;
            font-size: 10pt;
        }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }

        /* Footer Tanda Tangan */
        .footer-section { 
            margin-top: 40px; 
            width: 100%;
        }
        .signature-box {
            float: right;
            width: 300px;
            text-align: center;
        }
        .sig-name { 
            font-weight: bold; 
            text-decoration: underline; 
            text-transform: uppercase;
            margin-top: 60px;
        }
        .clear { clear: both; }
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

    {{-- JUDUL LAPORAN --}}
    <div class="judul-laporan">REKAPITULASI DATA PERKARA PERDATA DAN TATA USAHA NEGARA</div>

    {{-- TABEL DATA --}}
    <table>
        <thead>
            <tr>
                <th width="3%">NO</th>
                <th width="18%">NOMOR PERKARA</th>
                <th width="10%">TGL MASUK</th>
                <th width="20%">PENGGUGAT / TERGUGAT</th>
                <th width="10%">JENIS</th>
                <th width="18%">JAKSA PENYELIDIK (JPN)</th>
                <th width="12%">STATUS AKHIR</th>
            </tr>
        </thead>
        <tbody>
            @forelse($semua_perkara as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="font-bold">{{ $item->nomor_perkara }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_masuk)->translatedFormat('d/m/Y') }}</td>
                <td>
                    <strong>P:</strong> {{ strtoupper($item->penggugat) }}<br>
                    <strong>T:</strong> {{ strtoupper($item->tergugat) }}
                </td>
                <td class="text-center">{{ $item->jenis_perkara }}</td>
                <td>{{ $item->jaksa->nama_jaksa ?? 'Belum Ditentukan' }}</td>
                <td class="text-center font-bold">
                    {{ strtoupper($item->status_akhir) }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center" style="padding: 40px; font-style: italic;">
                    Tidak ditemukan data perkara dalam basis data untuk direkapitulasi.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- FOOTER TANDA TANGAN --}}
    <div class="footer-section">
        <div class="signature-box">
            <p>Banjarmasin, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p>Petugas Administrasi Datun,</p>
            <br><br><br>
            <p class="sig-name">{{ Auth::user()->name }}</p>
            <p style="margin-top: -5px; font-size: 10pt;">NIP. {{ Auth::user()->nip ?? '..........................' }}</p>
        </div>
        <div class="clear"></div>
    </div>
</body>
</html>