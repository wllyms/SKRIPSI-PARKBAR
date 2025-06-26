<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Struk Parkir</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 0;
            width: 58mm;
            background: #fff;
            -webkit-print-color-adjust: exact;
        }

        .struk {
            width: 100%;
            padding: 6px 10px;
            box-sizing: border-box;
            text-align: left;
        }

        .header {
            text-align: center;
            margin-bottom: 4px;
        }

        .header h2 {
            font-size: 14px;
            margin: 0;
            font-weight: bold;
        }

        .header p {
            font-size: 10px;
            margin: 0;
        }

        .separator {
            border-top: 1px dashed #000;
            margin: 4px 0;
        }

        .content p {
            margin: 2px 0;
            font-size: 11px;
            line-height: 1.2;
        }

        .content p strong {
            display: inline-block;
            width: 40%;
        }


        .footer {
            font-size: 10px;
            text-align: center;
            margin-top: 4px;
        }

        .notes {
            font-size: 9px;
            margin-top: 4px;
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
            <p><strong>Kode Parkir</strong> {{ $parkir->kode_parkir }}</p>
            <p><strong>Plat</strong> {{ $parkir->plat_kendaraan }}</p>
            <p><strong>Masuk</strong> {{ $parkir->waktu_masuk->format('H:i d/m/Y') }}</p>
            <p><strong>Keluar</strong> {{ $parkir->waktu_keluar->format('H:i d/m/Y') }}</p>
            <p><strong>Jenis Tarif</strong> {{ strtoupper($parkir->tarif->jenis_tarif) }}</p>
            <p><strong>Kategori</strong> {{ strtoupper($parkir->tarif->kategori->nama_kategori ?? '-') }}</p>
            <p><strong>Tarif</strong> Rp{{ number_format($parkir->tarif->tarif, 0, ',', '.') }}</p>
            <p><strong>Denda</strong> Rp{{ number_format($denda, 0, ',', '.') }}</p>
            <p><strong>Total</strong> Rp{{ number_format($total, 0, ',', '.') }}</p>
            <p><strong>Petugas</strong> {{ $parkir->user->staff->nama ?? '-' }}</p>
        </div>

        <div class="separator"></div>

        <div class="footer">
            Terima kasih atas kunjungan Anda.
        </div>

        <div class="notes">
            <strong>Catatan:</strong><br>
            - Denda berlaku jika parkir INAP > 48 jam.<br>
            - Denda/jam: Motor Rp10.000, Mobil Rp20.000.<br>
            - Kehilangan tiket harap lapor petugas.
        </div </div>
</body>


</html>
