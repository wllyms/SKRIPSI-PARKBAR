@extends('layout.main')

@section('pagename', 'SCAN PARKIR KELUAR')
@section('title', 'ParkBar - Parkiran')
@section('content')

    <div class="page-inner pb-5">
        <div class="d-flex justify-content-center pt-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header text-center">
                            <h4 class="card-title">Scan Barcode</h4>
                        </div>
                        <div class="card-body text-center">
                            <!-- Gunakan div untuk elemen pemindai QR -->
                            <div class="card-body text-center">
                                {{-- TAMBAHAN: Dropdown untuk memilih kamera --}}
                                <div class="mb-3">
                                    <label for="camera-select" class="form-label small">Pilih Kamera:</label>
                                    <select id="camera-select" class="form-control form-control-sm"
                                        style="max-width: 300px; margin: auto;"></select>
                                </div>

                                <div id="reader" style="width: 100%; max-width: 400px; height: auto; margin: auto;">
                                </div>
                            </div>
                            <div id="reader" style="width: 400px; height: 400px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const WAIT_TIME = 2000;
        let isProcessing = false;

        // Fungsi onScanSuccess tidak perlu diubah, sudah benar.
        function onScanSuccess(decodedText, decodedResult) {
            if (isProcessing) {
                return;
            }
            isProcessing = true;

            // Hentikan kamera setelah scan berhasil untuk mengurangi beban
            html5QrCode.stop().then(ignore => console.log("Scanner stopped upon success."));

            Swal.fire({
                title: 'Memproses...',
                text: 'Harap tunggu...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });

            let targetRoute = '{{ route('proses.scan.keluar') }}'; // Sesuaikan jika ini halaman scan pegawai

            fetch(targetRoute, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        decodedText: decodedText
                    }) // Sesuaikan key jika perlu
                })
                .then(response => response.json()) 
                .then(data => {
                    if (data && data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message
                        });
                        if (data.data && data.data.cetak_url) {
                            window.open(data.data.cetak_url, '_blank');
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: data?.message || 'Data tidak valid.'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire('Error!', 'Terjadi kesalahan koneksi.', 'error');
                    console.error('Error:', error);
                })
                .finally(() => {
                    // Setelah semua selesai, izinkan scan lagi dan mulai ulang kamera
                    setTimeout(() => {
                        isProcessing = false;
                        const cameraSelect = document.getElementById('camera-select');
                        startScanner(cameraSelect.value); // Mulai ulang scanner dengan kamera yg terpilih
                    }, WAIT_TIME);
                });
        }

        function onScanFailure(error) {
            // Biarkan kosong
        }

        // --- LOGIKA BARU YANG LEBIH SEDERHANA ---
        const html5QrCode = new Html5Qrcode("reader"); // Inisialisasi object sekali saja

        // Fungsi untuk memulai scanner
        const startScanner = (deviceId) => {
            // Konfigurasi scanner
            const config = {
                fps: 10,
                qrbox: {
                    width: 250,
                    height: 250
                }
            };

            // Mulai scanner
            html5QrCode.start(deviceId, config, onScanSuccess, onScanFailure)
                .catch(err => {
                    console.error("Gagal memulai scanner:", err);
                    Swal.fire('Error Kamera',
                        'Gagal memulai kamera yang dipilih. Pastikan tidak digunakan aplikasi lain.', 'error');
                });
        };

        // Saat halaman dimuat
        document.addEventListener('DOMContentLoaded', (event) => {
            const cameraSelect = document.getElementById('camera-select');

            // Dapatkan daftar kamera
            Html5Qrcode.getCameras().then(devices => {
                if (devices && devices.length) {
                    // Isi dropdown
                    devices.forEach(device => {
                        let option = document.createElement('option');
                        option.value = device.id;
                        option.innerHTML = device.label;
                        cameraSelect.appendChild(option);
                    });

                    // Mulai scanner dengan kamera pertama
                    startScanner(devices[0].id);

                    // Ganti kamera jika pilihan di dropdown berubah
                    cameraSelect.addEventListener('change', () => {
                        // Hentikan dulu scanner lama sebelum memulai yang baru
                        html5QrCode.stop().then(() => {
                            startScanner(cameraSelect.value);
                        }).catch(err => {
                            console.error("Gagal stop scanner:", err);
                            startScanner(cameraSelect
                                .value); // Coba start langsung jika stop gagal
                        });
                    });
                }
            }).catch(err => {
                Swal.fire('Error!',
                    'Tidak bisa mendapatkan daftar kamera. Izin mungkin diblokir atau tidak ada kamera.',
                    'error');
            });
        });
    </script>


@endsection
