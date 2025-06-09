@extends('layout.main')

@section('pagename', 'Dashboard')
@section('title', 'ParkBar - Beranda')
@section('content')

    <div class="container-fluid">
        <div class="row mb-4">
            <!-- Card Kendaraan Terparkir -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Kendaraan Terparkir
                                    Hari Ini</div>
                                <div class="h3 font-weight-bold text-gray-800">{{ $totalTerparkir }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-car-side fa-3x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Kendaraan Keluar -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Kendaraan Keluar Hari
                                    Ini</div>
                                <div class="h3 font-weight-bold text-gray-800">{{ $totalKeluar }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-sign-out-alt fa-3x text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Pendapatan Hari Ini -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pendapatan Hari Ini
                                </div>
                                <div class="h3 font-weight-bold text-gray-800">Rp
                                    {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-money-bill-wave fa-3x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik Kendaraan Masuk dan Keluar -->
        <div class="row">
            <div class="col-lg-12 col-12 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Statistik Kendaraan</h6>
                    </div>
                    <div class="card-body" style="padding: 0;">
                        <canvas id="chartKendaraan" style="width: 100%; height: 400px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Script untuk Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var ctx = document.getElementById('chartKendaraan').getContext('2d');
        var chartKendaraan = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Kendaraan Terparkir', 'Kendaraan Keluar'], // Label untuk grafik
                datasets: [{
                    label: 'Jumlah Kendaraan',
                    data: [{{ $totalTerparkir }},
                        {{ $totalKeluar }}
                    ], // Data yang diterima dari controller
                    backgroundColor: ['#4e73df', '#e74a3b'], // Warna latar belakang batang
                    borderColor: ['#4e73df', '#e74a3b'], // Warna border batang
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true, // Agar grafik responsif
                maintainAspectRatio: false, // Agar grafik menyesuaikan ukuran kontainer
                scales: {
                    y: {
                        beginAtZero: true, // Memulai sumbu Y dari angka 0
                        ticks: {
                            stepSize: 1, // Menetapkan langkah antar nilai pada sumbu Y
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top', // Menempatkan legend di bagian atas
                    }
                }
            }
        });
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Login Berhasil!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif

@endsection
