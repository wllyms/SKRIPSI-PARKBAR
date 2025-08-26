@extends('layout.main')

@section('pagename', 'SCAN MEMBER')
@section('title', 'ParkBar - Parkiran')
@section('content')

    <div class="page-inner pb-5">
        <div class="d-flex justify-content-center pt-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header text-center">
                            <h4 class="card-title">Scan Member</h4>
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

        // Fungsi onScanSuccess Anda yang sudah disempurnakan
        function onScanSuccess(decodedText, decodedResult) {
            if (isProcessing) {
                return;
            }
            isProcessing = true;

            html5QrCode.stop().then(ignore => console.log("Scanner stopped upon success."));

            Swal.fire({
                title: 'Memproses...',
                text: 'Harap tunggu...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });

            // INI ADALAH ROUTE UNTUK PARKIR PEGAWAI
            let targetRoute = '{{ route('process.scanpegawai') }}';

            fetch(targetRoute, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        kode_member: decodedText
                    }) // Kirim sebagai 'kode_member'
                })
                .then(response => response.json())
                .then(data => {
                    if (data && data.success) {
                        const title = `Berhasil ${data.data.aksi}!`;
                        const text = `Pegawai: ${data.data.nama}`;
                        Swal.fire({
                            icon: 'success',
                            title: title,
                            text: text
                        });
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
                    setTimeout(() => {
                        isProcessing = false;
                        const cameraSelect = document.getElementById('camera-select');
                        startScanner(cameraSelect.value); // Mulai ulang scanner
                    }, WAIT_TIME);
                });
        }

        function onScanFailure(error) {
            // Biarkan kosong
        }

        // --- LOGIKA UNTUK MENDETEKSI DAN MEMILIH KAMERA ---
        const html5QrCode = new Html5Qrcode("reader");

        const startScanner = (deviceId) => {
            const config = {
                fps: 10,
                qrbox: {
                    width: 250,
                    height: 250
                }
            };
            html5QrCode.start(deviceId, config, onScanSuccess, onScanFailure)
                .catch(err => {
                    console.error("Gagal memulai scanner:", err);
                    Swal.fire('Error Kamera', 'Gagal memulai kamera yang dipilih.', 'error');
                });
        };

        document.addEventListener('DOMContentLoaded', (event) => {
            const cameraSelect = document.getElementById('camera-select');

            Html5Qrcode.getCameras().then(devices => {
                if (devices && devices.length) {
                    devices.forEach(device => {
                        let option = document.createElement('option');
                        option.value = device.id;
                        option.innerHTML = device.label;
                        cameraSelect.appendChild(option);
                    });

                    startScanner(devices[0].id);

                    cameraSelect.addEventListener('change', () => {
                        html5QrCode.stop().then(() => {
                            startScanner(cameraSelect.value);
                        }).catch(err => {
                            console.error("Gagal stop scanner:", err);
                            startScanner(cameraSelect.value);
                        });
                    });
                }
            }).catch(err => {
                Swal.fire('Error!',
                    'Tidak bisa mendapatkan daftar kamera. Pastikan izin kamera sudah diberikan (HTTPS diperlukan).',
                    'error');
            });
        });
    </script>
@endsection
