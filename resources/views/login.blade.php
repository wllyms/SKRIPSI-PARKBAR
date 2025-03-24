<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Aplikasi Parkir</title>
    <link href="{{ asset('tempe1/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('tempe1/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0056b3, #6610f2);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
            background: #ffffff;
        }

        .login-form {
            padding: 40px;
        }

        .form-control {
            border-radius: 8px;
            padding-left: 40px;
        }

        .input-group-text {
            border-radius: 8px 0 0 8px;
        }

        .btn-primary {
            border-radius: 8px;
            transition: 0.3s;
            font-weight: bold;
            padding: 10px;
        }

        .btn-primary:hover {
            background: #004494;
        }

        .input-group-append .btn {
            border-radius: 0 8px 8px 0;
            border-left: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card p-4">
                    <div class="text-center mb-3">
                        <h2 class="text-dark font-weight-bold">PARKBARA</h2>
                        <p class="text-muted">Selamat Datang di Aplikasi Parkir</p>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary text-white"><i
                                            class="fas fa-user"></i></span>
                                </div>
                                <input type="text" class="form-control" name="username"
                                    placeholder="Masukkan Username" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary text-white"><i
                                            class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" class="form-control" name="password" id="password"
                                    placeholder="Masukkan Password" required>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary btn-block">Masuk</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('tempe1/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('tempe1/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        document.getElementById("togglePassword").addEventListener("click", function() {
            let passwordInput = document.getElementById("password");
            let icon = this.querySelector("i");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        });
    </script>
</body>

</html>
