<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Detail Perkara - {{ $perkara->nomor_perkara }}</title>
    <style>
        /* Pengaturan Dasar Dokumen Resmi */
        body { 
            font-family: 'Times New Roman', Times, serif; 
            font-size: 12pt; 
            line-height: 1.4; 
            color: #000; 
            margin: 0.5cm; 
        }
        
        /* Kop Surat Resmi Kejaksaan */
        .kop-container { 
            width: 100%; 
            border-bottom: 4px double #000; 
            padding-bottom: 12px; 
            margin-bottom: 25px; 
        }
        .table-kop { 
            width: 100%; 
            border: none; 
        }
        
        /* Logo Box (Diperbesar agar Gagah) */
        .logo-box { 
            width: 110px; 
            text-align: center; 
            vertical-align: middle; 
        }
        
        /* Teks Instansi Tengah */
        .text-box { 
            text-align: center; 
            vertical-align: middle; 
            padding-right: 110px; /* Offset seimbang dengan lebar logo box */
        } 
        
        .text-box h2 { font-size: 14pt; margin: 0; font-weight: normal; text-transform: uppercase; letter-spacing: 1px; }
        .text-box h1 { font-size: 17pt; margin: 2px 0; font-weight: bold; text-transform: uppercase; }
        .text-box p { font-size: 10pt; margin: 1px 0; font-style: italic; font-weight: normal; }

        /* Judul Laporan Dinamis */
        .judul-dokumen { 
            text-align: center; 
            font-weight: bold; 
            text-decoration: underline; 
            text-transform: uppercase; 
            margin: 30px 0; 
            font-size: 13pt; 
        }

        /* Tabel Identitas Perkara */
        .info-perkara { width: 100%; margin-bottom: 25px; border: none; }
        .info-perkara td { padding: 4px 0; vertical-align: top; }
        .label { width: 30%; }
        .separator { width: 3%; }
        .content { width: 67%; font-weight: bold; }

        /* Tabel Riwayat Sidang (Kronologis) */
        .tabel-riwayat { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .tabel-riwayat th { 
            border: 1px solid #000; 
            padding: 10px; 
            font-size: 10pt; 
            background-color: #f2f2f2; 
            text-transform: uppercase; 
            font-weight: bold; 
        }
        .tabel-riwayat td { 
            border: 1px solid #000; 
            padding: 10px; 
            font-size: 10pt; 
            vertical-align: top; 
        }
        
        /* Tanda Tangan Kasi Datun */
        .ttd-container { margin-top: 60px; width: 100%; }
        .ttd-box { float: right; width: 300px; text-align: center; }
        .ttd-box p { margin: 0; }
        .space-ttd { height: 80px; }
    </style>
</head>
<body>

    {{-- HEADER KOP SURAT --}}
    <div class="kop-container">
        <table class="table-kop">
            <tr>
                <td class="logo-box">
                    @php
                        // Memastikan logo terbaca sebagai base64 agar aman di DomPDF
                        $path = public_path('img/logo jaksa.png');
                        if (file_exists($path)) {
                            $type = pathinfo($path, PATHINFO_EXTENSION);
                            $data = file_get_contents($path);
                            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                        } else {
                            $base64 = ''; // Fallback jika logo tidak ditemukan
                        }
                    @endphp
                    @if($base64)
                        <img src="{{ $base64 }}" width="100">
                    @endif
                </td>
                <td class="text-box">
                    <h2>KEJAKSAAN AGUNG REPUBLIK INDONESIA</h2>
                    <h2>KEJAKSAAN TINGGI KALIMANTAN SELATAN</h2>
                    <h1>KEJAKSAAN NEGERI BANJARMASIN</h1>
                    <p>Jl. Adhyaksa No.1, Kayu Tangi, Banjarmasin. Kode Pos: 70123</p>
                    <p>Telp: (0511) 3300061, Email: dtn.kejari.bjm@gmail.com</p>
                </td>
            </tr>
        </table>
    </div>

    {{-- JUDUL LAPORAN DINAMIS --}}
    <div class="judul-dokumen">{{ $judulLaporan }}</div>

    {{-- INFORMASI DATA PERKARA --}}
    <table class="info-perkara">
        <tr>
            <td class="label">Nomor Register Perkara</td>
            <td class="separator">:</td>
            <td class="content">{{ $perkara->nomor_perkara }}</td>
        </tr>
        <tr>
            <td class="label">Jenis Perkara</td>
            <td class="separator">:</td>
            <td class="content">{{ $perkara->jenis_perkara }}</td>
        </tr>
        <tr>
            <td class="label">Jaksa Pengacara Negara</td>
            <td class="separator">:</td>
            <td class="content">{{ $perkara->jaksa->nama_jaksa }}</td>
        </tr>
        <tr>
            <td class="label">Para Pihak</td>
            <td class="separator">:</td>
            <td class="content">{{ $perkara->penggugat }} (P) vs {{ $perkara->tergugat }} (T)</td>
        </tr>
        <tr>
            <td class="label">Status Saat Ini</td>
            <td class="separator">:</td>
            <td class="content">{{ $perkara->status_akhir }}</td>
        </tr>
    </table>

    {{-- TABEL KRONOLOGIS SIDANG --}}
    <table class="tabel-riwayat">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Tanggal Sidang</th>
                <th width="25%">Agenda / Tahapan</th>
                <th width="50%">Ringkasan Hasil Persidangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($perkara->tahapans->sortBy('tanggal') as $index => $t)
            <tr>
                <td align="center">{{ $index + 1 }}</td>
                <td align="center">{{ \Carbon\Carbon::parse($t->tanggal)->translatedFormat('d F Y') }}</td>
                <td><strong>{{ $t->nama_tahapan }}</strong></td>
                <td>{{ $t->keterangan ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" align="center"><em>Data riwayat persidangan belum tersedia dalam database.</em></td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- BAGIAN TANDA TANGAN --}}
    <div class="ttd-container">
        <div class="ttd-box">
            <p>Banjarmasin, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p><strong>KEPALA SEKSI DATUN,</strong></p>
            <div class="space-ttd"></div>
            <p><strong><u>{{ Auth::user()->name }}</u></strong></p>
            <p>Jaksa Pratama / NIP. .........................</p>
        </div>
    </div>

</body>
</html>