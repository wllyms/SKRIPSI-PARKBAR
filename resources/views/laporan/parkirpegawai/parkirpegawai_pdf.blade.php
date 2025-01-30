<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Parkir Pegawai</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1,
        .header h3 {
            margin: 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .footer {
            text-align: right;
            margin-top: 20px;
            font-size: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Laporan Parkir Pegawai</h1>
        <h3>Periode: {{ \Carbon\Carbon::parse($tanggalMulai)->format('d-m-Y') }}
            s/d {{ \Carbon\Carbon::parse($tanggalSelesai)->format('d-m-Y') }}</h3>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Plat Kendaraan</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Nama Pegawai</th>
                {{-- <th>Status</th> --}}
            </tr>
        </thead>
        <tbody>
            @forelse ($dataParkir as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data->plat_kendaraan }}</td>
                    <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $data->jam_masuk ?? '-' }}</td>
                    <td>{{ $data->pegawai->nama }}</td>
                    {{-- <td>{{ $data->status }}</td> --}}
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Data tidak ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}
    </div>
</body>

</html>
