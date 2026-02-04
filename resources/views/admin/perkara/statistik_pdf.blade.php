<!DOCTYPE html>
<html>
<head>
    <title>Laporan Statistik Perkara - SIM-DATUN</title>
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

        /* Ringkasan Data */
        .summary-box {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #000;
            width: 50%;
        }
        .summary-box td {
            font-size: 11pt;
            padding: 2px 5px;
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

    <div class="judul-laporan">LAPORAN STATISTIK PERDATA DAN TATA USAHA NEGARA</div>

    {{-- RINGKASAN DATA STATISTIK --}}
    <div class="summary-box">
        <table>
            <tr>
                <td width="150">Total Seluruh Perkara</td>
                <td>:</td>
                <td><strong>{{ $total }} Perkara</strong></td>
            </tr>
            <tr>
                <td>Perkara Perdata</td>
                <td>:</td>
                <td>{{ $perdata }} Perkara</td>
            </tr>
            <tr>
                <td>Perkara T.U.N</td>
                <td>:</td>
                <td>{{ $tun }} Perkara</td>
            </tr>
        </table>
    </div>

    {{-- TABEL RINCIAN PERKARA --}}
    <table class="tabel-resmi">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%">Nomor Perkara</th>
                <th width="15%">Jenis</th>
                <th width="35%">Para Pihak</th>
                <th width="20%">Status Akhir</th>
            </tr>
        </thead>
        <tbody>
            @forelse($daftar_perkara as $index => $p)
            <tr>
                <td align="center">{{ $index + 1 }}</td>
                <td>{{ $p->nomor_perkara }}</td>
                <td align="center">{{ $p->jenis_perkara }}</td>
                <td>
                    <strong>P:</strong> {{ $p->penggugat }}<br>
                    <strong>T:</strong> {{ $p->tergugat }}
                </td>
                <td align="center">{{ strtoupper($p->status_akhir) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" align="center"><em>Belum ada data perkara terdaftar.</em></td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- PENUTUP LAPORAN --}}
    <div class="footer">
        <div class="ttd-box">
            <p>Banjarmasin, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p>Petugas Administrasi Datun,</p>
            <br><br><br>
            <p><strong>{{ auth()->user()->name }}</strong></p>
            <p>NIP. {{ auth()->user()->nip ?? '..........................' }}</p>
        </div>
        <div class="clear"></div>
    </div>
</body>
</html>