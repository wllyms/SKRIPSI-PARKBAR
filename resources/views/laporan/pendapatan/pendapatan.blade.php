@extends('layout.main')

@section('pagename', 'LAPORAN PENDAPATAN')
@section('title', 'ParkBar - Laporan Pendapatan')
@section('content')
    <div class="row">
        <!-- Filter Form -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <form action="{{ route('laporan.pendapatan') }}" method="GET">
                        <div class="row mb-1">
                            <!-- Filter Tanggal Mulai -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="tanggal_mulai">Tanggal Mulai</label>
                                    <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai"
                                        value="{{ request('tanggal_mulai', $tanggalMulai) }}">
                                </div>
                            </div>
                            <!-- Filter Tanggal Selesai -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="tanggal_selesai">Tanggal Selesai</label>
                                    <input type="date" class="form-control" name="tanggal_selesai" id="tanggal_selesai"
                                        value="{{ request('tanggal_selesai', $tanggalSelesai) }}">
                                </div>
                            </div>
                        </div>
                        <!-- Filter Jenis Tarif -->
                        <div class="row mb-1">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="jenis_tarif">Jenis Tarif</label>
                                    <select class="form-control" name="jenis_tarif" id="jenis_tarif">
                                        <option value="">Semua</option>
                                        @foreach ($jenisTarifList as $jenis)
                                            <option value="{{ $jenis->jenis_tarif }}"
                                                {{ request('jenis_tarif') == $jenis->jenis_tarif ? 'selected' : '' }}>
                                                {{ ucfirst($jenis->jenis_tarif) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- Tombol Filter -->
                        <div class="row mb-3">
                            <div class="col-md-6 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabel Laporan Pendapatan -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <a href="{{ route('laporan.pendapatan.cetak', ['tanggal_mulai' => request('tanggal_mulai', $tanggalMulai), 'tanggal_selesai' => request('tanggal_selesai', $tanggalSelesai), 'jenis_tarif' => request('jenis_tarif')]) }}"
                        target="_blank" class="btn btn-success">
                        <i class="fas fa-file-pdf"></i> Cetak
                    </a>
                    <h4 class="mb-0">Total Pendapatan: Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h4>
                </div>
                <div class="table-responsive p-3">
                    <table class="table table-striped table-bordered" id="dataTable" style="margin-top: 20px;">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Plat Kendaraan</th>
                                <th>Jenis Tarif</th>
                                <th>Jam Masuk</th>
                                <th>Tanggal</th>
                                <th>Tarif</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataParkir as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->plat_kendaraan }}</td>
                                    <td>{{ ucfirst($data->tarif->jenis_tarif ?? '-') }}</td>
                                    <td>{{ $data->jam_masuk }}</td>
                                    <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d-m-Y') }}</td>
                                    <td>Rp {{ number_format($data->tarif->tarif ?? 0, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
