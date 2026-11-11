<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - UMKM Kita</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --blue: #0b57c4;
            --blue-dark: #084099;
            --orange: #f5a623;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
            background: #f4f6f9;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 12px;
        }

        .login-box {
            width: 100%;
            max-width: 900px;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 35px rgba(11, 87, 196, .15);
        }

        /* Panel kiri (branding) */
        .login-side {
            background: linear-gradient(160deg, var(--blue) 0%, var(--blue-dark) 100%);
            color: #fff;
            padding: 48px 36px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .login-side::after {
            content: "";
            position: absolute;
            right: -40px;
            bottom: -40px;
            width: 160px;
            height: 160px;
            background: var(--orange);
            opacity: .9;
            transform: rotate(45deg);
        }

        .brand {
            line-height: 1;
            font-weight: 800;
            font-size: 34px;
            margin-bottom: 24px;
        }

        .brand span { display: block; }
        .brand .top { color: #fff; }
        .brand .bottom { color: var(--orange); }

        .login-side h4 { font-weight: 700; }
        .login-side p { font-size: 14px; opacity: .9; }

        /* Panel kanan (form) */
        .login-form-area { padding: 48px 40px; }

        .login-subtitle {
            color: var(--blue);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .5px;
            margin-bottom: 6px;
        }

        .login-title {
            font-weight: 800;
            margin-bottom: 26px;
        }

        .form-label { font-weight: 600; font-size: 14px; }

        .form-control, .input-group-text {
            padding: 10px 14px;
            border-color: #d5dae1;
        }

        .form-control:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 .2rem rgba(11, 87, 196, .15);
        }

        .input-group-text { background: #f4f6f9; color: #6c757d; }

        .btn-toggle {
            border: 1px solid #d5dae1;
            background: #fff;
            color: #6c757d;
        }

        .btn-masuk {
            background: var(--blue);
            color: #fff;
            font-weight: 700;
            padding: 11px;
            border-radius: 8px;
            border: 0;
        }

        .btn-masuk:hover { background: var(--blue-dark); color: #fff; }

        .back-link {
            color: var(--blue);
            font-weight: 600;
            text-decoration: none;
            font-size: 14px;
        }

        .back-link:hover { text-decoration: underline; }

        @media (max-width: 767.98px) {
            .login-side { padding: 28px 24px; text-align: center; }
            .login-side::after { display: none; }
            .login-form-area { padding: 32px 24px; }
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="login-box">
        <div class="row g-0">

            {{-- Panel kiri --}}
            <div class="col-md-5 login-side">
                <div class="brand">
                    <span class="top">UMKM</span>
                    <span class="bottom">KITA</span>
                </div>
                <h4>Dukung UMKM Lokal,<br>Bangun Bersama</h4>
                <p class="mb-0">
                    Platform digital yang menghubungkan pelaku usaha mikro, kecil, dan menengah
                    dengan masyarakat Kota Jember.
                </p>
            </div>

            {{-- Panel form --}}
            <div class="col-md-7 login-form-area">
                <p class="login-subtitle">SELAMAT DATANG DI UMKM KITA</p>
                <h2 class="login-title">Masuk ke Akun Anda</h2>

                @if (session('success'))
                    <div class="alert alert-success py-2">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('login.process') }}" novalidate>
                    @csrf

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="nama@email.com" autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" name="password" id="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Masukkan password">
                            <button type="button" class="btn btn-toggle" onclick="togglePassword()">
                                <i class="fa-regular fa-eye" id="eyeIcon"></i>
                            </button>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Ingat saya --}}
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Ingat saya</label>
                    </div>

                    <button type="submit" class="btn btn-masuk w-100">
                        <i class="fa-solid fa-right-to-bracket me-1"></i> Masuk
                    </button>
                </form>

                <div class="text-center mt-4">
                    <a href="{{ route('home') }}" class="back-link">
                        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');
        const show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        icon.className = show ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye';
    }
</script>
</body>
</html>