<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Pengaduan Pengunjung</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            width: 100px;
            height: auto;
            margin-bottom: 10px;
        }

        .header h1 {
            margin: 5px 0;
            font-size: 22px;
            color: #222;
        }

        .header p {
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

        table th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
            color: #777;
        }

        .divider {
            border-top: 2px solid #000;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ public_path('storage/logo-rs.png') }}" alt="Logo RS Bhayangkara">
        <h1>Laporan Pengaduan Pengunjung</h1>
        <p>Periode: {{ \Carbon\Carbon::parse($tanggalMulai)->format('d-m-Y') }} s/d
            {{ \Carbon\Carbon::parse($tanggalSelesai)->format('d-m-Y') }}</p>
    </div>

    <div class="divider"></div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>No Telp</th>
                <th>Waktu Lapor</th>
                <th>Keterangan</th>
                <th>Petugas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporan as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->no_telp }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->waktu_lapor)->format('d-m-Y H:i') }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td>{{ $item->user->staff->nama ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="divider"></div>

    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d-m-Y') }}
    </div>
</body>

</html>
