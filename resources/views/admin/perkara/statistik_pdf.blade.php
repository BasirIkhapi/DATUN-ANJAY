<!DOCTYPE html>
<html>
<head>
    <title>Laporan Statistik Perkara</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .box-container { margin-bottom: 30px; }
        .box { display: inline-block; width: 30%; border: 1px solid #ccc; padding: 15px; text-align: center; border-radius: 8px; }
        .label { font-size: 10px; font-weight: bold; text-transform: uppercase; color: #666; }
        .value { font-size: 24px; font-weight: bold; margin: 5px 0; color: #1e40af; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f8f9fa; font-weight: bold; }
        .footer { margin-top: 50px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h3>KEJAKSAAN NEGERI</h3>
        <h4>LAPORAN STATISTIK JENIS PERKARA DATUN</h4>
    </div>

    <div class="box-container" style="text-align: center;">
        <div class="box">
            <div class="label">Total Perkara</div>
            <div class="value">{{ $total }}</div>
        </div>
        <div class="box" style="margin-left: 20px;">
            <div class="label">Perdata</div>
            <div class="value">{{ $perdata }}</div>
        </div>
        <div class="box" style="margin-left: 20px;">
            <div class="label">TUN</div>
            <div class="value">{{ $tun }}</div>
        </div>
    </div>

    <h4>Rincian Berdasarkan Jenis:</h4>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Perkara</th>
                <th>Jenis Perkara</th>
                <th>Status Akhir</th>
            </tr>
        </thead>
        <tbody>
            @foreach($daftar_perkara as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->nomor_perkara }}</td>
                <td>{{ $item->jenis_perkara }}</td>
                <td>{{ $item->status_akhir }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak oleh: {{ Auth::user()->name }}</p>
        <p>Tanggal: {{ date('d F Y') }}</p>
    </div>
</body>
</html>