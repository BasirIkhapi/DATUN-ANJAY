<!DOCTYPE html>
<html>
<head>
    <title>Monitoring Perkara - {{ $perkara->nomor_perkara }}</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.5; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 3px double #000; padding-bottom: 10px; }
        .header h3 { margin: 0; text-transform: uppercase; font-size: 14pt; }
        .header p { margin: 0; font-size: 10pt; }
        
        .judul { text-align: center; text-decoration: underline; font-weight: bold; margin-bottom: 20px; text-transform: uppercase; }
        
        .info-table { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
        .info-table td { vertical-align: top; padding: 4px 0; }
        .label { width: 30%; font-weight: bold; }
        .separator { width: 3%; }
        
        .content-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .content-table th { background-color: #f2f2f2; text-align: center; font-weight: bold; border: 1px solid #000; padding: 8px; font-size: 10pt; text-transform: uppercase; }
        .content-table td { border: 1px solid #000; padding: 8px; font-size: 10pt; vertical-align: top; }
        
        .footer { margin-top: 50px; width: 100%; }
        .ttd { float: right; width: 40%; text-align: center; }
        .clear { clear: both; }
    </style>
</head>
<body>

    <div class="header">
        <h3>KEJAKSAAN NEGERI BANJARMASIN</h3>
        <p>BIDANG PERDATA DAN TATA USAHA NEGARA</p>
        <p>Jalan Haulan No. 1, Banjarmasin, Kalimantan Selatan</p>
    </div>

    <div class="judul">LAPORAN MONITORING PROGRES PERKARA</div>

    <table class="info-table">
        <tr>
            <td class="label">NOMOR PERKARA</td>
            <td class="separator">:</td>
            <td><strong>{{ $perkara->nomor_perkara }}</strong></td>
        </tr>
        <tr>
            <td class="label">JENIS PERKARA</td>
            <td class="separator">:</td>
            <td>{{ $perkara->jenis_perkara }}</td>
        </tr>
        <tr>
            <td class="label">PIHAK PENGGUGAT</td>
            <td class="separator">:</td>
            <td>{{ $perkara->penggugat }}</td>
        </tr>
        <tr>
            <td class="label">PIHAK TERGUGAT</td>
            <td class="separator">:</td>
            <td>{{ $perkara->tergugat }}</td>
        </tr>
        <tr>
            <td class="label">JAKSA PENGACARA NEGARA</td>
            <td class="separator">:</td>
            <td>{{ $perkara->jaksa->nama_jaksa ?? 'BELUM DITUNJUK' }}</td>
        </tr>
        <tr>
            <td class="label">STATUS AKHIR</td>
            <td class="separator">:</td>
            <td><strong>{{ strtoupper($perkara->status_akhir) }}</strong></td>
        </tr>
    </table>

    <p><strong>RIWAYAT TAHAPAN / KEGIATAN SIDANG:</strong></p>
    <table class="content-table">
        <thead>
            <tr>
                <th width="5%">NO</th>
                <th width="20%">TANGGAL</th>
                <th width="30%">TAHAPAN SIDANG</th>
                <th width="45%">HASIL / KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
            @forelse($perkara->tahapans as $index => $tahap)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td style="text-align: center;">{{ \Carbon\Carbon::parse($tahap->tanggal_tahapan)->translatedFormat('d F Y') }}</td>
                <td>{{ $tahap->nama_tahapan }}</td>
                <td>{{ $tahap->keterangan ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center; font-style: italic;">Belum ada data tahapan kegiatan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="ttd">
            <p>Banjarmasin, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p>Jaksa Pengacara Negara,</p>
            <br><br><br><br>
            <p><strong><u>{{ $perkara->jaksa->nama_jaksa ?? '(..........................................)' }}</u></strong></p>
            <p>NIP. {{ $perkara->jaksa->nip ?? '........................' }}</p>
        </div>
        <div class="clear"></div>
    </div>

</body>
</html>