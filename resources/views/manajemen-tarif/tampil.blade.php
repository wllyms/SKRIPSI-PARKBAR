@extends('layout.main')

@section('pagename', 'TARIF PARKIR')
@section('title', 'ParkBar - Tarif')
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
                    <h6 class="m-0 font-weight-bold text-primary">Data Tarif</h6>
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
                                <th>Jenis Tarif</th>
                                <th>Tarif</th>
                                <th>Kategori</th>
                                <th class="d-flex justify-content-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tarif as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->jenis_tarif }}</td>
                                    <td>{{ $data->tarif }}</td>
                                    <td>{{ $data->kategori->nama_kategori }}</td>
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
                            @include('manajemen-tarif.tambah')

                            <!---- Modal Update ---->
                            @include('manajemen-tarif.update')

                            <!---- Modal Delete ---->
                            @include('manajemen-tarif.delete')

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



@endsection
