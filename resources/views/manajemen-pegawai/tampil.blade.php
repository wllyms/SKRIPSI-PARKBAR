@extends('layout.main')

@section('pagename', 'PEGAWAI')
@section('title', 'ParkBar - Pegawai')
@section('content')

    <div class="row">
        <!-- Datatables -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div>
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            {!! session('success') !!}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-dagger alert-dismissible" role="alert">
                            {!! session('error') !!}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Data Pegawai</h6>
                    <div>
                        <!-- Button Modal -->
                        <button type="button" class="btn btn-primary bg-gradient-primary" data-toggle="modal"
                            data-target="#tambahModal">
                            Tambah
                        </button>
                    </div>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Plat Kendaraan</th>
                                <th>Nama</th>
                                {{-- <th>No.Telp</th> --}}
                                <th>Jenis Pegawai</th>
                                <th class="d-flex justify-content-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pegawai as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->plat_kendaraan }}</td>
                                    <td>{{ $data->nama }}</td>
                                    {{-- <td>{{ $data->no_telp }}</td> --}}
                                    <td>{{ $data->jenispegawai->jenis_pegawai }}</td>
                                    <td class="d-flex justify-content-center text-white">
                                        <a class="btn btn-info btn-sm mr-1"
                                            href="{{ route('manajemen-pegawai.detailpegawai', $data->id) }}">
                                            <i class="fa fa-id-card"></i>
                                        </a>
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
                            @include('manajemen-pegawai.tambah')

                            <!---- Modal Update ---->
                            @include('manajemen-pegawai.update')

                            <!---- Modal Delete ---->
                            @include('manajemen-pegawai.delete')

                            {{-- <!---- Modal Delete ---->
                            @include('manajemen-pegawai.cetak-pegawai') --}}

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
