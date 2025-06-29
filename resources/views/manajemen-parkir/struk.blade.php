<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Struk Parkir</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            /* Font khas printer thermal */
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

        /* Menggunakan table untuk layout yang lebih rapi */
        .content-table {
            width: 100%;
            font-size: 11px;
            line-height: 1.3;
        }

        .content-table td {
            vertical-align: top;
        }

        .content-table .label {
            width: 40%;
        }

        .content-table .value {
            text-align: right;
        }

        .total-row td {
            font-weight: bold;
            font-size: 12px;
            padding-top: 2px;
        }

        .denda-row td {
            font-weight: bold;
        }

        .footer {
            font-size: 10px;
            text-align: center;
            margin-top: 4px;
        }

        .qr-section {
            text-align: center;
            margin-top: 8px;
        }

        .qr-section p {
            margin: 0 0 5px 0;
            font-weight: bold;
        }
    </style>
</head>

<body onload="window.print()">
    <div class="struk">
        <div class="header">
            <h2>Struk Parkir ParkBara</h2>
            <p>RS Bhayangkara Banjarmasin</p>
        </div>

        <div class="separator"></div>

        <div class="content">
            <table class="content-table">
                <tr>
                    <td class="label">Kode Parkir</td>
                    <td class="value">{{ $parkir->kode_parkir }}</td>
                </tr>
                <tr>
                    <td class="label">Plat</td>
                    <td class="value">{{ $parkir->plat_kendaraan }}</td>
                </tr>
                <tr>
                    <td class="label">Masuk</td>
                    <td class="value">{{ $parkir->waktu_masuk->format('H:i d/m/Y') }}</td>
                </tr>
                <tr>
                    <td class="label">Keluar</td>
                    <td class="value">{{ $parkir->waktu_keluar->format('H:i d/m/Y') }}</td>
                </tr>
                <tr>
                    <td class="label">Jenis Tarif</td>
                    <td class="value">{{ strtoupper($parkir->tarif->jenis_tarif) }}</td>
                </tr>
                <tr>
                    <td class="label">Kategori</td>
                    <td class="value">{{ strtoupper($parkir->tarif->kategori->nama_kategori ?? '-') }}</td>
                </tr>
                <tr>
                    <td class="label">Petugas</td>
                    <td class="value">{{ $parkir->user->staff->nama ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <div class="separator"></div>

        <div class="content">
            <table class="content-table">
                <tr>
                    <td class="label">Tarif</td>
                    <td class="value">Rp {{ number_format($tarif, 0, ',', '.') }}</td>
                </tr>

                {{-- ========================================== --}}
                {{-- MODIFIKASI 1: Tampilkan Denda Jika Ada --}}
                {{-- ========================================== --}}
                @if ($denda > 0)
                    <tr class="denda-row">
                        <td class="label">DENDA</td>
                        <td class="value">Rp {{ number_format($denda, 0, ',', '.') }}</td>
                    </tr>
                @endif
                {{-- ========================================== --}}

                <tr class="total-row">
                    <td class="label">TOTAL BAYAR</td>
                    <td class="value">Rp {{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <div class="separator"></div>

        {{-- ================================================ --}}
        {{-- MODIFIKASI 2: Tambahkan Bagian QR Code Penilaian --}}
        {{-- ================================================ --}}
        <div class="qr-section">
            <img src="{{ $qrCode }}">
        </div>
        {{-- ================================================ --}}

        <div class="footer">
            Terima kasih atas kunjungan Anda.
            <br>
            Simpan struk sebagai bukti pembayaran.
        </div>

    </div>
</body>


<script>
    window.onload = function() {
        window.print();
        setTimeout(function() {
            window.close();
        }, 1000); // Tutup 1 detik setelah print
    };
</script>

</html>
