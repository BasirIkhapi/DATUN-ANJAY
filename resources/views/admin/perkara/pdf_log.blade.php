<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Audit Log Aktivitas - SIM-DATUN</title>
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; font-size: 10px; color: #333; margin: 0; padding: 0; }
        
        /* Kop Surat Resmi Kejaksaan */
        .header-container { 
            text-align: center; 
            margin-bottom: 20px; 
            position: relative; 
            padding-top: 10px;
            min-height: 80px; 
        }
        .logo-instansi {
            position: absolute;
            left: 20px; 
            top: 5px;
            width: 60px;
            height: auto;
        }
        .header-container h2 { margin: 0; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; }
        .header-container h1 { margin: 2px 0; font-size: 18px; text-transform: uppercase; font-weight: bold; }
        .header-container p { margin: 2px 0 0; font-size: 9px; font-style: italic; }
        
        /* Garis Khas Surat Dinas */
        .line-double { border-bottom: 3px solid #000; margin-top: 10px; }
        .line-single { border-bottom: 1px solid #000; margin-top: 2px; }

        /* Judul Laporan */
        .title-container { text-align: center; margin: 20px 0; text-transform: uppercase; }
        .title-container h4 { margin: 0; font-size: 12px; text-decoration: underline; font-weight: bold; }
        .title-container p { margin: 5px 0; font-size: 10px; }

        /* Tabel Styling */
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; table-layout: fixed; }
        th { background-color: #f2f2f2; border: 1px solid #000; padding: 8px 5px; text-transform: uppercase; font-size: 8px; text-align: center; }
        td { border: 1px solid #000; padding: 6px 5px; vertical-align: middle; line-height: 1.3; font-size: 9px; word-wrap: break-word; }
        
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .timestamp { font-style: italic; color: #444; }

        /* Tanda Tangan */
        .footer-sign { margin-top: 30px; width: 100%; }
        .sign-table { width: 100%; border: none; }
        .sign-table td { border: none !important; text-align: center; padding: 0; }
        .space-ttd { height: 60px; }
    </style>
</head>
<body>

    {{-- KOP SURAT RESMI --}}
    <div class="header-container">
        <img src="{{ public_path('img/logo jaksa.png') }}" class="logo-instansi">
        <h2>KEJAKSAAN AGUNG REPUBLIK INDONESIA</h2>
        <h1>KEJAKSAAN NEGERI BANJARMASIN</h1>
        <p>Jl. Adhyaksa No.1, Kayu Tangi, Banjarmasin, Kalimantan Selatan 70123</p>
        <div class="line-double"></div>
        <div class="line-single"></div>
    </div>

    <div class="title-container">
        <h4>LAPORAN AUDIT LOG AKTIVITAS SISTEM</h4>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="18%">Waktu Kejadian</th>
                <th width="20%">Nama Pengguna</th>
                <th width="10%">Role</th>
                <th width="47%">Deskripsi Aktivitas</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($logs) && count($logs) > 0)
                @foreach($logs as $key => $log)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td class="timestamp text-center">
                        {{ $log->created_at ? $log->created_at->format('d/m/Y H:i:s') : '-' }}
                    </td>
                    
                    @if($log->user)
                        <td class="font-bold">{{ $log->user->name }}</td>
                        <td class="text-center">{{ ucfirst($log->user->role) }}</td>
                    @else
                        <td style="color: #dc2626; font-style: italic;">ID User: {{ $log->user_id }} (Telah Dihapus)</td>
                        <td class="text-center">-</td>
                    @endif

                    <td>{{ $log->deskripsi }}</td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-center" style="padding: 20px;">Belum ada catatan log aktivitas dalam sistem.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div style="font-size: 8px; font-style: italic; color: #666;">
        * Laporan ini mencatat setiap perubahan data untuk menjaga integritas informasi pada Kejaksaan Negeri Banjarmasin.
    </div>

    {{-- TANDA TANGAN DINAMIS --}}
    <div class="footer-sign">
        <table class="sign-table">
            <tr>
                <td width="65%"></td>
                <td width="35%">
                    <p>Banjarmasin, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                    <p class="font-bold text-uppercase">Petugas Administrator,</p>
                    <div class="space-ttd"></div>
                    <p class="font-bold text-uppercase" style="text-decoration: underline;">
                        {{ Auth::user()->name }}
                    </p>
                    <p>NIP. {{ Auth::user()->nip ?? '..........................' }}</p>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>