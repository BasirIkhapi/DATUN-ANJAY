<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Monitoring Perkara - {{ $perkara->nomor_perkara }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.5; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h1 { margin: 0; text-transform: uppercase; font-size: 18px; }
        .header p { margin: 5px 0 0; font-size: 12px; }
        .section-title { background: #f4f4f4; padding: 5px 10px; font-weight: bold; margin-top: 20px; text-transform: uppercase; font-size: 14px; }
        .info-table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 12px; }
        .info-table td { padding: 5px 0; }
        .info-table td.label { width: 150px; color: #666; }
        .info-table td.value { font-weight: bold; }
        .timeline-table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 11px; }
        .timeline-table th { background: #3b82f6; color: white; padding: 8px; text-align: left; text-transform: uppercase; }
        .timeline-table td { border: 1px solid #e5e7eb; padding: 8px; }
        .footer { margin-top: 50px; text-align: right; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Kejaksaan Negeri - Divisi DATUN</h1>
        <p>Laporan Monitoring Tahapan Perkara Perdata dan Tata Usaha Negara</p>
    </div>

    <div class="section-title">Detail Perkara</div>
    <table class="info-table">
        <tr>
            <td class="label">Nomor Perkara</td>
            <td class="value">: {{ $perkara->nomor_perkara }}</td>
        </tr>
        <tr>
            <td class="label">Jaksa JPN</td>
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
            <td class="label">Jenis Perkara</td>
            <td class="value">: {{ $perkara->jenis_perkara }}</td>
        </tr>
    </table>

    <div class="section-title">Riwayat Progres (Timeline)</div>
    <table class="timeline-table">
        <thead>
            <tr>
                <th width="30">No</th>
                <th width="100">Tanggal</th>
                <th width="150">Nama Tahapan</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($perkara->tahapans->sortBy('tanggal_tahapan') as $index => $tahapan)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($tahapan->tanggal_tahapan)->format('d/m/Y') }}</td>
                <td style="font-weight: bold;">{{ $tahapan->nama_tahapan }}</td>
                <td>{{ $tahapan->keterangan ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center; color: #999;">Belum ada riwayat progres yang tercatat.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ date('d F Y H:i') }}</p>
        <br><br><br>
        <p>( __________________________ )</p>
        <p>Admin DATUN</p>
    </div>
</body>
</html>