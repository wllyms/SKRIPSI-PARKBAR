<!DOCTYPE html>
<html>

<head>
    <title>Struk Data Pegawai</title>
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
            <h2>Data Pegawai</h2>
            <p>RS Bhayangkara Banjarmasin</p>
        </div>
        <div class="content">
            <p><strong>Kode Member:</strong> {{ $pegawai->kode_member ?? '-' }}</p> <!-- Tambahan -->
            <p><strong>Plat Kendaraan:</strong> {{ $pegawai->plat_kendaraan ?? '-' }}</p>
            <p><strong>Nama:</strong> {{ $pegawai->nama ?? '-' }}</p>
            <p><strong>No Telp:</strong> {{ $pegawai->no_telp ?? '-' }}</p>
            <p><strong>Jenis Pegawai:</strong> {{ $pegawai->jenisPegawai->jenis_pegawai ?? '-' }}</p>
        </div>
        <div class="barcode">
            @if (!empty($pegawai->kode_member))
                @php
                    $generator = new \Picqer\Barcode\BarcodeGeneratorHTML();
                    $barcode = $generator->getBarcode($pegawai->kode_member, $generator::TYPE_CODE_128);
                @endphp
                {!! $barcode !!}
                <div><small>{{ $pegawai->kode_member }}</small></div> <!-- Tambahkan kode di bawah barcode -->
            @else
                <p>Barcode tidak tersedia</p>
            @endif
        </div>
    </div>
</body>

</html>
