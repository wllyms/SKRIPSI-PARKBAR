@extends('layout.main')

@section('pagename', 'DENDA')
@section('title', 'ParkBar - Denda')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <!-- Flash Messages -->
                <div class="p-3">
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
                </div>

                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Data Denda</h6>
                </div>

                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Plat Kendaraan</th>
                                <th>Tanggal</th>
                                <th>Nominal</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($denda as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->plat_kendaraan }}</td>
                                    <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d-m-Y') }}</td>
                                    <td>Rp{{ number_format($data->nominal, 0, ',', '.') }}</td>
                                    <td>
                                        @if ($data->status == 'Belum Dibayar')
                                            <span class="badge badge-danger">Belum Dibayar</span>
                                        @else
                                            <span class="badge badge-success">Sudah Dibayar</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($data->status == 'Belum Dibayar')
                                            <form action="{{ route('manajemen-denda.bayar', $data->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin membayar denda ini?')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">Bayar</button>
                                            </form>
                                        @else
                                            <span class="text-success font-weight-bold">Sudah Dibayar</span>
                                        @endif
                                        {{-- Tambahkan tombol aksi bila diperlukan --}}
                                        {{-- <a href="#" class="btn btn-sm btn-primary">Bayar</a> --}}
                                        {{-- <a href="#" class="btn btn-sm btn-danger">Hapus</a> --}}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Tidak ada data denda.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
