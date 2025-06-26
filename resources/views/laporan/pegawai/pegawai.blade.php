@extends('layout.main')

@section('pagename', 'LAPORAN PEGAWAI')
@section('title', 'ParkBar - Laporan Pegawai')
@section('content')

    <div class="row">
        <!-- Filter Form -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <form action="{{ route('laporan.pegawai') }}" method="GET" class="w-100">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="jabatan_id">Filter Jabatan</label>
                                <select name="jabatan_id" class="form-control">
                                    <option value="">Semua</option>
                                    @foreach ($jabatan as $item)
                                        <option value="{{ $item->id }}"
                                            {{ request('jabatan_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama_jabatan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="sub_jabatan_id">Filter Sub Jabatan</label>
                                <select name="sub_jabatan_id" class="form-control">
                                    <option value="">Semua</option>
                                    @foreach ($subjabatan as $item)
                                        <option value="{{ $item->id }}"
                                            {{ request('sub_jabatan_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama_sub_jabatan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">
                            <i class="fas fa-filter"></i> Terapkan Filter
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabel Laporan Pegawai -->
        <div class="col-lg-12">
            <div class="card mb-4 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="m-0 text-primary">Laporan Data Pegawai</h5>
                    <a href="{{ route('laporan.pegawai.cetak', ['jenis_pegawai' => request('jenis_pegawai')]) }}"
                        target="_blank" class="btn btn-success">
                        <i class="fas fa-file-pdf"></i> Cetak PDF
                    </a>
                </div>

                <div class="table-responsive p-3">
                    <table class="table table-striped table-bordered" id="dataTable">
                        <thead class="thead-light text-center">
                            <tr>
                                <th>No</th>
                                <th>Plat Kendaraan</th>
                                <th>Nama</th>
                                <th>No. Telp</th>
                                <th>Jabatan</th>
                                <th>Sub Jabatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pegawai as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->plat_kendaraan }}</td>
                                    <td>{{ $data->nama }}</td>
                                    <td>{{ $data->no_telp }}</td>
                                    <td>{{ $data->jabatan->nama_jabatan ?? '-' }}</td>
                                    <td>{{ $data->subjabatan->nama_sub_jabatan ?? '-' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('laporan.detailpegawai.show', $data->id) }}"
                                            class="btn btn-info btn-sm"> 
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
