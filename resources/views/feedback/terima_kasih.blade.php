@extends('layout.feedback')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">
                <div class="card shadow-sm text-center p-5">
                    <div class="card-body">
                        <i class="fas fa-check-circle fa-5x text-success mb-4"></i>
                        <h2 class="fw-bold">Terima Kasih!</h2>
                        <p class="lead">{{ $message }}</p>
                        <a href="#" class="btn btn-sm btn-outline-secondary mt-3" onclick="window.close();">Tutup
                            Halaman</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
