<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Label Map - {{ $perkara->nomor_perkara }}</title>
    <style>
        @page { margin: 0; }
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            margin: 0; 
            padding: 20px;
            background-color: #fff;
        }
        .label-container {
            border: 4px double #000;
            padding: 25px;
            height: 230px; /* Menyesuaikan tinggi kertas custom */
            position: relative;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .header h1 {
            font-size: 14px;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header p {
            font-size: 9px;
            margin: 5px 0 0 0;
            font-weight: bold;
        }
        .content {
            margin-top: 15px;
        }
        .row {
            margin-bottom: 12px;
            display: block;
        }
        .label-title {
            font-size: 8px;
            font-weight: bold;
            color: #555;
            text-transform: uppercase;
            display: block;
            margin-bottom: 2px;
        }
        .label-value {
            font-size: 12px;
            font-weight: bold;
            color: #000;
            display: block;
        }
        .nomor-perkara {
            font-size: 16px;
            color: #047857; /* Emerald-700 */
            border-bottom: 1px dashed #ccc;
            padding-bottom: 5px;
        }
        .footer {
            position: absolute;
            bottom: 20px;
            right: 25px;
            text-align: right;
        }
        .jpn-name {
            font-size: 10px;
            font-weight: bold;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="label-container">
        <div class="header">
            <h1>Kejaksaan Negeri Banjarmasin</h1>
            <p>Bidang Perdata dan Tata Usaha Negara</p>
        </div>

        <div class="content">
            <div class="row">
                <span class="label-title">Nomor Registrasi Perkara</span>
                <span class="label-value nomor-perkara">{{ $perkara->nomor_perkara }}</span>
            </div>

            <div style="width: 100%; display: table;">
                <div style="display: table-row;">
                    <div style="display: table-cell; width: 50%; padding-right: 10px;">
                        <span class="label-title">Pihak Penggugat (P)</span>
                        <span class="label-value">{{ Str::limit($perkara->penggugat, 40) }}</span>
                    </div>
                    <div style="display: table-cell; width: 50%;">
                        <span class="label-title">Pihak Tergugat (T)</span>
                        <span class="label-value">{{ Str::limit($perkara->tergugat, 40) }}</span>
                    </div>
                </div>
            </div>
            
            <div class="row" style="margin-top: 10px;">
                <span class="label-title">Klasifikasi Perkara</span>
                <span class="label-value" style="font-size: 10px;">{{ $perkara->jenis_perkara }}</span>
            </div>
        </div>

        <div class="footer">
            <span class="label-title">Jaksa Pengacara Negara:</span>
            <span class="jpn-name">{{ $perkara->jaksa->nama_jaksa ?? '-' }}</span>
        </div>
    </div>
</body>
</html>