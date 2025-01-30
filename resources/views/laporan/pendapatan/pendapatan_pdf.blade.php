<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pendapatan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
        }

        .header p {
            margin: 0;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .total {
            text-align: right;
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Laporan Pendapatan</h1>
        <p>Periode: {{ \Carbon\Carbon::parse($tanggalMulai)->format('d-m-Y') }} s/d
            {{ \Carbon\Carbon::parse($tanggalSelesai)->format('d-m-Y') }}</p>
        @if ($jenisTarif)
            <p>Jenis Tarif: {{ ucfirst($jenisTarif) }}</p>
        @else
            <p>Jenis Tarif: Semua</p>
        @endif
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Plat Kendaraan</th>
                <th>Jenis Tarif</th>
                <th>Jam Masuk</th>
                <th>Tanggal</th>
                <th>Tarif</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataParkir as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data->plat_kendaraan }}</td>
                    <td>{{ ucfirst($data->tarif->jenis_tarif ?? '-') }}</td>
                    <td>{{ $data->jam_masuk }}</td>
                    <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d-m-Y') }}</td>
                    <td>Rp {{ number_format($data->tarif->tarif ?? 0, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="total">
        Total Pendapatan: Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
    </div>
</body>

</html>
