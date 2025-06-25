<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Aplikasi Parkir</title>
    <link href="{{ asset('tempe1/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('tempe1/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            height: 100vh;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            border-radius: 15px;
            padding: 40px;
            background: #fff;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 420px;
        }

        .card h2 {
            font-weight: bold;
            color: #333;
        }

        .card p {
            font-size: 14px;
            color: #666;
        }

        .form-control {
            height: 45px;
            border-radius: 10px;
            padding-left: 45px;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .btn-primary {
            border-radius: 10px;
            font-weight: 600;
            height: 45px;
            background: #0061ff;
            transition: background 0.3s;
        }

        .btn-primary:hover {
            background: #004cc3;
        }

        .toggle-btn {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: #6c757d;
        }

        .alert {
            font-size: 14px;
        }
    </style>
</head>

<body>

    <div class="card">
        <div class="text-center mb-4">
            <img src="{{ asset('tempe1/img/logo/baru.png') }}" alt="Logo Parkir"
                style="width: 60px; margin-bottom: 10px;">
            <h2
                style="font-weight: 700; font-size: 28px; background: linear-gradient(to right, #8e2de2, #4a00e0); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                PARKBARA
            </h2>
            <p style="font-size: 14px; color: #6c757d;">
                Selamat datang di <strong>Aplikasi Parkir RS Bhayangkara</strong><br>
                Silakan login untuk mengelola sistem parkir
            </p>
        </div>


        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Username -->
            <div class="form-group mb-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white text-muted">
                            <i class="fas fa-user"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control" name="username" placeholder="Username" required>
                </div>
            </div>

            <!-- Password -->
            <div class="form-group mb-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white text-muted">
                            <i class="fas fa-lock"></i>
                        </span>
                    </div>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password"
                        required>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tombol Masuk -->
            <button type="submit" class="btn btn-primary w-100">Masuk</button>
        </form>

    </div>

    <script src="{{ asset('tempe1/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('tempe1/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        document.getElementById("togglePassword").addEventListener("click", function() {
            const input = document.getElementById("password");
            const icon = this.querySelector("i");
            const type = input.getAttribute("type") === "password" ? "text" : "password";
            input.setAttribute("type", type);
            icon.classList.toggle("fa-eye");
            icon.classList.toggle("fa-eye-slash");
        });
    </script>
</body>

</html>
