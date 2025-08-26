@extends('layout.feedback')

@section('content')
    <div class="container">
        <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
            <div class="col-md-8 col-lg-6">
                {{-- Mengganti card biasa dengan card yang lebih menonjol --}}
                <div class="card border-0 shadow-lg text-center p-4 p-md-5">
                    <div class="card-body">
                        {{-- Animasi sederhana untuk ikon --}}
                        <div class="mb-4">
                            <i class="fas fa-check-circle fa-5x text-success" style="animation: pop-in 0.5s ease-out;"></i>
                        </div>

                        <h2 class="fw-bolder mb-3">Terima Kasih!</h2>

                        {{-- Memberikan pesan yang lebih jelas dan personal --}}
                        <p class="lead text-muted mb-4">
                            {{ $message ?? 'Masukan Anda telah berhasil kami simpan dan sangat berarti untuk meningkatkan kualitas layanan kami.' }}
                        </p>

                        {{-- Tombol yang lebih jelas dan user-friendly --}}
                        <button class="btn btn-primary" onclick="window.close();" title="Tutup tab ini">
                            <i class="fas fa-times"></i> Tutup Halaman
                        </button>

                        {{-- Penambahan footer kecil --}}
                        <div class="mt-5">
                            <small class="text-muted">PARKBARA &copy; {{ date('Y') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- Menambahkan sedikit CSS untuk animasi di layout --}}
@push('styles')
    <style>
        @keyframes pop-in {
            0% {
                transform: scale(0.5);
                opacity: 0;
            }

            80% {
                transform: scale(1.1);
                opacity: 1;
            }

            100% {
                transform: scale(1);
            }
        }
    </style>
@endpush
