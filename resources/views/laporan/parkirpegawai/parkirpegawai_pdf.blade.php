<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Parkir Pegawai</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 25px;
            color: #333;
            font-size: 12px;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #000;
        }

        .logo {
            width: 80px;
            height: auto;
            margin-bottom: 10px;
        }

        h1 {
            margin: 5px 0;
            font-size: 20px;
        }

        h3 {
            margin: 3px 0;
            font-size: 14px;
            font-weight: normal;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 10px;
            /* Ukuran font dikecilkan agar muat */
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: center;
        }

        table th {
            background-color: #007bff;
            color: white;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
        }

        .badge {
            padding: 3px 6px;
            border-radius: 3px;
            color: white;
            font-size: 10px;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-secondary {
            background-color: #6c757d;
        }
    </style>
</head>

<body>
    <header>
        {{-- Pastikan path ke logo Anda benar --}}
        <img src="{{ public_path('storage/logo-rs.png') }}" alt="Logo ParkBara" class="logo">
        <h1>Laporan Riwayat Parkir Pegawai</h1>
        <h3>RS Bhayangkara Banjarmasin</h3>
        <h3>Periode: {{ \Carbon\Carbon::parse($tanggalMulai)->format('d-m-Y') }}
            s/d {{ \Carbon\Carbon::parse($tanggalSelesai)->format('d-m-Y') }}</h3>
    </header>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th>Nama Pegawai</th>
                <th>Kode Member</th>
                <th>Plat Kendaraan</th>
                {{-- REVISI KOLOM TABEL --}}
                <th>Waktu Masuk</th>
                <th>Waktu Keluar</th>
                <th>Durasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($dataParkir as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data->pegawai->nama ?? '-' }}</td>
                    <td>{{ $data->kode_member }}</td>
                    <td>{{ $data->plat_kendaraan }}</td>

                    {{-- REVISI TAMPILAN DATA --}}
                    <td>{{ $data->waktu_masuk->format('d-m-Y H:i') }}</td>
                    <td>
                        @if ($data->waktu_keluar)
                            {{ $data->waktu_keluar->format('d-m-Y H:i') }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if ($data->waktu_keluar)
                            {{-- Menggunakan format diffForHumans untuk durasi --}}
                            {{ $data->waktu_masuk->diffForHumans($data->waktu_keluar, true) }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    {{-- Sesuaikan colspan menjadi 8 --}}
                    <td colspan="8" style="text-align: center;">Data tidak ditemukan pada rentang tanggal ini</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d-m-Y') }}
    </div>
</body>

</html>
