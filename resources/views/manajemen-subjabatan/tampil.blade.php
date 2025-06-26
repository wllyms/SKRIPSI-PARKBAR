@extends('layout.main')

@section('pagename', 'SUB JABATAN')
@section('title', 'ParkBar - Sub Jabatan')
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div>
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            {!! session('success') !!}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            {!! session('error') !!}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif
                </div>
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Data Sub Jabatan</h6>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahModal">
                        Tambah
                    </button>
                </div>
                <div class="table-responsive p-3">
                    <table class="table table-flush" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Sub Jabatan</th>
                                <th>Jabatan Induk</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subjabatan as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->nama_sub_jabatan }}</td>
                                    <td>{{ $data->jabatan->nama_jabatan ?? '-' }}</td>
                                    <td class="text-center">
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

                            @include('manajemen-subjabatan.tambah')
                            @include('manajemen-subjabatan.update')
                            @include('manajemen-subjabatan.delete')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
