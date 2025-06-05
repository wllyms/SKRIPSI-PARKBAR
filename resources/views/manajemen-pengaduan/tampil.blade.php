@extends('layout.main')

@section('pagename', 'PENGADUAN PENGUNJUNG')
@section('title', 'ParkBar - Pengaduan Pengunjung')
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {!! session('success') !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if (session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {!! session('warning') !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {!! session('error') !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif


                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Data Pengaduan Pengunjung</h6>
                    <div>
                        <!-- Button Modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahModal">
                            Tambah
                        </button>
                    </div>
                </div>

                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Tanggal & Waktu Lapor</th>
                                <th>No Telp</th>
                                <th>Keterangan</th>
                                <th>Petugas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($laporan as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->nama }}</td>
                                    <td>{{ \Carbon\Carbon::parse($data->waktu_lapor)->format('d-m-Y H:i') }}</td>
                                    <td>{{ $data->no_telp }}</td>
                                    <td>{{ $data->keterangan }}</td>
                                    <td>{{ $data->user->staff->nama ?? '-' }}</td>
                                    <td class="d-flex justify-content-center text-white">
                                        <button class="btn btn-warning btn-sm mr-1" data-toggle="modal"
                                            data-target="#editModal{{ $data->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#deleteModal{{ $data->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach

                            <!---- Modal Tambah ---->
                            @include('manajemen-pengaduan.tambah')

                            <!---- Modal Update ---->
                            @include('manajemen-pengaduan.update')

                            <!---- Modal Delete ---->
                            @include('manajemen-pengaduan.delete')

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
