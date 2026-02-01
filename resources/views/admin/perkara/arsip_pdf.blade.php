<!DOCTYPE html>
<html>
<head>
    <title>Laporan Arsip Perkara Selesai</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 3px double #000; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; text-transform: uppercase; }
        .footer { margin-top: 30px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2 style="margin:0;">KEJAKSAAN NEGERI</h2>
        <h3 style="margin:0;">LAPORAN ARSIP PERKARA DATUN (STATUS SELESAI)</h3>
        <p style="margin:5px 0 0 0;">Dicetak pada: {{ date('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Perkara</th>
                <th>Tanggal Masuk</th>
                <th>Penggugat</th>
                <th>Tergugat</th>
                <th>Jenis</th>
                <th>Jaksa JPN</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($perkara_selesai as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->nomor_perkara }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d/m/Y') }}</td>
                <td>{{ $item->penggugat }}</td>
                <td>{{ $item->tergugat }}</td>
                <td>{{ $item->jenis_perkara }}</td>
                <td>{{ $item->jaksa->nama_jaksa ?? 'Belum Ditentukan' }}</td>
                <td><b style="color: blue;">{{ $item->status_akhir }}</b></td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center;">Belum ada perkara dengan status "Selesai" untuk diarsipkan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Banjarmasin, {{ date('d F Y') }}</p>
        <br><br><br>
        <p><b>Basir Ikhapi</b></p>
        <p>Admin DATUN</p>
    </div>
</body>
</html>