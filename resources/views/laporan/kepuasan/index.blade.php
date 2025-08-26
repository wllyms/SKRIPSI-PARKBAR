@extends('layout.main')

@section('pagename', 'LAPORAN KEPUASAN PENGUNJUNG')
@section('title', 'ParkBar - Laporan Kepuasan')

@section('content')

    {{-- Filter Tanggal --}}
    <div class="col-lg-12">
        <div class="card mb-4 shadow-sm">
            <div class="card-header font-weight-bold text-primary">
                <i class="fas fa-filter"></i> Filter Laporan Kepuasan
            </div>

            <div class="card-body">
                <form action="{{ route('laporan.kepuasan.index') }}" method="GET">
                    <div class="row">
                        {{-- Dari Tanggal --}}
                        <div class="col-md-6 mb-2">
                            <label for="start_date" class="small font-weight-bold">Dari Tanggal</label>
                            <input type="date" name="start_date" id="start_date" class="form-control"
                                value="{{ request('start_date', $startDate->format('Y-m-d')) }}">
                        </div>

                        {{-- Sampai Tanggal --}}
                        <div class="col-md-6 mb-2">
                            <label for="end_date" class="small font-weight-bold">Sampai Tanggal</label>
                            <input type="date" name="end_date" id="end_date" class="form-control"
                                value="{{ request('end_date', $endDate->format('Y-m-d')) }}">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Terapkan Filter
                        </button>
                        <a href="{{ route('laporan.kepuasan.cetak', request()->query()) }}" target="_blank"
                            class="btn btn-success">
                            <i class="fas fa-file-pdf"></i> Cetak PDF
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- Statistik Umum --}}
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Penilaian</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPenilaian }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-receipt fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Avg. Rating Fasilitas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($avgRatingFasilitas, 2) }}
                                / 5.00</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-building fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Avg. Rating Petugas</div>
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                {{ number_format($avgRatingPetugas, 2) }} / 5.00</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Analisis Kinerja Petugas & per Pertanyaan --}}
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Kinerja Petugas</h6>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th>Nama Petugas</th>
                                <th class="text-center">Jml. Penilaian</th>
                                <th class="text-center">Rata-rata Rating</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kinerjaPetugas as $petugas)
                                <tr>
                                    <td>{{ $petugas->staff->nama ?? 'N/A' }}</td>
                                    <td class="text-center">{{ $petugas->jumlah_penilaian }}</td>
                                    <td class="text-center"><i class="fas fa-star text-warning"></i>
                                        {{ number_format($petugas->avg_rating, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada data penilaian untuk petugas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Analisis per Pertanyaan</h6>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th>Pertanyaan</th>
                                <th class="text-center">Kategori</th>
                                <th class="text-center">Rata-rata Rating</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($analisisPertanyaan as $pertanyaan)
                                <tr>
                                    <td>{{ $pertanyaan->teks_pertanyaan }}</td>
                                    <td class="text-center"><span
                                            class="badge badge-{{ $pertanyaan->kategori == 'fasilitas' ? 'info' : 'warning' }}">{{ ucfirst($pertanyaan->kategori) }}</span>
                                    </td>
                                    <td class="text-center"><i class="fas fa-star text-warning"></i>
                                        {{ number_format($pertanyaan->avg_rating, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Data tidak ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Komentar Terbaru --}}
    <div class="card shadow-sm">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Komentar Terbaru dari Pengunjung</h6>
        </div>
        <div class="card-body" style="max-height: 400px; overflow-y: auto;">
            @forelse ($komentarTerbaru as $komentar)
                <div class="mb-3 border-bottom pb-2">
                    <p class="mb-1">
                        <small class="text-muted">{{ $komentar->created_at->format('d M Y, H:i') }} | Petugas:
                            {{ $komentar->petugas->staff->nama ?? 'N/A' }}</small>
                    </p>
                    @if ($komentar->komentar_fasilitas)
                        <blockquote class="blockquote-footer mb-1">"{{ $komentar->komentar_fasilitas }}" <cite>- Komentar
                                Fasilitas</cite></blockquote>
                    @endif
                    @if ($komentar->komentar_petugas)
                        <blockquote class="blockquote-footer mb-0">"{{ $komentar->komentar_petugas }}" <cite>- Komentar
                                Petugas</cite></blockquote>
                    @endif
                </div>
            @empty
                <p class="text-center text-muted">Belum ada komentar yang masuk pada rentang tanggal ini.</p>
            @endforelse
        </div>
    </div>

@endsection
