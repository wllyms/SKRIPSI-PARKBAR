<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Laporan Kepuasan Pengunjung - ParkBar</title>
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

        header img {
            width: 80px;
            /* Sedikit lebih kecil untuk proporsi */
            height: auto;
            margin-bottom: 10px;
        }

        h1 {
            margin: 5px 0;
            font-size: 20px;
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
            margin-top: 15px;
            font-size: 11px;
            /* Ukuran font tabel lebih kecil untuk PDF */
        }

        table th,
        table td {
            border: 1px solid #ccc;
            padding: 6px 8px;
            text-align: center;
        }

        table th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #007bff;
            margin-top: 25px;
            margin-bottom: 10px;
            border-bottom: 1px solid #007bff;
            padding-bottom: 5px;
        }

        .summary-box {
            border: 1px solid #ddd;
            padding: 10px;
            margin-top: 10px;
        }

        .summary-item {
            margin-bottom: 5px;
        }

        .comment-box {
            margin-top: 15px;
            padding-left: 10px;
            border-left: 3px solid #eee;
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
            font-size: 10px;
            display: inline-block;
        }

        .badge-info {
            background-color: #17a2b8;
        }

        .badge-warning {
            background-color: #ffc107;
        }

        .star {
            color: #ffc107;
        }
    </style>
</head>

<body>
    <header>
        {{-- Pastikan path ke logo Anda benar --}}
        <img src="{{ public_path('storage/logo-rs.png') }}" alt="Logo ParkBar" />
        <h1>Laporan Kepuasan Pengunjung</h1>
        <h4>Aplikasi Parkir ParkBar</h4>
        <h4>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} -
            {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}</h4>
    </header>

    <div class="section-title">Ringkasan Umum</div>
    <div class="summary-box">
        <div class="summary-item"><strong>Total Penilaian Diterima:</strong> {{ $totalPenilaian }}</div>
        <div class="summary-item"><strong>Rata-rata Rating Fasilitas:</strong>
            {{ number_format($avgRatingFasilitas, 2) }} / 5.00</div>
        <div class="summary-item"><strong>Rata-rata Rating Petugas:</strong> {{ number_format($avgRatingPetugas, 2) }} /
            5.00</div>
    </div>

    <div class="section-title">Analisis per Pertanyaan</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th class="text-left">Pertanyaan</th>
                <th>Kategori</th>
                <th class="text-right">Rata-rata Rating</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($analisisPertanyaan as $pertanyaan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="text-left">{{ $pertanyaan->teks_pertanyaan }}</td>
                    <td><span
                            class="badge badge-{{ $pertanyaan->kategori == 'fasilitas' ? 'info' : 'warning' }}">{{ ucfirst($pertanyaan->kategori) }}</span>
                    </td>
                    <td class="text-right"><span class="star">★</span>
                        {{ number_format($pertanyaan->avg_rating, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">Kinerja Petugas</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th class="text-left">Nama Petugas</th>
                <th>Jumlah Penilaian</th>
                <th class="text-right">Rata-rata Rating</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kinerjaPetugas as $petugas)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="text-left">{{ $petugas->staff->nama ?? 'N/A' }}</td>
                    <td>{{ $petugas->jumlah_penilaian }}</td>
                    <td class="text-right"><span class="star">★</span> {{ number_format($petugas->avg_rating, 2) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Tidak ada data penilaian untuk petugas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">Komentar Terbaru dari Pengunjung</div>
    @forelse ($komentarTerbaru as $komentar)
        <div class="comment-box">
            <p>
                <strong>Tanggal:</strong> {{ $komentar->created_at->format('d M Y, H:i') }} |
                <strong>Petugas Bertugas:</strong> {{ $komentar->petugas->staff->nama ?? 'N/A' }}
            </p>
            @if ($komentar->komentar_fasilitas)
                <p style="margin: 0;"><strong>Komentar Fasilitas:</strong>
                    <em>"{{ $komentar->komentar_fasilitas }}"</em>
                </p>
            @endif
            @if ($komentar->komentar_petugas)
                <p style="margin: 0;"><strong>Komentar Petugas:</strong> <em>"{{ $komentar->komentar_petugas }}"</em>
                </p>
            @endif
        </div>
    @empty
        <p>Tidak ada komentar pada rentang tanggal ini.</p>
    @endforelse


    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d F Y, H:i:s') }}
    </div>
</body>

</html>
