@extends('layout.main')

@section('pagename', 'LAPORAN KENDARAAN')
@section('title', 'ParkBar - Laporan Parkir')

@section('content')
    <div class="row">
        <!-- Filter Card -->
        <div class="col-lg-12">
            <div class="card mb-4 shadow-sm">
                <div class="card-header font-weight-bold text-primary">Filter Data Kendaraan</div>
                <div class="card-body">
                    <form action="{{ route('laporan.parkir') }}" method="GET">
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <label for="tanggal_mulai" class="small font-weight-bold">Tanggal Mulai</label>
                                <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai"
                                    value="{{ request('tanggal_mulai', $tanggalMulai) }}">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="tanggal_selesai" class="small font-weight-bold">Tanggal Selesai</label>
                                <input type="date" class="form-control" name="tanggal_selesai" id="tanggal_selesai"
                                    value="{{ request('tanggal_selesai', $tanggalSelesai) }}">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="status" class="small font-weight-bold">Status</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="">Semua</option>
                                    <option value="Terparkir" {{ request('status') == 'Terparkir' ? 'selected' : '' }}>
                                        Terparkir</option>
                                    <option value="Keluar" {{ request('status') == 'Keluar' ? 'selected' : '' }}>Keluar
                                    </option>
                                </select>
                            </div>
                        </div> 
                        <div class="d-flex justify-content-between mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter"></i> Terapkan Filter
                            </button>
                            <a href="{{ route('laporan.parkir.cetak', ['tanggal_mulai' => $tanggalMulai, 'tanggal_selesai' => $tanggalSelesai, 'status' => request('status')]) }}"
                                target="_blank" class="btn btn-success">
                                <i class="fas fa-file-pdf"></i> Cetak PDF
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card shadow-sm">
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable">
                            <thead class="thead-light text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Plat Kendaraan</th>
                                    <th>Jenis Tarif</th>
                                    <th>Masuk</th>
                                    <th>Keluar</th>
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
                                            <span
                                                class="badge badge-{{ $data->status === 'Terparkir' ? 'success' : 'secondary' }}">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
