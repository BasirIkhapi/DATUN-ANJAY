<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Analisis Durasi Penyelesaian Perkara - SIM-DATUN</title>
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
        
        /* Garis Khas Surat Dinas Kejaksaan (Tebal & Tipis) */
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
        .text-uppercase { text-transform: uppercase; }
        .font-bold { font-weight: bold; }
        .italic { font-style: italic; }

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
        {{-- Menggunakan path logo yang sama dengan laporan stagnansi kamu --}}
        <img src="{{ public_path('img/logo jaksa.png') }}" class="logo-instansi">
        <h2>KEJAKSAAN AGUNG REPUBLIK INDONESIA</h2>
        <h1>KEJAKSAAN NEGERI BANJARMASIN</h1>
        <p>Jl. Adhyaksa No.1, Kayu Tangi, Banjarmasin, Kalimantan Selatan 70123</p>
        <div class="line-double"></div>
        <div class="line-single"></div>
    </div>

    <div class="title-container">
        <h4>LAPORAN ANALISIS DURASI PENYELESAIAN PERKARA</h4>
        <p>Bidang Perdata dan Tata Usaha Negara (DATUN)</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="18%">Nomor Perkara</th>
                <th width="10%">Jenis</th>
                <th width="24%">Para Pihak (P vs T)</th>
                <th width="12%">Tgl Masuk</th>
                <th width="12%">Tgl Selesai</th>
                <th width="10%">Durasi</th>
                <th width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($perkaras) && count($perkaras) > 0)
                @foreach($perkaras as $key => $p)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td class="font-bold text-uppercase italic">{{ $p->nomor_perkara }}</td>
                    <td class="text-center text-uppercase">{{ $p->jenis_perkara }}</td>
                    <td>
                        <span class="font-bold">P:</span> {{ $p->penggugat }}<br>
                        <span class="font-bold">T:</span> {{ $p->tergugat }}
                    </td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($p->tanggal_masuk)->format('d/m/Y') }}</td>
                    <td class="text-center">
                        @php 
                            $tglSelesai = $p->tahapans->max('tanggal_tahapan');
                        @endphp
                        {{ $tglSelesai ? \Carbon\Carbon::parse($tglSelesai)->format('d/m/Y') : '-' }}
                    </td>
                    <td class="text-center font-bold">
                        {{ $p->selisih ?? 0 }} Hari
                    </td>
                    <td class="text-center italic">
                        {{ $tglSelesai ? 'Selesai' : 'Aktif' }}
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8" class="text-center italic" style="padding: 20px;">Data analisis durasi tidak ditemukan.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div style="font-size: 8px; font-style: italic; color: #666;">
        * Laporan durasi dihitung berdasarkan selisih tanggal masuk berkas hingga agenda tahapan sidang terakhir.
    </div>

    {{-- TANDA TANGAN (Petugas/Admin sesuai kodingan kamu) --}}
    <div class="footer-sign">
        <table class="sign-table">
            <tr>
                <td width="65%"></td>
                <td width="35%">
                    <p>Banjarmasin, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                    <p class="font-bold text-uppercase">Petugas Administrator,</p>
                    <div class="space-ttd"></div>
                    <p class="font-bold text-uppercase" style="text-decoration: underline;">
                        {{ Auth::user()->name ?? '..........................' }}
                    </p>
                    <p>NIP. {{ Auth::user()->nip ?? '..........................' }}</p>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>