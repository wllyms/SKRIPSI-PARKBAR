<!DOCTYPE html>
<html>

<head> 
    <title>Struk Parkir</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            /* font lebih besar */
            margin: 0;
            padding: 0;
            width: 58mm;
            background: #fff;
            -webkit-print-color-adjust: exact;
        }

        .struk {
            width: 100%;
            padding: 3px 6px;
            /* padding diperkecil untuk pakai ruang maksimal */
            box-sizing: border-box;
            text-align: left;
        }

        .header {
            text-align: center;
            margin-bottom: 2px;
            /* margin header diperkecil */
        }

        .header h2 {
            font-size: 15px;
            /* header lebih besar */
            margin: 0;
            font-weight: bold;
            color: #000;
        }

        .header p {
            font-size: 10px;
            margin: 0;
            color: #000;
        }

        .separator {
            border-top: 1px dashed #000;
            margin: 3px 0;
        }

        .content p {
            margin: 3px 0 2px 0;
            font-size: 11px;
            line-height: 1.3;
            /* spasi antar baris sedikit lebih longgar */
            color: #000;
        }

        .content p strong {
            display: inline-block;
            width: 42%;
            color: #000;
        }

        .barcode {
            text-align: center;
            margin: 6px 0 4px 0;
        }

        .barcode svg,
        .barcode img {
            max-width: 100%;
            height: auto;
        }

        .footer {
            font-size: 10px;
            margin-top: 5px;
            text-align: center;
            color: #000;
        }

        .notes {
            font-size: 9px;
            margin-top: 6px;
            color: #b00;
            border-top: 1px solid #b00;
            padding-top: 3px;
            line-height: 1.2;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                width: 58mm;
            }

            .struk {
                padding: 0;
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
            <p><strong>Waktu Masuk:</strong> {{ $parkir->waktu_masuk }}</p>
            <p><strong>Petugas:</strong> {{ $parkir->user->staff->nama ?? '-' }}</p>
        </div>

        <div class="separator"></div>

        <div class="barcode">
            @php
                $code = $parkir->kode_parkir;
                $generator = new \Picqer\Barcode\BarcodeGeneratorHTML();
                $barcode = $generator->getBarcode($code, $generator::TYPE_CODE_128);
            @endphp
            {!! $barcode !!}
        </div>

        <div class="separator"></div>

        <div class="footer">
            Terima kasih telah menggunakan layanan parkir kami.
        </div>

        <div class="notes">
            <strong>Catatan:</strong> Kehilangan barang lapor petugas.<br>
            Denda berlaku jika parkir > 48 jam untuk tarif <em>INAP</em>.
        </div>
    </div>
</body>

</html>
