<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Parkir Pegawai</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            color: #333;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #000;
        }

        .logo {
            width: 80px;
            /* Ukuran logo yang lebih proporsional */
            height: auto;
            margin-bottom: 10px;
        }

        h1 {
            margin: 5px 0;
            font-size: 22px;
            color: #222;
        }

        h3 {
            margin: 3px 0;
            font-size: 14px;
            font-weight: normal;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 14px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        table th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
            color: #777;
            border-top: 2px solid #000;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <header>
        <img src="{{ public_path('storage/logo-rs.png') }}" alt="Logo RS Bhayangkara" class="logo">
        <h1>Laporan Parkir Pegawai</h1>
        <h3>RS Bhayangkara Banjarmasin</h3>
        <h3>Periode: {{ \Carbon\Carbon::parse($tanggalMulai)->format('d-m-Y') }}
            s/d {{ \Carbon\Carbon::parse($tanggalSelesai)->format('d-m-Y') }}</h3>
    </header>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Plat Kendaraan</th>
                <th>Nama Pegawai</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($dataParkir as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data->plat_kendaraan }}</td>
                    <td>{{ $data->pegawai->nama }}</td>
                    <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $data->jam_masuk ? \Carbon\Carbon::parse($data->jam_masuk)->format('H:i') : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Data tidak ditemukan</td>
                </tr>
            @endforelse
        </tbody>

    </table>

    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d-m-Y') }}
    </div>
</body>

</html>
