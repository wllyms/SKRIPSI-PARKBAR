<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Laporan Denda Parkir RS Bhayangkara</title>
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
            padding: 8px 10px;
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

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
            color: #777;
            border-top: 2px solid #000;
            padding-top: 10px;
        }

        .badge {
            padding: 3px 6px;
            border-radius: 3px;
            color: white;
            font-weight: 600;
            font-size: 12px;
            display: inline-block;
        }

        .badge-danger {
            background-color: #dc3545;
        }

        .badge-success {
            background-color: #28a745;
        }
    </style>
</head>

<body>
    <header>
        <img src="{{ public_path('storage/logo-rs.png') }}" alt="Logo RS Bhayangkara" />
        <h1>Laporan Denda Parkir</h1>
        <h4>RS Bhayangkara Banjarmasin</h4>
        <h4>Periode: {{ \Carbon\Carbon::parse($tanggalMulai)->format('d-m-Y') }} -
            {{ \Carbon\Carbon::parse($tanggalSelesai)->format('d-m-Y') }}</h4>
        <h4>Status: {{ $status ? \Illuminate\Support\Str::title($status) : 'Semua Status' }}</h4>
    </header>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Plat Kendaraan</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th class="text-right">Tarif Parkir</th>
                <th class="text-right">Denda</th>
                <th class="text-right">Total</th>
                <th>Status</th>
                <th>Petugas</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($dataDenda as $denda)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="text-left">{{ $denda->parkir->plat_kendaraan ?? '-' }}</td>
                    <td>
                        {{ $denda->parkir->waktu_masuk ? \Carbon\Carbon::parse($denda->parkir->waktu_masuk)->format('H:i - d/m/Y') : '-' }}
                    </td>
                    <td>
                        {{ $denda->parkir->waktu_keluar ? \Carbon\Carbon::parse($denda->parkir->waktu_keluar)->format('H:i - d/m/Y') : '-' }}
                    </td>
                    <td class="text-right">
                        Rp{{ number_format($denda->parkir->tarif->tarif ?? 0, 0, ',', '.') }}
                    </td>
                    <td class="text-right">
                        Rp{{ number_format($denda->nominal, 0, ',', '.') }}
                    </td>
                    <td class="text-right">
                        Rp{{ number_format(($denda->parkir->tarif->tarif ?? 0) + $denda->nominal, 0, ',', '.') }}
                    </td>
                    <td>
                        <span class="badge badge-{{ $denda->status === 'Belum Dibayar' ? 'danger' : 'success' }}">
                            {{ $denda->status }}
                        </span>
                    </td>
                    <td class="text-left">{{ $denda->parkir->user->staff->nama ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">Tidak ada data denda</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d-m-Y') }}
    </div>
</body>

</html>
