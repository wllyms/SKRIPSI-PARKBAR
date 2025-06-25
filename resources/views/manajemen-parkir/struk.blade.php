<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Struk Parkir Keluar</title>
    <style>
        body {
            font-family: monospace;
            font-size: 14px;
        }

        .struk {
            width: 300px;
            margin: auto;
            white-space: pre;
        }
    </style>
</head>

<body onload="window.print()">
    <div class="struk">
        ==============================
        PARKIR RS BHAYANGKARA
        Jl. [Alamat Rumah Sakit]
        ------------------------------
        Tanggal : {{ \Carbon\Carbon::now()->format('d-m-Y') }}
        Masuk : {{ $parkir->waktu_masuk }}
        Keluar : {{ $parkir->waktu_keluar }}
        Plat No : {{ $parkir->plat_kendaraan }}
        Kategori : {{ strtoupper($parkir->tarif->kategori->nama_kategori) }}
        Jenis Tarif : {{ strtoupper($parkir->tarif->jenis_tarif) }}
        Petugas : {{ auth()->user()->username }}
        ------------------------------
        Tarif Parkir: Rp{{ number_format($tarif, 0, ',', '.') }}
        Denda : Rp{{ number_format($denda, 0, ',', '.') }}
        ------------------------------
        TOTAL BAYAR : Rp{{ number_format($total, 0, ',', '.') }}
        ------------------------------
        Terima kasih atas kunjungan Anda
        ==============================
    </div>
</body>

</html>
