@extends('layout.main')

@section('pagename', 'MANAJEMEN KUESIONER')
@section('title', 'ParkBar - Manajemen Kuesioner')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4 shadow-sm">
                {{-- Menampilkan pesan sukses atau error --}}
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
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            {!! session('error') !!}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>

                {{-- Header Card --}}
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Data Pertanyaan Kuesioner</h6>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahModal">
                        <i class="fas fa-plus"></i> Tambah Pertanyaan
                    </button>
                </div>

                {{-- Tabel Data --}}
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Teks Pertanyaan</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Urutan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kuesioner as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->teks_pertanyaan }}</td>
                                    <td>
                                        <span
                                            class="badge badge-{{ $data->kategori == 'fasilitas' ? 'info' : 'warning' }}">{{ ucfirst($data->kategori) }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge badge-{{ $data->status == 'aktif' ? 'success' : 'secondary' }}">{{ ucfirst($data->status) }}</span>
                                    </td>
                                    <td>{{ $data->urutan }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#editModal{{ $data->id }}" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#deleteModal{{ $data->id }}" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Memanggil semua modal dari file terpisah --}}
    @include('manajemen-kuesioner.tambah')
    @include('manajemen-kuesioner.update')
    @include('manajemen-kuesioner.delete')
@endsection
