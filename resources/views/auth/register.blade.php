<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar - UMKM Kita</title>

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
        .login-form-area { padding: 40px; }

        .login-subtitle {
            color: var(--blue);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .5px;
            margin-bottom: 6px;
        }

        .login-title {
            font-weight: 800;
            margin-bottom: 22px;
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
                <h4>Bergabung Bersama<br>UMKM Kita</h4>
                <p class="mb-0">
                    Daftarkan diri Anda sebagai pelaku usaha dan perkenalkan produk lokal
                    Anda kepada masyarakat Kota Jember.
                </p>
            </div>

            {{-- Panel form --}}
            <div class="col-md-7 login-form-area">
                <p class="login-subtitle">BERGABUNG DENGAN UMKM KITA</p>
                <h2 class="login-title">Buat Akun Baru</h2>

                <form method="POST" action="{{ route('register.process') }}" novalidate>
                    @csrf

                    {{-- Nama --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fa-regular fa-user"></i></span>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="Masukkan nama lengkap" autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="nama@email.com">
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
                                   placeholder="Minimal 8 karakter">
                            <button type="button" class="btn btn-toggle" onclick="togglePassword('password', 'eyeIcon1')">
                                <i class="fa-regular fa-eye" id="eyeIcon1"></i>
                            </button>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Konfirmasi password --}}
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="form-control" placeholder="Ulangi password">
                            <button type="button" class="btn btn-toggle" onclick="togglePassword('password_confirmation', 'eyeIcon2')">
                                <i class="fa-regular fa-eye" id="eyeIcon2"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-masuk w-100">
                        <i class="fa-solid fa-user-plus me-1"></i> Daftar
                    </button>
                </form>

                <p class="text-center mt-3 mb-0" style="font-size:14px">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="back-link">Masuk</a>
                </p>

                <div class="text-center mt-3">
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
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        const show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        icon.className = show ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye';
    }
</script>
</body>
</html>