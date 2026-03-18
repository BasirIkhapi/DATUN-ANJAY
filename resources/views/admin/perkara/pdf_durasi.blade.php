<!DOCTYPE html>
<html>
<head>
    <title>Laporan Durasi Penyelesaian Perkara</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h2 { margin: 0; font-size: 18px; text-transform: uppercase; }
        .header h3 { margin: 5px 0; font-size: 14px; text-transform: uppercase; color: #065f46; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 8px; vertical-align: middle; }
        th { background-color: #f0fdf4; font-weight: bold; text-transform: uppercase; font-size: 9px; text-align: center; }
        
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>KEJAKSAAN NEGERI BANJARMASIN</h2>
        <h3>LAPORAN ANALISIS DURASI PENYELESAIAN PERKARA DATUN</h3>
        <p>Dicetak pada: {{ date('d F Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Nomor Perkara</th>
                <th width="15%">Jenis</th>
                <th width="25%">Para Pihak</th>
                <th width="12%">Tgl Masuk</th>
                <th width="12%">Tgl Selesai</th>
                <th width="11%">Durasi</th>
            </tr>
        </thead>
        <tbody>
            {{-- Pastikan variabel $perkaras dikirim dari controller --}}
            @if(isset($perkaras) && count($perkaras) > 0)
                @foreach($perkaras as $key => $p)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td class="font-bold">{{ $p->nomor_perkara }}</td>
                    <td class="text-center">{{ $p->jenis_perkara }}</td>
                    <td>{{ $p->penggugat }} vs {{ $p->tergugat }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($p->tanggal_masuk)->format('d/m/Y') }}</td>
                    <td class="text-center">
                        {{-- Mengambil tanggal tahapan terakhir --}}
                        @php 
                            $tglSelesai = $p->tahapans->max('tanggal_tahapan');
                        @endphp
                        {{ $tglSelesai ? \Carbon\Carbon::parse($tglSelesai)->format('d/m/Y') : '-' }}
                    </td>
                    <td class="text-center font-bold">
                        {{-- Memanggil property selisih yang dihitung di controller --}}
                        {{ $p->selisih ?? 0 }} Hari
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" class="text-center" style="padding: 20px;">Data tidak ditemukan.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div style="margin-top: 30px; text-align: right;">
        <p>Banjarmasin, {{ date('d F Y') }}</p>
        <p style="margin-bottom: 60px;">Petugas Administrator,</p>
        <p><strong>{{ Auth::user()->name ?? '..........................' }}</strong></p>
    </div>
</body>
</html>