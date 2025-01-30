<!DOCTYPE html>
<html>

<head>
    <title>Struk Parkir</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f9f9f9;
        }

        .struk {
            width: 300px;
            /* Lebar karcis standar */
            border: 1px solid #000;
            padding: 15px;
            box-sizing: border-box;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .header h2 {
            margin: 0;
            font-size: 20px;
            color: #333;
        }

        .header p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }

        .content {
            margin-top: 10px;
        }

        .content h4 {
            margin-bottom: 10px;
            font-size: 16px;
            text-align: center;
            color: #444;
        }

        .content p {
            font-size: 14px;
            margin: 3px 0;
            color: #555;
        }

        .barcode {
            text-align: center;
            margin-top: 20px;
        }

        .barcode img {
            max-width: 100%;
        }

        @media print {
            body {
                margin: 0;
                height: auto;
                background-color: #fff;
            }

            .struk {
                width: 100%;
                box-shadow: none;
                border: none;
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
        <div class="content"> 
            <h4>Detail Parkir</h4>
            <p><strong>Plat Kendaraan:</strong> {{ $parkir->plat_kendaraan }}</p>
            <p><strong>Jenis Tarif:</strong> {{ $parkir->tarif->jenis_tarif }}</p>
            <p><strong>Nama Kategori:</strong> {{ $parkir->tarif->kategori->nama_kategori ?? '-' }}</p>
            <p><strong>Tarif:</strong> Rp {{ number_format($parkir->tarif->tarif, 0, ',', '.') }}</p>
            <p><strong>Jam Masuk:</strong> {{ $parkir->jam_masuk }}</p>
            <p><strong>Jam Keluar:</strong> {{ $parkir->jam_keluar ?? '-' }}</p>
            <p><strong>Status:</strong> {{ ucfirst($parkir->status) }}</p>
        </div>
        <div class="barcode">
            @php
                $code = $parkir->plat_kendaraan;
                $generator = new \Picqer\Barcode\BarcodeGeneratorHTML();
                $barcode = $generator->getBarcode($code, $generator::TYPE_CODE_128);
            @endphp
            {!! $barcode !!}
        </div>
    </div>
</body>

</html>
