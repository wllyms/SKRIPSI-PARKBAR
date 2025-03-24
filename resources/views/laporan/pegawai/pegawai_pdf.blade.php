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

        header img {
            width: 100px;
            height: auto;
            margin-bottom: 10px;
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

        .text-center {
            text-align: center;
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

        .img-pegawai {
            width: 60px;
            height: 65px;
            object-fit: contain;
            /* Menjaga rasio aspek gambar */
            border: 1px solid #ddd;
        }
    </style>
</head>

<body>
    <header>
        <img src="{{ public_path('storage/logo-rs.png') }}" alt="Logo RS Bhayangkara">
        <h1>Laporan Pegawai</h1>
        <h4>RS Bhayangkara Banjarmasin</h4>
    </header>

    <div class="divider"></div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Foto Pegawai</th>
                <th>Nama</th>
                <th>No. Telp</th>
                <th>Jenis Pegawai</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pegawai as $data)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">
                        @if ($data->image)
                            <img src="{{ public_path('storage/' . $data->image) }}" alt="Foto Pegawai" class="img-pegawai">
                        @else
                            <p>Tidak Ada Gambar</p>
                        @endif
                    </td>
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

    <div class="divider"></div>

    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d-m-Y') }}
    </div>
</body>

</html>
