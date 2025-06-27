{{-- Menggunakan layout terpisah yang sudah kita rancang untuk pengunjung --}}
@extends('layout.feedback')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">

                <div class="text-center mb-4">
                    {{-- Ganti dengan path logo Anda jika ada, jika tidak, teks saja sudah cukup --}}
                    {{-- <img src="{{ asset('path/to/your/logo.png') }}" alt="ParkBar Logo" style="max-height: 60px;"> --}}
                    <h1 class="h2 fw-bold mt-2">PARKBAR</h1>
                    <p class="text-muted">Bantu kami menjadi lebih baik. Mohon berikan penilaian Anda.</p>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Formulir Kepuasan Pelanggan</h4>
                    </div>
                    <div class="card-body p-4">
                        {{-- Tampilkan error validasi jika ada --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    - {{ $error }}<br>
                                @endforeach
                            </div>
                        @endif

                        <form action="{{ route('feedback.dynamic.store') }}" method="POST">
                            @csrf
                            {{-- Data tersembunyi untuk dikirim ke controller --}}
                            <input type="hidden" name="parkir_id" value="{{ $parkir->id }}">
                            <input type="hidden" name="tuser_id" value="{{ $parkir->user_id }}">

                            {{-- =============================================== --}}
                            {{--      BAGIAN KUESIONER DINAMIS DIMULAI DI SINI     --}}
                            {{-- =============================================== --}}

                            {{-- Loop untuk kategori 'fasilitas' --}}
                            @if (isset($pertanyaanTerkelompok['fasilitas']))
                                <h5 class="fw-bold text-primary">1. Penilaian Fasilitas Parkir</h5>
                                <hr class="mt-2 mb-4">
                                @foreach ($pertanyaanTerkelompok['fasilitas'] as $pertanyaan)
                                    <div class="mb-4">
                                        <p class="mb-2"><strong>{{ $loop->iteration }}.
                                                {{ $pertanyaan->teks_pertanyaan }}</strong></p>
                                        <div class="star-rating">
                                            {{-- Loop untuk membuat 5 bintang rating --}}
                                            @for ($i = 5; $i >= 1; $i--)
                                                <input type="radio" id="rating-{{ $pertanyaan->id }}-{{ $i }}"
                                                    name="ratings[{{ $pertanyaan->id }}]" value="{{ $i }}"
                                                    required />
                                                <label for="rating-{{ $pertanyaan->id }}-{{ $i }}"><i
                                                        class="fas fa-star"></i></label>
                                            @endfor
                                        </div>
                                    </div>
                                @endforeach
                                <div class="mb-4">
                                    <label for="komentar_fasilitas" class="form-label"><strong>Komentar untuk Fasilitas
                                            (Opsional):</strong></label>
                                    <textarea name="komentar_fasilitas" class="form-control" rows="3"
                                        placeholder="Tuliskan masukan Anda tentang fasilitas..."></textarea>
                                </div>
                            @endif


                            {{-- Loop untuk kategori 'petugas' --}}
                            @if (isset($pertanyaanTerkelompok['petugas']))
                                <h5 class="fw-bold text-primary mt-5">2. Penilaian Pelayanan Petugas</h5>
                                <p class="text-muted">Anda dilayani oleh: <strong>{{ $namaPetugas }}</strong></p>
                                <hr class="mt-2 mb-4">
                                @foreach ($pertanyaanTerkelompok['petugas'] as $pertanyaan)
                                    <div class="mb-4">
                                        <p class="mb-2"><strong>{{ $loop->iteration }}.
                                                {{ $pertanyaan->teks_pertanyaan }}</strong></p>
                                        <div class="star-rating">
                                            {{-- Loop untuk membuat 5 bintang rating --}}
                                            @for ($i = 5; $i >= 1; $i--)
                                                <input type="radio"
                                                    id="rating-{{ $pertanyaan->id }}-{{ $i }}"
                                                    name="ratings[{{ $pertanyaan->id }}]" value="{{ $i }}"
                                                    required />
                                                <label for="rating-{{ $pertanyaan->id }}-{{ $i }}"><i
                                                        class="fas fa-star"></i></label>
                                            @endfor
                                        </div>
                                    </div>
                                @endforeach
                                <div class="mb-4">
                                    <label for="komentar_petugas" class="form-label"><strong>Komentar untuk Petugas
                                            (Opsional):</strong></label>
                                    <textarea name="komentar_petugas" class="form-control" rows="3"
                                        placeholder="Tuliskan masukan Anda tentang pelayanan petugas..."></textarea>
                                </div>
                            @endif

                            {{-- =============================================== --}}
                            {{--         BAGIAN KUESIONER DINAMIS SELESAI          --}}
                            {{-- =============================================== --}}

                            <div class="d-grid mt-5">
                                <button type="submit" class="btn btn-primary btn-lg">Kirim Penilaian</button>
                            </div>
                        </form>
                    </div>
                </div>

                <p class="text-center text-muted mt-3 small">&copy; {{ date('Y') }} ParkBar. All Rights Reserved.</p>

            </div>
        </div>
    </div>
@endsection
