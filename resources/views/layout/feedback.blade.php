<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penilaian Layanan - ParkBar</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <style>
        body {
            background-color: #f8f9fa;
            /* Warna latar belakang abu-abu muda */
        }

        .card {
            border: none;
            border-radius: 0.75rem;
        }

        .card-header {
            border-top-left-radius: 0.75rem;
            border-top-right-radius: 0.75rem;
        }

        /* Style untuk Rating Bintang Interaktif */
        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
            font-size: 2.5rem;
            color: #d3d3d3;
            cursor: pointer;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            transition: color 0.2s;
        }

        .star-rating label:hover,
        .star-rating label:hover~label {
            color: #ffdd00;
        }

        .star-rating input:checked~label {
            color: #ffc107;
        }
    </style>
</head>

<body>
    {{-- 'main' sebagai pembungkus utama konten --}}
    <main class="py-4">
        {{-- Di sinilah konten dari 'dynamic_form.blade.php' akan ditampilkan --}}
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
