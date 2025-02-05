@extends('layout.main')

@section('pagename', 'LAPORAN PARKIR PEGAWAI')
@section('title', 'ParkBar - Laporan Parkir Pegawai')
@section('content')
    <div class="row">
        <!-- Datatables -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <!-- Form Filter -->
                    <form action="{{ route('laporan.parkirpegawai') }}" method="GET">
                        <!-- Bagian Tanggal Mulai dan Selesai -->
                        <div class="row mb-1">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="tanggal_mulai">Tanggal Mulai</label>
                                    <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai"
                                        value="{{ request('tanggal_mulai', $tanggalMulai) }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="tanggal_selesai">Tanggal Selesai</label>
                                    <input type="date" class="form-control" name="tanggal_selesai" id="tanggal_selesai"
                                        value="{{ request('tanggal_selesai', $tanggalSelesai) }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            {{-- <div class="col-md-12">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" name="status" id="status">
                                        <option value="">Semua</option>
                                        <option value="Terparkir" {{ request('status') == 'Terparkir' ? 'selected' : '' }}>
                                            Terparkir
                                        </option>
                                        <option value="Keluar" {{ request('status') == 'Keluar' ? 'selected' : '' }}>
                                            Keluar
                                        </option>
                                    </select>
                                </div>
                            </div> --}}
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

        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <a href="{{ route('laporan.parkirpegawai.cetak', ['tanggal_mulai' => $tanggalMulai, 'tanggal_selesai' => $tanggalSelesai, 'status' => request('status')]) }}"
                        target="_blank" class="btn btn-success mb-4">
                        <i class="fas fa-file-pdf"></i> Cetak
                    </a>
                </div>
                <div class="table-responsive p-3">
                    <table class="table table-striped table-bordered" id="dataTable" style="margin-top: 20px;">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Plat Kendaraan</th>
                                <th>Nama Pegawai</th>
                                <th>Tanggal</th>
                                <th>Jam Masuk</th>
                                {{-- <th>Status</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dataParkir as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->plat_kendaraan }}</td>
                                    <td>{{ $data->pegawai->nama }}</td>
                                    <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d-m-Y') }}</td>
                                    <td>{{ $data->jam_masuk ? \Carbon\Carbon::parse($data->jam_masuk)->format('H:i') : '-' }}
                                    </td>

                                    {{-- <td>
                                        <span
                                            class="badge badge-{{ $data->status === 'Terparkir' ? 'success' : 'secondary' }}">
                                            {{ $data->status }}
                                        </span>
                                    </td> --}}
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Data tidak ditemukan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
