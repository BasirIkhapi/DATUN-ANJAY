<!DOCTYPE html>
<html>
<head>
    <title>Laporan Audit Log Aktivitas</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; vertical-align: top; }
        th { background-color: #004d40; color: white; text-align: center; text-transform: uppercase; }
        .text-center { text-align: center; }
        .timestamp { color: #555; font-style: italic; white-space: nowrap; }
    </style>
</head>
<body>
    <div class="header">
        <h2 style="margin: 0;">LAPORAN AUDIT LOG AKTIVITAS SISTEM</h2>
        <p style="margin: 5px 0;">Aplikasi Monitoring Perkara - Kejaksaan Negeri Banjarmasin</p>
        <p style="font-size: 8px;">Waktu Cetak: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="18%">Waktu</th>
                <th width="22%">Nama Pengguna</th>
                <th width="10%">Role</th>
                <th>Deskripsi Aktivitas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $key => $log)
            <tr>
                <td class="text-center">{{ $key + 1 }}</td>
                <td class="timestamp text-center">
                    {{ $log->created_at ? $log->created_at->format('d/m/Y H:i:s') : '-' }}
                </td>
                
                @if($log->user)
                    <td>{{ $log->user->name }}</td>
                    <td class="text-center">{{ ucfirst($log->user->role) }}</td>
                @else
                    <td style="color: #dc2626; font-style: italic;">User Dihapus (ID: {{ $log->user_id }})</td>
                    <td class="text-center">-</td>
                @endif

                <td>{{ $log->deskripsi }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 40px; float: right; width: 220px; text-align: center;">
        <p>Banjarmasin, {{ date('d F Y') }}</p>
        <p style="margin-bottom: 60px;">Petugas Administrator,</p>
        <p><strong>{{ Auth::user()->name }}</strong></p>
        <p style="font-size: 8px; margin-top: -5px;">NIP. ...........................</p>
    </div>
</body>
</html>