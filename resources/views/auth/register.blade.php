<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Perpustakaan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --bg-1: #071a2d;
            --bg-2: #10314d;
            --panel: rgba(12, 29, 43, 0.78);
            --card: rgba(255, 255, 255, 0.06);
            --line: rgba(148, 175, 195, 0.2);
            --text: #edf6ff;
            --muted: #aac0d5;
            --primary: #7ad7c3;
            --primary-strong: #4ebc9a;
            --gold: #f7d889;
            --danger: #ff8a88;
            --shadow: 0 24px 80px rgba(2, 10, 21, 0.55);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            font-family: 'Inter', sans-serif;
            background:
                radial-gradient(circle at top left, rgba(122, 215, 195, 0.18), transparent 28%),
                radial-gradient(circle at bottom right, rgba(247, 216, 137, 0.12), transparent 24%),
                linear-gradient(135deg, var(--bg-1) 0%, var(--bg-2) 100%);
            color: var(--text);
        }

        .register-shell {
            width: min(1120px, 100%);
            min-height: 680px;
            display: grid;
            grid-template-columns: 0.95fr 1.05fr;
            border-radius: 30px;
            overflow: hidden;
            border: 1px solid var(--line);
            background: rgba(8, 22, 34, 0.72);
            box-shadow: var(--shadow);
            backdrop-filter: blur(14px);
        }

        .panel-left {
            position: relative;
            padding: 48px 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(145deg, rgba(122, 215, 195, 0.14), rgba(247, 216, 137, 0.08));
            overflow: hidden;
        }

        .panel-left::before,
        .panel-left::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.08);
        }

        .panel-left::before {
            width: 450px; height: 450px;
            top: -160px; right: -130px;
        }

        .panel-left::after {
            width: 340px; height: 340px;
            bottom: -110px; left: -80px;
        }

        .brand-box {
            position: relative;
            z-index: 1;
            width: min(100%, 360px);
        }

        .mini-label {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(122, 215, 195, 0.1);
            border: 1px solid rgba(122, 215, 195, 0.18);
            color: var(--primary);
            letter-spacing: 0.12em;
            text-transform: uppercase;
            font-size: 0.7rem;
            font-weight: 700;
        }

        .brand-box h1 {
            margin: 18px 0 12px;
            font-size: clamp(2.2rem, 4vw, 4rem);
            line-height: 1.05;
            letter-spacing: -0.06em;
            font-family: 'Playfair Display', serif;
            color: var(--text);
        }

        .brand-box p {
            margin: 0;
            color: var(--muted);
            font-size: 1rem;
            line-height: 1.8;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(80px, 1fr));
            gap: 12px;
            margin-top: 28px;
        }

        .stat-box {
            padding: 16px 12px;
            border-radius: 18px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.08);
            box-shadow: 0 10px 30px rgba(0,0,0,0.12);
        }

        .stat-box strong {
            display: block;
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text);
        }

        .stat-box span {
            font-size: 0.68rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--muted);
        }

        .panel-right {
            padding: 42px 42px 30px;
            background: rgba(255,255,255,0.02);
        }

        .form-wrap {
            max-width: 480px;
            margin: 0 auto;
        }

        .heading {
            margin-bottom: 26px;
        }

        .heading h2 {
            margin: 0 0 6px;
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.04em;
            color: var(--text);
        }

        .heading p {
            margin: 0;
            color: var(--muted);
            font-size: 0.95rem;
        }

        .alert {
            border-radius: 14px;
            border: 1px solid rgba(255, 138, 136, 0.35);
            background: rgba(255, 138, 136, 0.12);
            color: #ffd4d2;
            padding: 12px 14px;
            font-size: 0.92rem;
            font-weight: 600;
        }

        .alert ul {
            margin: 0;
            padding-left: 18px;
        }

        form {
            display: grid;
            gap: 16px;
        }

        .field {
            display: grid;
            gap: 8px;
        }

        .field label {
            font-size: 0.72rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #dfeaf5;
            font-weight: 700;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap input {
            width: 100%;
            height: 52px;
            padding: 0 46px 0 16px;
            border-radius: 14px;
            border: 1px solid rgba(148, 175, 195, 0.2);
            background: rgba(255,255,255,0.04);
            color: var(--text);
            font-size: 0.96rem;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .input-wrap input::placeholder {
            color: rgba(170, 192, 213, 0.7);
        }

        .input-wrap input:focus {
            border-color: rgba(122, 215, 195, 0.7);
            box-shadow: 0 0 0 4px rgba(122, 215, 195, 0.12);
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            width: 32px;
            height: 32px;
            border: 0;
            border-radius: 10px;
            background: transparent;
            color: var(--muted);
            cursor: pointer;
            font-size: 1rem;
        }

        .toggle-password:hover {
            background: rgba(255,255,255,0.04);
            color: var(--text);
        }

        .helper {
            font-size: 0.76rem;
            color: var(--muted);
            margin-top: -4px;
        }

        .submit-btn {
            margin-top: 6px;
            height: 54px;
            border: 0;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-strong) 100%);
            color: #071a2d;
            font-weight: 800;
            letter-spacing: 0.04em;
            box-shadow: 0 18px 30px rgba(78, 188, 154, 0.34);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .submit-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 24px 34px rgba(78, 188, 154, 0.42);
        }

        .login-link {
            margin-top: 20px;
            text-align: center;
            color: var(--muted);
            font-size: 0.9rem;
        }

        .login-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
        }

        @media (max-width: 900px) {
            .register-shell {
                grid-template-columns: 1fr;
            }

            .panel-left {
                min-height: 260px;
            }
        }

        @media (max-width: 560px) {
            .panel-left, .panel-right {
                padding: 28px 20px;
            }

            .stats {
                grid-template-columns: repeat(3, minmax(70px, 1fr));
            }
        }
    </style>
</head>
<body>
<div class="register-shell">
    <div class="panel-left">
        <div class="brand-box">
            <span class="mini-label">Library system</span>
            <h1>Mulai pengalaman baca Anda.</h1>
            <p>Bergabunglah sebagai anggota perpustakaan dan nikmati akses cepat ke katalog buku serta riwayat peminjaman.</p>

            <div class="stats">
                <div class="stat-box">
                    <strong>{{ number_format($totalBuku) }}</strong>
                    <span>Buku</span>
                </div>
                <div class="stat-box">
                    <strong>{{ number_format($totalAnggota) }}</strong>
                    <span>Anggota</span>
                </div>
                <div class="stat-box">
                    <strong>{{ $activePercentage }}%</strong>
                    <span>Aktif</span>
                </div>
            </div>
        </div>
    </div>

    <div class="panel-right">
        <div class="form-wrap">
            <div class="heading">
                <h2>Buat akun</h2>
                <p>Daftar sebagai user perpustakaan</p>
            </div>

            @if($errors->any())
                <div class="alert">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.store') }}" method="POST">
                @csrf

                <div class="field">
                    <label for="name">Nama</label>
                    <div class="input-wrap">
                        <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required autofocus>
                    </div>
                </div>

                <div class="field">
                    <label for="email">Email</label>
                    <div class="input-wrap">
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@gmail.com" required>
                    </div>
                </div>

                <div class="field">
                    <label for="nis">NIS</label>
                    <div class="input-wrap">
                        <input type="text" id="nis" name="nis" value="{{ old('nis') }}" placeholder="Masukkan NIS" required>
                    </div>
                </div>

                <div class="field">
                    <label for="kelas">Kelas</label>
                    <div class="input-wrap">
                        <input type="text" id="kelas" name="kelas" value="{{ old('kelas') }}" placeholder="Contoh: XII IPA 1" required>
                    </div>
                </div>

                <div class="field">
                    <label for="alamat">Alamat</label>
                    <div class="input-wrap">
                        <input type="text" id="alamat" name="alamat" value="{{ old('alamat') }}" placeholder="Masukkan alamat" required>
                    </div>
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <input type="password" id="password" name="password" placeholder="Minimal 8 karakter" required>
                        <button type="button" class="toggle-password" data-target="password" aria-label="Tampilkan password">👁</button>
                    </div>
                    <small class="helper">Gunakan kombinasi huruf dan angka agar lebih aman.</small>
                </div>

                <div class="field">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <div class="input-wrap">
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password Anda" required>
                        <button type="button" class="toggle-password" data-target="password_confirmation" aria-label="Tampilkan konfirmasi password">👁</button>
                    </div>
                </div>

                <button type="submit" class="btn btn-success w-100 submit-btn">Daftar sekarang</button>
            </form>

            <p class="login-link">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.toggle-password').forEach(function(button) {
        button.addEventListener('click', function() {
            const targetId = this.dataset.target;
            const input = document.getElementById(targetId);
            if (!input) return;

            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            this.textContent = isHidden ? '🙈' : '👁';
            this.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
        });
    });
</script>
</body>
</html>