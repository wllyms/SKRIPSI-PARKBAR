@extends('layout.main')

@section('pagename', 'LAPORAN PARKIR PEGAWAI')
@section('title', 'ParkBar - Laporan Parkir Pegawai')

@section('content')
    <div class="row">
        <!-- Filter Card -->
        <div class="col-lg-12">
            <div class="card mb-4 shadow-sm">
                <div class="card-header font-weight-bold text-primary">Filter Data Parkir Pegawai</div>
                <div class="card-body">
                    <form action="{{ route('laporan.parkirpegawai') }}" method="GET">
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
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter"></i> Terapkan Filter
                            </button>
                            <a href="{{ route('laporan.parkirpegawai.cetak', ['tanggal_mulai' => $tanggalMulai, 'tanggal_selesai' => $tanggalSelesai]) }}"
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
                                    <th style="width: 5%;">No</th>
                                    <th>Kode Pegawai</th>
                                    <th>Plat Kendaraan</th>
                                    <th>Nama Pegawai</th>
                                    <th>Tanggal</th>
                                    <th>Jam Masuk</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dataParkir as $data)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $data->kode_member }}</td>
                                        <td class="text-uppercase">{{ $data->plat_kendaraan }}</td>
                                        <td>{{ $data->pegawai->nama ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d-m-Y') }}</td>
                                        <td class="text-center">
                                            {{ $data->jam_masuk ? \Carbon\Carbon::parse($data->jam_masuk)->format('H:i') : '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Data tidak ditemukan</td>
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
