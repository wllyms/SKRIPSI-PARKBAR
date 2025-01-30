<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Parkir RS Bhayangkara</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        header img {
            width: 80px;
            height: auto;
            margin-bottom: 10px;
        }

        h1,
        h4 {
            margin: 0;
            padding: 0;
        }

        h4 {
            margin-top: 5px;
            font-weight: normal;
            font-size: 14px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f4f4f4;
            font-weight: bold;
            text-align: center;
        }

        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>

<body>
    <header>
        <img src="{{ public_path('path/to/logo.png') }}" alt="Logo RS Bhayangkara">
        <h1>Laporan Parkir</h1>
        <h4>RS Bhayangkara Banjarmasin</h4>
        <h4>Periode: {{ \Carbon\Carbon::parse($tanggalMulai)->format('d-m-Y') }} -
            {{ \Carbon\Carbon::parse($tanggalSelesai)->format('d-m-Y') }}</h4>
        <h4>Status: {{ $status ? Str::title($status) : 'Semua Status' }}</h4>
    </header>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Plat Kendaraan</th>
                <th>Jenis Tarif</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($dataParkir as $data)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $data->plat_kendaraan }}</td>
                    <td>{{ $data->tarif->jenis_tarif ?? '-' }}</td>
                    <td>{{ $data->jam_masuk }}</td>
                    <td>{{ $data->jam_keluar ?? '-' }}</td>
                    <td>{{ Str::title($data->status) }}</td>
                    <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d-m-Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Data tidak ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d-m-Y') }}
    </div>
</body>

</html>
