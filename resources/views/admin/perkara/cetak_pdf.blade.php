<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Monitoring Perkara - {{ $perkara->nomor_perkara }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.4; margin: 20px; }
        
        /* KOP SURAT */
        .kop-surat { position: relative; height: 100px; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .logo-kejaksaan { position: absolute; left: 0; top: 0; width: 70px; }
        .identitas-instansi { text-align: center; margin-left: 70px; }
        .identitas-instansi h1 { margin: 0; font-size: 16px; text-transform: uppercase; letter-spacing: 1px; }
        .identitas-instansi h2 { margin: 0; font-size: 18px; text-transform: uppercase; }
        .identitas-instansi p { margin: 2px 0 0; font-size: 10px; font-style: italic; }

        .judul-laporan { text-align: center; text-decoration: underline; font-weight: bold; text-transform: uppercase; font-size: 14px; margin: 20px 0; }

        .section-title { background: #f4f4f4; padding: 5px 10px; font-weight: bold; margin-top: 20px; text-transform: uppercase; font-size: 12px; border-left: 4px solid #059669; }
        
        .info-table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 12px; }
        .info-table td { padding: 4px 0; vertical-align: top; }
        .info-table td.label { width: 150px; color: #444; }
        .info-table td.value { font-weight: bold; }

        .timeline-table { width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 11px; }
        .timeline-table th { background: #059669; color: white; padding: 10px 8px; text-align: left; text-transform: uppercase; border: 1px solid #047857; }
        .timeline-table td { border: 1px solid #cbd5e1; padding: 8px; }

        /* FOOTER TANDA TANGAN */
        .footer-container { margin-top: 40px; width: 100%; }
        .tanda-tangan { float: right; width: 250px; text-align: center; font-size: 12px; }
        .tanda-tangan p { margin: 0; }
        .nama-pejabat { margin-top: 60px !important; font-weight: bold; }
    </style>
</head>
<body>
    {{-- KOP SURAT RESMI --}}
    <div class="kop-surat">
        <img src="{{ public_path('img/logo jaksa.png') }}" class="logo-kejaksaan">
        <div class="identitas-instansi">
            <h1>Kejaksaan Agung Republik Indonesia</h1>
            <h2>Kejaksaan Negeri Banjarmasin</h2>
            <p>Jl. Adhyaksa No.1, Kayu Tangi, Kec. Banjarmasin Utara, Kota Banjarmasin</p>
        </div>
    </div>

    <div class="judul-laporan">Lembar Kendali Progres Tahapan Perkara</div>

    <div class="section-title">Identitas Perkara</div>
    <table class="info-table">
        <tr>
            <td class="label">Nomor Registrasi</td>
            <td class="value">: {{ $perkara->nomor_perkara }}</td>
        </tr>
        <tr>
            <td class="label">Jaksa Pengacara Negara</td>
            <td class="value">: {{ $perkara->jaksa->nama_jaksa }}</td>
        </tr>
        <tr>
            <td class="label">Pihak Penggugat</td>
            <td class="value">: {{ $perkara->penggugat }}</td>
        </tr>
        <tr>
            <td class="label">Pihak Tergugat</td>
            <td class="value">: {{ $perkara->tergugat }}</td>
        </tr>
        <tr>
            <td class="label">Klasifikasi Perkara</td>
            <td class="value">: {{ $perkara->jenis_perkara }}</td>
        </tr>
        <tr>
            <td class="label">Status Akhir</td>
            <td class="value">: {{ strtoupper($perkara->status_akhir) }}</td>
        </tr>
    </table>

    <div class="section-title">Riwayat Persidangan / Tahapan</div>
    <table class="timeline-table">
        <thead>
            <tr>
                <th width="30" style="text-align: center;">No</th>
                <th width="110">Tanggal</th>
                <th width="160">Tahapan Sidang</th>
                <th>Hasil / Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($perkara->tahapans->sortBy('tanggal_tahapan') as $index => $tahapan)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                {{-- Format Tanggal Indonesia --}}
                <td>{{ \Carbon\Carbon::parse($tahapan->tanggal_tahapan)->translatedFormat('d F Y') }}</td>
                <td style="font-weight: bold; text-transform: uppercase;">{{ $tahapan->nama_tahapan }}</td>
                <td>{{ $tahapan->keterangan ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center; color: #94a3b8; padding: 20px;">Belum ada riwayat progres yang tercatat.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- BAGIAN TANDA TANGAN --}}
    <div class="footer-container">
        <div class="tanda-tangan">
            <p>Banjarmasin, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p>Petugas Administrasi Datun,</p>
            
            {{-- Nama sesuai aturan Kejaksaan: Tidak Kapital Semua & Tidak Garis Bawah --}}
            <p class="nama-pejabat">Basir Ikhapi</p>
            <p>NIP. 2210010341</p>
        </div>
        <div style="clear: both;"></div>
    </div>
</body>
</html>