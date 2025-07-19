<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Parkir RS Bhayangkara</title>
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

        header img {
            width: 100px;
            height: auto;
            margin-bottom: 10px;
        }

        h1 {
            margin: 5px 0;
            font-size: 22px;
            color: #222;
        }

        h4 {
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
        <img src="{{ public_path('storage/logo-rs.png') }}" alt="Logo RS Bhayangkara">
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
                <th>Waktu Masuk</th>
                <th>Waktu Keluar</th>
                <th>Durasi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($dataParkir as $data)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-uppercase">{{ $data->plat_kendaraan }}</td>
                    <td>
                        {{ $data->tarif->jenis_tarif ?? '-' }} -
                        {{ $data->tarif->kategori->nama_kategori ?? '-' }}
                    </td>
                    <td>
                        {{ $data->waktu_masuk ? \Carbon\Carbon::parse($data->waktu_masuk)->format('H:i - d/m/Y') : '-' }}
                    </td>
                    <td>
                        {{ $data->waktu_keluar ? \Carbon\Carbon::parse($data->waktu_keluar)->format('H:i - d/m/Y') : '-' }}
                    </td>
                    <td class="text-center">
                        @if ($data->durasi)
                            {{ floor($data->durasi / 60) }} jam {{ $data->durasi % 60 }} menit
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <span class="badge badge-{{ $data->status === 'Terparkir' ? 'success' : 'secondary' }}">
                            {{ $data->status }}
                        </span>
                    </td>
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
