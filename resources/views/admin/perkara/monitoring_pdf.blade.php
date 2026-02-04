<!DOCTYPE html>
<html>
<head>
    <title>Laporan Progres Perkara - {{ $perkara->nomor_perkara }}</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.5; color: #333; }
        .kop-surat { border-bottom: 3px double #000; padding-bottom: 5px; margin-bottom: 20px; text-align: center; }
        .logo-kejaksaan { position: absolute; left: 0; top: 0; width: 80px; }
        .header-text h2 { margin: 0; font-size: 14pt; text-transform: uppercase; }
        .header-text h1 { margin: 0; font-size: 16pt; text-transform: uppercase; }
        .header-text p { margin: 0; font-size: 10pt; italic; }
        
        .judul-laporan { text-align: center; text-decoration: underline; font-weight: bold; margin-bottom: 20px; text-transform: uppercase; }
        
        .info-table { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
        .info-table td { padding: 5px; vertical-align: top; }
        .label { width: 30%; font-weight: bold; }
        .titik-dua { width: 3%; }

        .tabel-progres { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .tabel-progres th { background-color: #f2f2f2; border: 1px solid #000; padding: 10px; font-size: 10pt; text-transform: uppercase; }
        .tabel-progres td { border: 1px solid #000; padding: 10px; font-size: 10pt; vertical-align: top; }
        
        .footer { mt: 30px; }
        .ttd-box { float: right; width: 40%; text-align: center; margin-top: 30px; }
        .clear { clear: both; }
    </style>
</head>
<body>
    {{-- KOP SURAT RESMI --}}
    <div class="kop-surat">
        <img src="{{ public_path('img/logo jaksa.png') }}" class="logo-kejaksaan">
        <div class="header-text">
            <h2>KEJAKSAAN AGUNG REPUBLIK INDONESIA</h2>
            <h1>KEJAKSAAN NEGERI BANJARMASIN</h1>
            <p>Jl. Adhyaksa No.1, Kayu Tangi, Kec. Banjarmasin Utara, Kota Banjarmasin</p>
        </div>
    </div>

    <div class="judul-laporan">LEMBAR KENDALI PROGRES TAHAPAN PERKARA</div>

    {{-- INFORMASI PERKARA --}}
    <table class="info-table">
        <tr>
            <td class="label">Nomor Registrasi</td>
            <td class="titik-dua">:</td>
            <td><strong>{{ $perkara->nomor_perkara }}</strong></td>
        </tr>
        <tr>
            <td class="label">Jenis Perkara</td>
            <td class="titik-dua">:</td>
            <td>{{ $perkara->jenis_perkara }}</td>
        </tr>
        <tr>
            <td class="label">Pihak Penggugat</td>
            <td class="titik-dua">:</td>
            <td>{{ $perkara->penggugat }}</td>
        </tr>
        <tr>
            <td class="label">Pihak Tergugat</td>
            <td class="titik-dua">:</td>
            <td>{{ $perkara->tergugat }}</td>
        </tr>
        <tr>
            <td class="label">Jaksa JPN Pendamping</td>
            <td class="titik-dua">:</td>
            <td>{{ $perkara->jaksa->nama_jaksa ?? 'BELUM DITUNJUK' }}</td>
        </tr>
        <tr>
            <td class="label">Status Saat Ini</td>
            <td class="titik-dua">:</td>
            <td><strong>{{ strtoupper($perkara->status_akhir) }}</strong></td>
        </tr>
    </table>

    {{-- TABEL TAHAPAN SIDANG --}}
    <table class="tabel-progres">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%">Tanggal Sidang</th>
                <th width="30%">Tahapan Sidang</th>
                <th width="40%">Hasil / Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($perkara->tahapans as $index => $tahap)
            <tr>
                <td align="center">{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($tahap->tanggal_tahapan)->translatedFormat('d F Y') }}</td>
                <td>{{ $tahap->nama_tahapan }}</td>
                <td>{{ $tahap->keterangan ?? 'Sudah Terlaksana' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" align="center"><em>Belum ada riwayat tahapan sidang yang diinputkan.</em></td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- TANDA TANGAN --}}
    <div class="footer">
        <div class="ttd-box">
            <p>Banjarmasin, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p>Petugas Administrasi Datun,</p>
            <br><br><br>
            <p><strong>{{ auth()->user()->name }}</strong></p>
            <p>NIP. {{ auth()->user()->nip ?? '-' }}</p>
        </div>
        <div class="clear"></div>
    </div>
</body>
</html>