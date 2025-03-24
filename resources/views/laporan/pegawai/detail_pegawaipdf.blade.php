<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Detail</title>
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

        .photo {
            text-align: center;
            margin-bottom: 20px;
        }

        .photo img {
            width: 150px;
            height: 200px;
            object-fit: cover;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 10px 15px;
            text-align: left;
            vertical-align: top;
        }

        table th {
            background-color: #f4f4f4;
            font-weight: bold;
            text-align: center;
        }

        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table td.text-center {
            text-align: center;
        }

        table th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        table th:nth-child(1),
        table td:nth-child(1) {
            width: 5%;
        }

        table th:nth-child(2),
        table td:nth-child(2) {
            width: 20%;
        }

        table th:nth-child(3),
        table td:nth-child(3) {
            width: 15%;
        }

        table th:nth-child(4),
        table td:nth-child(4) {
            width: 15%;
        }

        table th:nth-child(5),
        table td:nth-child(5) {
            width: 15%;
        }

        table th:nth-child(6),
        table td:nth-child(6) {
            width: 20%;
        }

        table th:nth-child(7),
        table td:nth-child(7) {
            width: 10%;
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
    <!-- Header -->
    <header>
        <img src="{{ public_path('storage/logo-rs.png') }}" alt="Logo RS Bhayangkara">
        <h1>Laporan Detail Pegawai</h1>
        <h4>RS Bhayangkara Banjarmasin</h4>
    </header>

    <div class="divider"></div>

    <!-- Photo -->
    <div class="photo">
        @if (!empty($data->image))
            <img src="{{ public_path('storage/' . $data->image) }}" alt="Foto Pegawai">
        @else
            <p>Foto tidak tersedia</p>
        @endif
    </div>

    <div class="divider"></div>

    <!-- Table Data -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>Plat Kendaraan</th>
                <th>No Telp</th>
                <th>Email</th>
                <th>Alamat</th>
                <th>Merk Kendaraan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">1</td>
                <td>{{ $data->nama }}</td>
                <td>{{ $data->plat_kendaraan }}</td>
                <td>{{ $data->no_telp }}</td>
                <td>{{ $data->email }}</td>
                <td>{{ $data->alamat }}</td>
                <td>{{ $data->merk_kendaraan }}</td>
            </tr>
        </tbody>
    </table>

    <div class="divider"></div>

    <!-- Footer -->
    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d-m-Y') }}
    </div>
</body>

</html>
