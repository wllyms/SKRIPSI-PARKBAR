@extends('layout.main')

@section('pagename', 'Dashboard')
@section('title', 'ParkBar - Dashboard')
@section('content')

    <div class="container-fluid">

        <!-- Bungkus semua isi dashboard ke card putih -->
        <div class="card p-3 shadow-sm bg-white rounded">

            <!-- Informasi Ringkas -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <div>
                    <h5 class="text-gray-800 mb-1">
                        <i class="fas fa-tachometer-alt text-primary mr-2"></i> Selamat datang kembali,
                        {{ Auth::user()->username ?? 'Admin' }}!
                    </h5>
                    <small class="text-muted">Pantau aktivitas parkir harian, denda, dan grafik statistik di sini.</small>
                </div>
            </div>

            <!-- Kartu Informasi Utama -->
            <div class="row">

                @php
                    $cards = [
                        [
                            'title' => 'Kendaraan Terparkir Hari Ini',
                            'value' => $totalTerparkir,
                            'icon' => 'fas fa-car-side',
                            'color' => 'primary',
                            'gradient' => 'linear-gradient(135deg, #4e73df, #375aee)', // medium blue
                        ],
                        [
                            'title' => 'Kendaraan Keluar Hari Ini',
                            'value' => $totalKeluar,
                            'icon' => 'fas fa-sign-out-alt',
                            'color' => 'danger',
                            'gradient' => 'linear-gradient(135deg, #e74a3b, #c0392b)', // medium red
                        ],
                        [
                            'title' => 'Pendapatan Hari Ini',
                            'value' => 'Rp ' . number_format($totalPendapatan, 0, ',', '.'),
                            'icon' => 'fas fa-money-bill-wave',
                            'color' => 'success',
                            'gradient' => 'linear-gradient(135deg, #28a745, #218838)', // medium green
                        ],
                        [
                            'title' => 'Total Denda Hari Ini',
                            'value' => 'Rp ' . number_format($totalDenda, 0, ',', '.'),
                            'icon' => 'fas fa-coins',
                            'color' => 'warning',
                            'gradient' => 'linear-gradient(135deg, #f39c12, #d68910)', // medium orange
                        ],
                        [
                            'title' => 'Pegawai Terparkir Hari Ini',
                            'value' => $kendaraanPegawaiTerparkir,
                            'icon' => 'fas fa-user-tie',
                            'color' => 'info',
                            'gradient' => 'linear-gradient(135deg, #17a2b8, #138496)', // medium teal
                        ],
                    ];
                @endphp

                @foreach ($cards as $card)
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card shadow h-100" style="background: {{ $card['gradient'] }}; color: white;">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">{{ $card['title'] }}</div>
                                    <div class="h3 font-weight-bold">{{ $card['value'] }}</div>
                                </div>
                                <div>
                                    <i class="{{ $card['icon'] }} fa-3x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Statistik Kendaraan Masuk & Keluar Hari Ini -->
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Perbandingan Kendaraan Hari Ini</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="chartKendaraan" height="100"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Grafik Tren Mingguan -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Tren Masuk & Keluar - Minggu Ini</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="chartTrenMinggu" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- End card putih -->

    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Chart Kendaraan Hari Ini
        new Chart(document.getElementById('chartKendaraan'), {
            type: 'bar',
            data: {
                labels: ['Terparkir', 'Keluar'],
                datasets: [{
                    label: 'Jumlah Kendaraan',
                    data: [{{ $totalTerparkir }}, {{ $totalKeluar }}],
                    backgroundColor: ['#4e73df', '#e74a3b'],
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Grafik Tren Mingguan
        new Chart(document.getElementById('chartTrenMinggu'), {
            type: 'line',
            data: {
                labels: @json($labelsHariMingguIni),
                datasets: [{
                        label: 'Masuk',
                        data: @json($dataMasukMingguIni),
                        borderColor: '#4e73df',
                        tension: 0.4,
                        fill: false
                    },
                    {
                        label: 'Keluar',
                        data: @json($dataKeluarMingguIni),
                        borderColor: '#e74a3b',
                        tension: 0.4,
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <!-- SweetAlert Success -->
    @if (session('success'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
