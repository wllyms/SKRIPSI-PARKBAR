<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laporan Detail Pegawai</title>
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
        }

        table th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
            color: #777;
        }

        h3 {
            margin-top: 40px;
            color: #007bff;
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

    <!-- Photo -->
    <div class="photo">
        @if (!empty($data->image))
            <img src="{{ public_path('storage/' . $data->image) }}" alt="Foto Pegawai">
        @else
            <p><em>Foto tidak tersedia</em></p>
        @endif
    </div>

    <!-- Tabel Detail Pegawai -->
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

    <!-- Tabel Riwayat Sub Jabatan -->
    @if ($data->riwayatSubJabatans && $data->riwayatSubJabatans->count())
        <h3>Riwayat Sub Jabatan</h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Sub Jabatan</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data->riwayatSubJabatans as $index => $riwayat)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $riwayat->nama_sub_jabatan }}</td>
                        <td>{{ \Carbon\Carbon::parse($riwayat->pivot->tanggal_mulai)->format('d-m-Y') }}</td>
                        <td>
                            {{ $riwayat->pivot->tanggal_selesai
                                ? \Carbon\Carbon::parse($riwayat->pivot->tanggal_selesai)->format('d-m-Y')
                                : '-' }}
                        </td>
                        <td>{{ $riwayat->pivot->keterangan ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Footer -->
    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d-m-Y') }}
