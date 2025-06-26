<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Data Pegawai</title>
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
            width: 100px;
            height: auto;
            margin-bottom: 10px;
        }

        h1 {
            margin: 0;
            font-size: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #aaa;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
            text-align: center;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>

<body>
    <header>
        <img src="{{ public_path('storage/logo-rs.png') }}" alt="Logo RS">
        <h1>Laporan Data Pegawai</h1>
        <p>RS Bhayangkara Banjarmasin</p>
    </header>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Plat Kendaraan</th>
                <th>Nama</th>
                <th>No. Telp</th>
                <th>Jabatan</th>
                <th>Sub Jabatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pegawai as $index => $data)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $data->plat_kendaraan }}</td>
                    <td>{{ $data->nama }}</td>
                    <td>{{ $data->no_telp }}</td>
                    <td>{{ $data->jabatan->nama_jabatan ?? '-' }}</td>
                    <td>{{ $data->subjabatan->nama_sub_jabatan ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d-m-Y') }}
    </div>
</body>

</html>
