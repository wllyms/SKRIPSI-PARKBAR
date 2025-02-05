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
        const WAIT_TIME = 4000; // Waktu tunggu dalam milidetik (4 detik)
        let isProcessing = false; // Variabel kontrol untuk mencegah pemrosesan ganda

        function onScanSuccess(decodedText, decodedResult) {
            if (isProcessing) {
                Swal.fire({
                    title: 'Harap Tunggu!',
                    text: 'Silakan tunggu sebelum memindai lagi.',
                    icon: 'warning',
                    timer: WAIT_TIME,
                    showConfirmButton: false
                });
                return;
            }

            isProcessing = true; // Set variabel kontrol menjadi true
            console.log(`Code matched = ${decodedText}`, decodedResult);

            Swal.fire({
                title: 'Memproses...',
                text: 'Harap tunggu sementara proses sedang berjalan.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch('/process-scan-keluar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        decodedText: decodedText
                    })
                })
                .then(response => response.json())
                .then(data => {
                    Swal.close();
                    if (data && data.success) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: `Kendaraan dengan plat ${data.data.plat_kendaraan} telah keluar pada ${data.data.jam_keluar}.`,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = '{{ route('manajemen-parkir.tampil') }}';
                        });
                    } else {
                        Swal.fire({
                            title: 'Gagal!',
                            text: data?.message || 'Data tidak valid atau kosong.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.close();
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat memproses scan. Silakan coba lagi.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                })
                .finally(() => {
                    setTimeout(() => {
                        isProcessing = false;
                    }, WAIT_TIME);
                });
        }

        function onScanFailure(error) {
            // console.warn(`Code scan error = ${error}`);
        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", {
                fps: 60,
                qrbox: {
                    width: 450,
                    height: 450
                }
            },
            false
        );
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    </script>

@endsection
