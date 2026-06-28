<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi | Suzuki Integrated Sales System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* CSS Sama persis dengan login.blade.php */
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f9;
        }

        .auth-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .auth-left {
            flex: 1;
            background: linear-gradient(rgba(0, 20, 55, 0.7), rgba(0, 20, 55, 0.9)), url("{{ asset('img/suzuki-walpaper-login.jpg') }}") center/cover no-repeat;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px;
        }

        .auth-left-content {
            max-width: 500px;
        }

        .auth-left h1 {
            font-weight: 800;
            font-size: 2.5rem;
        }

        .auth-left p {
            opacity: 0.9;
        }

        .auth-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
        }

        .auth-card {
            width: 100%;
            max-width: 420px;
            padding: 40px;
        }

        .form-control {
            padding: 12px;
            border-radius: 10px;
            background: #f8f9fa;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #001437;
        }

        .btn-login {
            background: #EA5555;
            border: none;
            padding: 14px;
            border-radius: 10px;
            font-weight: bold;
            transition: 0.3s;
            color: white;
        }

        .btn-login:hover {
            background: #d14040;
            transform: translateY(-2px);
            color: white;
        }

        @media(max-width: 768px) {
            .auth-left {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="auth-wrapper">
        <div class="auth-left">
            <div class="auth-left-content">
                <h1>Pemulihan Akun</h1>
                <p>Jangan khawatir, kami akan membantu memulihkan akses ke akun Anda. Sistem keamanan kami memastikan
                    data Anda tetap aman.</p>
            </div>
        </div>

        <div class="auth-right">
            <div class="auth-card">
                <div class="mb-3">
                    <a href="{{ route('login') }}" class="text-muted small text-decoration-none">
                        <i class="bi bi-arrow-left"></i> Kembali ke Login
                    </a>
                </div>

                <div class="text-center mb-4">
                    <img src="{{ asset('img/suzis.png') }}" alt="Sigma Automobil" height="45" class="mb-3">
                    <h5 class="fw-bold text-dark mb-1">Lupa Kata Sandi?</h5>
                    <small class="text-muted">Masukkan email terdaftar, kami akan kirim link reset.</small>
                </div>

                @if (session('status'))
                    <div class="alert alert-success small">{{ session('status') }}</div>
                @endif

                @error('email')
                    <div class="alert alert-danger small">{{ $message }}</div>
                @enderror

                <form action="{{ route('password.email') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="small fw-bold">Alamat Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                            placeholder="contoh@gmail.com" required autofocus>
                    </div>

                    <button type="submit" class="btn btn-login w-100 shadow-sm">
                        Kirim Link Reset
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
