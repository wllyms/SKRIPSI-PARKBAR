@extends('layout.main')

@section('pagename', 'LAPORAN RIWAYAT PEGAWAI')
@section('title', 'ParkBar - Laporan Pegawai')
@section('content')

    <div class="row">
        <!-- Filter Form -->
        <div class="col-lg-12">
            <div class="card mb-4 shadow-sm">
                <div class="card-header font-weight-bold text-primary">
                    <i class="fas fa-filter"></i> Filter Laporan Pegawai
                </div>
                <div class="card-body">
                    <form action="{{ route('laporan.pegawai') }}" method="GET">
                        <div class="row">
                            {{-- Filter Jabatan --}}
                            <div class="col-md-6 mb-2">
                                <label for="jabatan_id" class="small font-weight-bold">Filter Jabatan</label>
                                <select name="jabatan_id" id="jabatan_id" class="form-control">
                                    <option value="">Semua</option>
                                    @foreach ($jabatan as $item)
                                        <option value="{{ $item->id }}"
                                            {{ request('jabatan_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama_jabatan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Filter Sub Jabatan --}}
                            <div class="col-md-6 mb-2">
                                <label for="sub_jabatan_id" class="small font-weight-bold">Filter Sub Jabatan</label>
                                <select name="sub_jabatan_id" id="sub_jabatan_id" class="form-control">
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

                        <div class="d-flex justify-content-between mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter"></i> Terapkan Filter
                            </button>

                            {{-- Cetak PDF (opsional, aktifkan jika route tersedia) --}}
                            <a href="{{ route('laporan.pegawai.cetak', request()->query()) }}" target="_blank"
                                class="btn btn-success">
                                <i class="fas fa-file-pdf"></i> Cetak PDF
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Tabel Laporan Pegawai -->
        <div class="col-lg-12">
            <div class="card mb-4 shadow-sm">

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
