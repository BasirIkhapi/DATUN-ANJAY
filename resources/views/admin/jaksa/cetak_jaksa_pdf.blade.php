<!DOCTYPE html>
<html>
<head>
    <title>Daftar Jaksa JPN</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .footer { margin-top: 30px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h3>KEJAKSAAN NEGERI</h3>
        <h4>DAFTAR JAKSA PENGACARA NEGARA (JPN) AKTIF</h4>
    </div>

    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th>Nama Jaksa</th>
                <th>NIP</th>
                <th width="100">Jumlah Perkara</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jaksas as $index => $jaksa)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $jaksa->nama_jaksa }}</td>
                <td>{{ $jaksa->nip ?? '-' }}</td>
                <td style="text-align: center;">{{ $jaksa->perkaras_count }} Perkara</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Banjarmasin, {{ date('d F Y') }}</p>
        <br><br><br>
        <p><b>{{ Auth::user()->name }}</b></p>
        <p>Admin DATUN</p>
    </div>
</body>
</html>