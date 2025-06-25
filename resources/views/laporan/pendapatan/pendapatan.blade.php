@extends('layout.main')

@section('pagename', 'LAPORAN PENDAPATAN')
@section('title', 'ParkBar - Laporan Pendapatan')
@section('content')
    <div class="row">
        <!-- Filter Card -->
        <div class="col-lg-12">
            <div class="card mb-4 shadow-sm">
                <div class="card-header font-weight-bold text-primary">Filter Data Pendapatan</div>
                <div class="card-body">
                    <form action="{{ route('laporan.pendapatan') }}" method="GET">
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <label for="tanggal_mulai" class="small font-weight-bold">Tanggal Mulai</label>
                                <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai"
                                    value="{{ request('tanggal_mulai', $tanggalMulai->format('Y-m-d')) }}">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="tanggal_selesai" class="small font-weight-bold">Tanggal Selesai</label>
                                <input type="date" class="form-control" name="tanggal_selesai" id="tanggal_selesai"
                                    value="{{ request('tanggal_selesai', $tanggalSelesai->format('Y-m-d')) }}">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="jenis_tarif" class="small font-weight-bold">Jenis Tarif</label>
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
                        <div class="d-flex justify-content-between mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter"></i> Terapkan Filter
                            </button>
                            <a href="{{ route('laporan.pendapatan.cetak', [
                                'tanggal_mulai' => request('tanggal_mulai', $tanggalMulai->format('Y-m-d')),
                                'tanggal_selesai' => request('tanggal_selesai', $tanggalSelesai->format('Y-m-d')),
                                'jenis_tarif' => request('jenis_tarif'),
                            ]) }}"
                                target="_blank" class="btn btn-success">
                                <i class="fas fa-file-pdf"></i> Cetak PDF
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Tabel Laporan Pendapatan --> 
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Total Pendapatan: Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h4>
                </div>
                <div class="table-responsive p-3">
                    <table class="table table-striped table-bordered" id="dataTable" style="margin-top: 20px;">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Plat Kendaraan</th>
                                <th>Jenis Tarif - Kategori</th>
                                <th>Waktu Masuk</th>
                                <th>Waktu Keluar</th>
                                <th>Tarif</th>
                                <th>Denda</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dataParkir as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->plat_kendaraan }}</td>
                                    <td>
                                        {{ ucfirst($data->tarif->jenis_tarif ?? '-') }}
                                        -
                                        {{ $data->tarif->kategori->nama_kategori ?? '-' }}
                                    </td>
                                    <td>{{ $data->waktu_masuk ? \Carbon\Carbon::parse($data->waktu_masuk)->format('H:i - d/m/Y') : '-' }}
                                    </td>
                                    <td>{{ $data->waktu_keluar ? \Carbon\Carbon::parse($data->waktu_keluar)->format('H:i - d/m/Y') : '-' }}
                                    </td>
                                    <td>Rp {{ number_format($data->tarif->tarif ?? 0, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($data->denda->nominal ?? 0, 0, ',', '.') }}</td>
                                    <td>
                                        Rp
                                        {{ number_format(($data->tarif->tarif ?? 0) + ($data->denda->nominal ?? 0), 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Data tidak ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
