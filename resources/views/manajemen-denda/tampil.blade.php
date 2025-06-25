@extends('layout.main')

@section('pagename', 'DENDA KENDARAAN')
@section('title', 'ParkBar - Denda Kendaraan')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">

                {{-- Notifikasi --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {!! session('success') !!}
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

                {{-- Header & Aksi --}}
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Data Denda Kendaraan</h6>
                </div>

                {{-- Table --}}
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Plat Kendaraan</th>
                                <th>Jam Masuk</th>
                                <th>Jam Keluar</th>
                                <th>Tarif</th>
                                <th>Denda</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Petugas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataDenda as $denda)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $denda->parkir->plat_kendaraan ?? '-' }}</td>
                                    <td>{{ optional($denda->parkir->waktu_masuk)->format('H:i - d/m/Y') ?? '-' }}</td>
                                    <td>{{ optional($denda->parkir->waktu_keluar)->format('H:i - d/m/Y') ?? '-' }}</td>
                                    <td class="text-right">
                                        Rp{{ number_format($denda->parkir->tarif->tarif ?? 0, 0, ',', '.') }}</td>
                                    <td class="text-right">Rp{{ number_format($denda->nominal, 0, ',', '.') }}</td>
                                    <td class="text-right">
                                        Rp{{ number_format(($denda->parkir->tarif->tarif ?? 0) + $denda->nominal, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <span
                                            class="badge badge-{{ $denda->status == 'Belum Dibayar' ? 'danger' : 'success' }}">
                                            {{ $denda->status }}
                                        </span>
                                    </td>
                                    <td>{{ $denda->parkir->user->staff->nama ?? '-' }}</td>
                                    <td class="d-flex justify-content-center">
                                        <!-- Tombol Modal -->
                                        @if ($denda->status == 'Belum Dibayar')
                                            <button class="btn btn-success btn-sm mr-1" data-toggle="modal"
                                                data-target="#bayarModal{{ $denda->id }}">
                                                <i class="fas fa-money-bill-wave"></i>
                                            </button>
                                        @endif

                                    </td>
                                </tr>

                                <!-- Modal Bayar -->
                                <div class="modal fade" id="bayarModal{{ $denda->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="bayarModalLabel{{ $denda->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <form action="{{ route('manajemen-denda.bayar', $denda->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header bg-success text-white">
                                                    <h5 class="modal-title">Konfirmasi Pembayaran Denda</h5>
                                                    <button type="button" class="close text-white" data-dismiss="modal"
                                                        aria-label="Tutup">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Plat:</strong> {{ $denda->parkir->plat_kendaraan ?? '-' }}
                                                    </p>
                                                    <p><strong>Denda:</strong>
                                                        Rp{{ number_format($denda->nominal, 0, ',', '.') }}</p>
                                                    <p><strong>Total:</strong>
                                                        Rp{{ number_format(($denda->parkir->tarif->tarif ?? 0) + $denda->nominal, 0, ',', '.') }}
                                                    </p>
                                                    <p class="text-danger">Apakah Anda yakin ingin melunasi denda ini?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">Ya, Bayar</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Batal</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
