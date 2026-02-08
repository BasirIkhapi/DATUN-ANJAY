<!DOCTYPE html>
<html>
<head>
    <title>Laporan Arsip Perkara Selesai - SIM-DATUN</title>
    <style>
        /* Pengaturan Kertas Landscape Resmi */
        @page { 
            size: landscape; 
            margin: 1.5cm;
        }
        
        body { 
            font-family: 'Times New Roman', Times, serif; 
            font-size: 11pt; /* Sedikit lebih kecil agar muat banyak kolom di landscape */
            line-height: 1.4; 
            color: #333; 
        }
        
        /* Kop Surat Berjenjang Tetap Konsisten */
        .kop-surat { 
            border-bottom: 3px double #000; 
            padding-bottom: 5px; 
            margin-bottom: 20px; 
            text-align: center; 
            position: relative; 
        }
        .logo-kejaksaan { 
            position: absolute; 
            left: 50px; /* Disesuaikan untuk posisi landscape */
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
        
        /* Tabel Data Formal Landscape */
        .tabel-resmi { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px; 
        }
        .tabel-resmi th { 
            background-color: #f2f2f2; 
            border: 1px solid #000; 
            padding: 8px; 
            font-size: 9pt; 
            text-transform: uppercase; 
        }
        .tabel-resmi td { 
            border: 1px solid #000; 
            padding: 8px; 
            font-size: 9pt; 
            vertical-align: top; 
        }
        
        /* Bagian Tanda Tangan */
        .footer { 
            margin-top: 30px; 
        }
        .ttd-box { 
            float: right; 
            width: 30%; 
            text-align: center; 
            margin-top: 20px; 
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

    <div class="judul-laporan">REKAPITULASI ARSIP PERKARA SELESAI (INKRACHT)</div>

    <table class="tabel-resmi">
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="18%">Nomor Perkara</th>
                <th width="12%">Jenis Perkara</th>
                <th width="25%">Para Pihak (Penggugat/Tergugat)</th>
                <th width="20%">Jaksa JPN Pendamping</th>
                <th width="12%">Tanggal Selesai</th>
                <th width="10%">Status Akhir</th>
            </tr>
        </thead>
        <tbody>
            @forelse($perkara_selesai as $index => $p)
            <tr>
                <td align="center">{{ $index + 1 }}</td>
                <td>{{ $p->nomor_perkara }}</td>
                <td align="center">{{ $p->jenis_perkara }}</td>
                <td>
                    <strong>P:</strong> {{ $p->penggugat }}<br>
                    <strong>T:</strong> {{ $p->tergugat }}
                </td>
                <td>{{ $p->jaksa->nama_jaksa ?? 'Tidak Terdata' }}</td>
                <td align="center">{{ \Carbon\Carbon::parse($p->updated_at)->translatedFormat('d F Y') }}</td>
                <td align="center" style="font-weight: bold;">{{ strtoupper($p->status_akhir) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" align="center" style="padding: 20px;"><em>Belum ada arsip perkara yang berstatus selesai.</em></td>
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