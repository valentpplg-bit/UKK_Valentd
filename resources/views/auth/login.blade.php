<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Perpustakaan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #071a2d;
            --bg-soft: #10263e;
            --panel: rgba(13, 31, 48, 0.74);
            --panel-strong: #f5efe5;
            --card: rgba(255, 255, 255, 0.06);
            --line: rgba(148, 175, 195, 0.25);
            --text: #ebf3ff;
            --muted: #a8bacd;
            --primary: #7ad7c3;
            --primary-strong: #4ebc9a;
            --gold: #f7d889;
            --danger: #ff8c89;
            --shadow: 0 24px 70px rgba(2, 10, 21, 0.55);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            background:
                radial-gradient(circle at top left, rgba(122, 215, 195, 0.14), transparent 28%),
                radial-gradient(circle at top right, rgba(247, 216, 137, 0.12), transparent 24%),
                linear-gradient(135deg, var(--bg) 0%, #0a2338 35%, #0e1d2d 100%);
            color: var(--text);
            font-family: 'Inter', sans-serif;
        }

        .login-shell {
            width: min(1100px, 92vw);
            min-height: 650px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 28px;
        }

        .login-card {
            width: 100%;
            min-height: 620px;
            display: grid;
            grid-template-columns: 1.08fr 0.92fr;
            border: 1px solid var(--line);
            border-radius: 28px;
            background: rgba(11, 22, 33, 0.72);
            backdrop-filter: blur(14px);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .login-panel {
            padding: 42px 48px 38px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: rgba(10, 25, 38, 0.62);
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 30px;
            font-size: 13px;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--muted);
            font-weight: 700;
        }

        .brand-mark {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary) 0%, #8fe3d1 100%);
            color: #062435;
            font-size: 22px;
            font-weight: 800;
            box-shadow: 0 12px 30px rgba(122, 215, 195, 0.35);
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            width: fit-content;
            padding: 8px 12px;
            border: 1px solid rgba(122, 215, 195, 0.28);
            border-radius: 999px;
            background: rgba(122, 215, 195, 0.08);
            color: var(--primary);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            margin-bottom: 18px;
        }

        .eyebrow::before {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--primary);
            box-shadow: 0 0 16px rgba(122, 215, 195, 0.75);
        }

        h1 {
            margin: 0 0 10px;
            font-size: clamp(2.1rem, 3vw, 3.1rem);
            line-height: 1.05;
            letter-spacing: -0.06em;
            font-family: 'Playfair Display', serif;
        }

        .subtitle {
            margin: 0 0 28px;
            color: var(--muted);
            font-size: 0.97rem;
            line-height: 1.7;
            max-width: 440px;
        }

        .alert {
            margin-bottom: 20px;
            padding: 14px 16px;
            border: 1px solid rgba(255, 140, 137, 0.4);
            border-radius: 14px;
            background: rgba(255, 140, 137, 0.1);
            color: #ffc8c6;
            font-size: 0.85rem;
            font-weight: 600;
        }

        form {
            display: grid;
            gap: 18px;
        }

        .field {
            display: grid;
            gap: 10px;
        }

        label {
            font-size: 0.74rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #dfeaf5;
        }

        input {
            width: 100%;
            height: 52px;
            padding: 0 16px;
            border: 1px solid rgba(148, 175, 195, 0.22);
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.04);
            color: var(--text);
            font-size: 0.96rem;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
        }

        input::placeholder {
            color: rgba(168, 186, 205, 0.75);
        }

        input:focus {
            border-color: rgba(122, 215, 195, 0.75);
            box-shadow: 0 0 0 4px rgba(122, 215, 195, 0.12);
            transform: translateY(-1px);
        }

        .password-field {
            position: relative;
        }

        .password-field input {
            padding-right: 48px;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            width: 32px;
            height: 32px;
            border: 0;
            border-radius: 10px;
            background: transparent;
            color: var(--muted);
            font-size: 1.05rem;
            cursor: pointer;
        }

        .toggle-password svg {
            width: 20px;
            height: 20px;
            display: block;
            fill: none;
            stroke: currentColor;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-width: 1.8;
        }

        .toggle-password:hover {
            background: rgba(255, 255, 255, 0.05);
            color: var(--text);
        }

        .form-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            color: var(--muted);
            font-size: 0.8rem;
            margin-top: -4px;
        }

        .remember {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .remember input {
            width: 16px;
            height: 16px;
            accent-color: var(--primary-strong);
        }

        .chip {
            padding: 7px 10px;
            border: 1px solid rgba(122, 215, 195, 0.22);
            border-radius: 999px;
            background: rgba(122, 215, 195, 0.06);
            color: var(--primary);
            font-weight: 700;
        }

        .submit {
            width: 100%;
            height: 54px;
            border: 0;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-strong) 100%);
            color: #051d2f;
            font-size: 0.98rem;
            font-weight: 800;
            letter-spacing: 0.04em;
            cursor: pointer;
            box-shadow: 0 18px 26px rgba(78, 188, 154, 0.35);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 22px 30px rgba(78, 188, 154, 0.45);
        }

        .register-note {
            margin-top: 18px;
            color: var(--muted);
            font-size: 0.85rem;
            text-align: center;
        }

        .art-panel {
            position: relative;
            background:
                linear-gradient(160deg, rgba(122, 215, 195, 0.2), rgba(247, 216, 137, 0.12)),
                #ebf0eb;
            color: #15344a;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .art-panel::before,
        .art-panel::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(21, 52, 74, 0.08);
        }

        .art-panel::before {
            width: 540px;
            height: 540px;
            top: -170px;
            right: -120px;
        }

        .art-panel::after {
            width: 420px;
            height: 420px;
            bottom: -120px;
            left: -80px;
        }

        .content-wrap {
            position: relative;
            z-index: 1;
            width: min(100%, 430px);
            padding: 54px 34px 34px;
        }

        .mini-label {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(12, 35, 52, 0.1);
            border: 1px solid rgba(12, 35, 52, 0.08);
            letter-spacing: 0.12em;
            text-transform: uppercase;
            font-size: 0.68rem;
            font-weight: 700;
            margin-bottom: 16px;
        }

        .display-title {
            margin: 0 0 12px;
            font-size: clamp(2rem, 2.8vw, 3rem);
            line-height: 1.08;
            font-family: 'Playfair Display', serif;
            max-width: 300px;
        }

        .display-copy {
            margin: 0 0 28px;
            font-size: 0.96rem;
            line-height: 1.7;
            color: rgba(21, 52, 74, 0.75);
            max-width: 290px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(80px, 1fr));
            gap: 12px;
            margin-top: 22px;
        }

        .stat-box {
            padding: 14px 12px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.35);
            border: 1px solid rgba(21, 52, 74, 0.08);
            box-shadow: 0 10px 20px rgba(27, 51, 70, 0.08);
        }

        .stat-box strong {
            display: block;
            font-size: 1.35rem;
            margin-bottom: 4px;
            letter-spacing: -0.05em;
        }

        .stat-box span {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: rgba(21, 52, 74, 0.7);
        }

        .book-stack {
            position: absolute;
            right: 42px;
            bottom: 36px;
            width: 240px;
            height: 170px;
            z-index: 0;
        }

        .book {
            position: absolute;
            bottom: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255,255,255,0.95);
            font-weight: 800;
            letter-spacing: 0.08em;
            font-size: 0.58rem;
            text-transform: uppercase;
            border-radius: 8px 8px 12px 12px;
            box-shadow: 0 18px 24px rgba(21, 52, 74, 0.14);
        }

        .book:nth-child(1) { left: 0; width: 100px; height: 110px; background: linear-gradient(180deg, #f48b7d, #cf695f); transform: rotate(-8deg); }
        .book:nth-child(2) { left: 60px; width: 110px; height: 128px; background: linear-gradient(180deg, #f7d889, #d9b867); transform: rotate(9deg); }
        .book:nth-child(3) { left: 125px; width: 90px; height: 146px; background: linear-gradient(180deg, #63b8a7, #3b8f82); transform: rotate(-3deg); }

        @media (max-width: 900px) {
            .login-card {
                grid-template-columns: 1fr;
            }

            .art-panel {
                min-height: 280px;
            }
        }

        @media (max-width: 560px) {
            .login-shell {
                width: 100%;
                padding: 18px;
            }

            .login-panel {
                padding: 28px 22px 26px;
            }

            .content-wrap {
                padding: 26px 18px 18px;
            }

            .stats {
                grid-template-columns: repeat(3, minmax(70px, 1fr));
            }
        }
    </style>
</head>
<body>
    <main class="login-shell">
        <section class="login-card">
            <div class="login-panel">
                <div class="brand">
                    <span class="brand-mark">+</span>
                    <span>Perpustakaan</span>
                </div>

                <div class="eyebrow">Portal akses</div>
                <h1>Selamat datang.</h1>
                <p class="subtitle">Pilih akses sesuai peran Anda, lalu masuk ke dashboard perpustakaan dengan aman dan cepat.</p>

                @if($errors->any())
                    <div class="alert">{{ $errors->first() }}</div>
                @endif

                <form action="{{ route('login.attempt') }}" method="POST">
                    @csrf

                    <div class="field">
                        <label for="role">Akses</label>
                        <div class="role-switch" style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-top:4px;">
                            <label style="display:flex; align-items:center; justify-content:center; gap:8px; padding:12px 14px; border:1px solid rgba(148,175,195,0.22); border-radius:14px; background:rgba(255,255,255,0.04); cursor:pointer; color:var(--text); font-size:0.8rem; letter-spacing:0.04em; text-transform:none; font-weight:700;">
                                <input type="radio" name="role" value="admin" {{ old('role', 'admin') === 'admin' ? 'checked' : '' }} style="width:16px; height:16px; accent-color: var(--primary-strong);">
                                Admin
                            </label>
                            <label style="display:flex; align-items:center; justify-content:center; gap:8px; padding:12px 14px; border:1px solid rgba(148,175,195,0.22); border-radius:14px; background:rgba(255,255,255,0.04); cursor:pointer; color:var(--text); font-size:0.8rem; letter-spacing:0.04em; text-transform:none; font-weight:700;">
                                <input type="radio" name="role" value="user" {{ old('role') === 'user' ? 'checked' : '' }} style="width:16px; height:16px; accent-color: var(--primary-strong);">
                                User
                            </label>
                        </div>
                    </div>

                    <div class="field">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="nama@gmail.com" required autofocus>
                    </div>

                    <div class="field">
                        <label for="password">Password</label>
                        <div class="password-field">
                            <input id="password" type="password" name="password" placeholder="Masukkan password Anda" required>
                            <button type="button" class="toggle-password" id="toggle-password" aria-label="Tampilkan password" title="Tampilkan password">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6Z"></path><circle cx="12" cy="12" r="2.5"></circle></svg>
                            </button>
                        </div>
                    </div>

                    <div class="form-row">
                        <label class="remember" for="remember">
                            <input type="checkbox" name="remember" id="remember">
                            <span>Ingat saya</span>
                        </label>
                        <span class="chip">Akses aman</span>
                    </div>

                    <button class="submit" type="submit">Masuk ke dashboard</button>
                </form>

                <div class="register-note">Belum punya akun? <a href="{{ route('register') }}" style="color: var(--primary); text-decoration: none; font-weight: 700;">Daftar sekarang</a></div>
            </div>

            <div class="art-panel" aria-hidden="true">
                <div class="content-wrap">
                    <div class="mini-label">Library system</div>
                    <h2 class="display-title">Baca, kelola, dan pantau.</h2>
                    <p class="display-copy">Platform manajemen perpustakaan modern untuk menjaga stok, anggota, dan transaksi tetap rapi.</p>

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

                <div class="book-stack">
                    <div class="book">Buku</div>
                    <div class="book">Data</div>
                    <div class="book">Akses</div>
                </div>
            </div>
        </section>
    </main>

    <script>
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('toggle-password');
        const eyeIcon = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6Z"></path><circle cx="12" cy="12" r="2.5"></circle></svg>';
        const eyeOffIcon = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 3l18 18M10.6 6.2A10.8 10.8 0 0 1 12 6c6.5 0 10 6 10 6a18.4 18.4 0 0 1-3.1 3.7M6.1 6.2C3.4 8.1 2 12 2 12s3.5 6 10 6a10.8 10.8 0 0 0 2.4-.3"></path><path d="M9.9 9.9a3 3 0 0 0 4.2 4.2"></path></svg>';

        if (passwordInput && togglePassword) {
            togglePassword.addEventListener('click', function () {
                const isHidden = passwordInput.type === 'password';
                passwordInput.type = isHidden ? 'text' : 'password';
                this.innerHTML = isHidden ? eyeOffIcon : eyeIcon;
                this.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
                this.setAttribute('title', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
            });
        }
    </script>
</body>
</html>
