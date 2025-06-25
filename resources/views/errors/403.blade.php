{{-- resources/views/errors/403.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>403 - Akses Ditolak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #8e2de2, #4a00e0);
            color: white;
            height: 100vh;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .error-container {
            background: rgba(255, 255, 255, 0.15);
            padding: 50px 40px;
            border-radius: 16px;
            text-align: center;
            max-width: 500px;
            backdrop-filter: blur(10px);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        .error-code {
            font-size: 64px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .error-message {
            font-size: 20px;
            font-weight: 500;
        }

        .suggestion {
            font-size: 14px;
            margin-top: 10px;
            color: #e0d7ff;
        }

        .btn-custom {
            margin-top: 25px;
            background-color: white;
            color: #4a00e0;
            border: none;
            padding: 10px 24px;
            font-weight: 600;
            border-radius: 8px;
            transition: 0.3s;
        }

        .btn-custom:hover {
            background-color: #eee;
        }
    </style>
</head>

<body>
    <div class="error-container">
        <div class="error-code">403</div>
        <div class="error-message">Akses Ditolak</div>
        <p class="suggestion">
            Maaf, Anda tidak memiliki hak akses untuk membuka halaman ini.<br>
            Jika menurut Anda ini kesalahan, silakan hubungi petugas IT atau administrator.
        </p>
        <a href="{{ route('login') }}" class="btn btn-custom">Kembali ke Login</a>
    </div>
</body>

</html>
