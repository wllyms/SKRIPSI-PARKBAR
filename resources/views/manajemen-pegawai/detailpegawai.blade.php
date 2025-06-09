@extends('layout.main')

@section('pagename', 'ID Card Pegawai')
@section('title', 'ParkBar - Pegawai')
@section('content')
    <style>
        .id-card {
            width: 300px;
            /* Lebar lebih proporsional */
            height: 450px;
            /* Tinggi lebih pendek sesuai ukuran kartu ID */
            border: 1px solid #ccc;
            /* Tetap gunakan border */
            border-radius: 8px;
            /* Sedikit lebih kecil untuk estetika */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            /* Bayangan lebih halus */
            background-color: #fff;
            /* Latar belakang putih */
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            /* Atur elemen ke atas */
            box-sizing: border-box;
            position: relative;
        }

        .header {
            background-color: #7c23af;
            color: #fff;
            text-align: center;
            margin-bottom: 20px;
            /* Hapus padding, gunakan margin bawah */
            padding: 0;
            /* Hilangkan padding */
            box-sizing: border-box;
            /* Pastikan ukuran termasuk border */
        }

        .header h2 {
            margin: 10px 0 5px;
            /* Atur jarak di dalam elemen header */
            font-size: 18px;
        }

        .header p {
            margin: 0 0 10px;
            /* Atur jarak bawah untuk elemen p */
            font-size: 12px;
        }

        .photo {
            width: 150px;
            /* Lebar kotak foto */
            height: 180px;
            /* Tinggi kotak foto */
            background-color: #e0e0e0;
            /* Warna latar jika gambar tidak ada */
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            /* Menghindari gambar melampaui area */
            margin: 0 auto 20px;
            /* Tengahkan foto */
        }

        .photo img {
            width: 100%;
            /* Gambar mengikuti lebar kotak */
            height: 100%;
            /* Gambar mengikuti tinggi kotak */
            object-fit: cover;
            /* Mengisi kotak tanpa mengubah proporsi */
        }

        .details .detail-item {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .details p {
            margin: 0;
            font-size: 15px;
            color: #555;
        }

        .details strong {
            font-size: 17px;
            color: #333;
            margin-top: 30px;
        }

        .barcode {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }

        .barcode img {
            max-width: 80%;
            display: block;
            margin: 0 auto;
        }

        .btn-download {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .btn-download button {
            padding: 10px 20px;
            font-size: 14px;
            background-color: #4e1bda;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .btn-download button:hover {
            background-color: #5d24b9;
        }

        .btn-download .bx {
            margin-right: 10px;
        }
    </style>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4 mb-3 d-flex justify-content-center">
                    <div>
                        <!-- Card to Render -->
                        <div class="id-card" id="idCardExport" data-nama="{{ $pegawai->nama }}">
                            <!-- Header -->
                            <div class="header">
                                <h2>RS Bhayangkara Banjarmasin</h2>
                                <p>Kartu Identitas Pegawai</p>
                            </div>

                            <!-- Photo -->
                            <div class="photo">
                                @if (!empty($pegawai->image))
                                    <img src="{{ asset('storage/' . $pegawai->image) }}" alt="Foto Pegawai">
                                @else
                                    <p>Foto tidak tersedia</p>
                                @endif
                            </div>

                            <!-- Details -->
                            <div class="details">
                                <div class="detail-item">
                                    <strong>{{ $pegawai->nama ?? '-' }}</strong>
                                </div>
                                <div class="detail-item">
                                    <p>{{ $pegawai->jenisPegawai->jenis_pegawai ?? '-' }}</p>
                                </div>
                            </div>
                            <br>
                            <!-- Barcode -->
                            <div class="barcode">
                                @if (!empty($pegawai->kode_member))
                                    @php
                                        $generator = new \Picqer\Barcode\BarcodeGeneratorHTML();
                                        $barcode = $generator->getBarcode(
                                            $pegawai->kode_member,
                                            $generator::TYPE_CODE_128,
                                        );
                                    @endphp
                                    {!! $barcode !!}
                                @else
                                    <p>Barcode tidak tersedia</p>
                                @endif
                            </div>
                        </div>

                        <!-- Button to Download PNG -->
                        <div class="btn-download">
                            <button class="btn btn-primary" id="btnExportPNG">
                                <span class="tf-icons bx bx-download"></span>Download&nbsp;
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include html2canvas script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        document.getElementById("btnExportPNG").addEventListener("click", function() {
            const idCard = document.getElementById("idCardExport"); // Pilih hanya ID Card
            const namaPeserta = idCard.getAttribute("data-nama") || "idcard";

            html2canvas(idCard, {
                scale: 3, // Meningkatkan resolusi output
                useCORS: true, // Mendukung gambar lintas domain
                logging: false
            }).then((canvas) => {
                const link = document.createElement("a");
                link.href = canvas.toDataURL("image/png");
                link.download = `${namaPeserta}.png`;
                link.click();
            }).catch((error) => {
                console.error("Error generating PNG:", error);
                alert("Terjadi kesalahan saat mengunduh PNG.");
            });
        });
    </script>
@endsection
