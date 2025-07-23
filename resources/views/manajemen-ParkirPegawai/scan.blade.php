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
                            <h4 class="card-title">Scan Barcode</h4>
                        </div>
                        <div class="card-body text-center">
                            <!-- Elemen untuk pemindai QR -->
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
        const WAIT_TIME = 2000; // Waktu tunggu 
        let isProcessing = false; // Variabel kontrol untuk mencegah pemrosesan ganda

        function onScanSuccess(decodedText, decodedResult) {
            if (isProcessing) {
                // Jika alert belum terlihat, tampilkan alert peringatan
                if (!Swal.isVisible()) {
                    Swal.fire({
                        title: 'Harap Tunggu!',
                        text: 'Silakan tunggu sebelum memindai lagi.',
                        icon: 'warning',
                        timer: WAIT_TIME,
                        showConfirmButton: false
                    });
                }
                return;
            }

            isProcessing = true; // Kunci proses pemindaian
            console.log(`Kode ditemukan: ${decodedText}`, decodedResult);

            Swal.fire({
                title: 'Memproses...',
                text: 'Harap tunggu sementara proses sedang berjalan.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch('{{ route('process.scanpegawai') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        kode_member: decodedText
                    })
                })
                .then(response => response.json())
                .then(data => {
                    // Gunakan Swal.update() untuk transisi yang halus
                    if (data && data.success) {

                        // ===============================================
                        //           BUAT PESAN SINGKAT DI SINI
                        // ===============================================
                        const title = `Berhasil ${data.data.aksi}!`; // Contoh: "Berhasil MASUK!"
                        const text = `Pegawai: ${data.data.nama}`; // Contoh: "Pegawai: Smith Willyams"

                        Swal.update({
                            title: title,
                            text: text,
                            icon: 'success',
                            showConfirmButton: true,
                            timer: null,
                            allowOutsideClick: true
                        });

                    } else {
                        Swal.update({
                            title: 'Gagal!',
                            text: data?.message || 'Data tidak valid atau kosong.',
                            icon: 'error',
                            showConfirmButton: true,
                            allowOutsideClick: true
                        });
                    }
                })
        }

        function onScanFailure(error) {
            // Penanganan error scan jika diperlukan
        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", {
                fps: 10,
                qrbox: {
                    width: 400,
                    height: 400
                }
            },
            false
        );
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    </script>

@endsection
