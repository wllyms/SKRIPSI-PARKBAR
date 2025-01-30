<!DOCTYPE html>
<html>

<head>
    <title>Laporan Pegawai</title>
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

        header h1,
        header h4 {
            margin: 0;
            padding: 0;
        }

        header h4 {
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
        <h1>Laporan Pegawai</h1>
        <h4>RS Bhayangkara Banjarmasin</h4>
    </header>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Plat Kendaraan</th>
                <th>Nama</th>
                <th>No. Telp</th>
                <th>Jenis Pegawai</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pegawai as $data) 
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $data->plat_kendaraan }}</td>
                    <td>{{ $data->nama }}</td>
                    <td>{{ $data->no_telp }}</td>
                    <td>{{ $data->jenisPegawai->jenis_pegawai }}</td>
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
