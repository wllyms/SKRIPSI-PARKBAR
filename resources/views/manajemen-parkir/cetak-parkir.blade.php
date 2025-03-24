<!DOCTYPE html>
<html>

<head>
    <title>Struk Parkir</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            width: 58mm;
            text-align: center;
        }

        .struk {
            width: 100%;
            padding: 5px 0;
        }

        .header {
            margin-bottom: 8px;
        }

        .header h2 {
            font-size: 16px;
            margin: 0;
            font-weight: bold;
        }

        .header p {
            font-size: 12px;
            margin: 2px 0;
        }

        .separator {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }

        .content {
            text-align: left;
            padding: 0 10px;
        }

        .content p {
            font-size: 12px;
            margin: 3px 0;
        }

        .content p strong {
            display: inline-block;
            width: 35%;
        }

        .barcode {
            text-align: center;
            margin-top: 10px;
        }

        .barcode img {
            max-width: 90%;
            height: auto;
        }

        .footer {
            font-size: 11px;
            margin-top: 8px;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .struk {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="struk">
        <div class="header">
            <h2>Struk Parkir</h2>
            <p>RS Bhayangkara Banjarmasin</p>
        </div>
        <div class="separator"></div>
        <div class="content">
            <p><strong>Plat:</strong> {{ $parkir->plat_kendaraan }}</p>
            <p><strong>Jenis Tarif:</strong> {{ $parkir->tarif->jenis_tarif }}</p>
            <p><strong>Kategori:</strong> {{ $parkir->tarif->kategori->nama_kategori ?? '-' }}</p>
            <p><strong>Tarif:</strong> Rp {{ number_format($parkir->tarif->tarif, 0, ',', '.') }}</p>
            <p><strong>Jam Masuk:</strong> {{ $parkir->jam_masuk }}</p>
            <p><strong>Jam Keluar:</strong> {{ $parkir->jam_keluar ?? '-' }}</p>
            <p><strong>Status:</strong> {{ ucfirst($parkir->status) }}</p>
        </div>
        <div class="separator"></div>
        <div class="barcode">
            @php
                $code = $parkir->plat_kendaraan;
                $generator = new \Picqer\Barcode\BarcodeGeneratorHTML();
                $barcode = $generator->getBarcode($code, $generator::TYPE_CODE_128);
            @endphp
            {!! $barcode !!}
        </div>
        <div class="separator"></div>
        <div class="footer">

        </div>
    </div>
</body>

</html>
