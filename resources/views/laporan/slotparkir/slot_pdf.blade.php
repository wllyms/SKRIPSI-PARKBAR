<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Slot Parkir</title>
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
        <h1>Laporan Slot Parkir</h1>
        <h4>RS Bhayangkara Banjarmasin</h4>
        <h4>Periode: {{ \Carbon\Carbon::parse($tanggalMulai)->format('d-m-Y') }} -
            {{ \Carbon\Carbon::parse($tanggalSelesai)->format('d-m-Y') }}</h4>
        <h4>Slot: {{ $slotId ? $namaSlot : 'Semua Slot' }}</h4>
    </header>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Slot</th>
                <th>Kapasitas</th>
                <th>Terisi Sekarang</th>
                <th>Total Keluar</th>
                <th>Riwayat Terisi (Masuk)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($dataSlot as $slot)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $slot->nama_slot }}</td>
                    <td>{{ $slot->kapasitas }}</td>
                    <td>{{ $slot->terpakai_sekarang ?? 0 }}</td>
                    <td>{{ $slot->total_keluar ?? 0 }}</td>
                    <td>{{ $slot->riwayat_terisi ?? 0 }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Data tidak ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d-m-Y') }}
    </div>
</body>

</html>
