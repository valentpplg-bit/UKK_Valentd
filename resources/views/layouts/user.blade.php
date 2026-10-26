<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Perpustakaan Sekolah')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --navy: #163a52;
            --navy-deep: #0e2a3c;
            --navy-soft: #edf5f7;
            --gold: #e7bb58;
            --gold-soft: #fcefc9;
            --cream: #f6f2ea;
            --ink: #1d3341;
            --muted: #667c8d;
            --line: #dfe8eb;
            --green: #dff5eb;
            --green-strong: #2f8f69;
            --shadow: 0 18px 38px rgba(22, 58, 82, 0.12);
        }

        * { box-sizing: border-box; }

        body {
            min-height: 100vh;
            background: linear-gradient(180deg, #f8f4ee 0%, #f1f6f4 100%);
            color: var(--ink);
            font-family: "Inter", "Segoe UI", sans-serif;
            line-height: 1.55;
        }

        .user-nav {
            background: linear-gradient(135deg, var(--navy-deep) 0%, var(--navy) 100%);
            box-shadow: 0 6px 20px rgba(14, 42, 60, 0.18);
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }

        .user-nav .navbar-brand {
            color: #fff;
            font-weight: 800;
            letter-spacing: .02em;
        }

        .brand-mark {
            display: inline-grid;
            width: 34px;
            height: 34px;
            margin-right: 10px;
            place-items: center;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--gold) 0%, #f0d997 100%);
            color: var(--navy-deep);
            box-shadow: 0 8px 18px rgba(231, 187, 88, 0.4);
        }

        .user-nav .nav-link {
            margin: 0 4px;
            padding: .7rem .85rem !important;
            border-radius: 10px;
            color: rgba(255,255,255,0.8);
            font-size: .92rem;
            font-weight: 600;
        }

        .user-nav .nav-link:hover,
        .user-nav .nav-link.active {
            background: rgba(255,255,255,0.12);
            color: #fff;
        }

        .user-name {
            display: inline-flex;
            align-items: center;
            color: #fff;
            font-size: .9rem;
            font-weight: 600;
            text-decoration: none;
        }

        .avatar {
            display: inline-grid;
            width: 32px;
            height: 32px;
            margin-right: 8px;
            place-items: center;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gold) 0%, #f7e0a0 100%);
            color: var(--navy-deep);
            font-weight: 800;
        }

        main { min-height: calc(100vh - 150px); }

        .page-wrap {
            max-width: 1240px;
            margin: auto;
            padding: 38px 24px 54px;
        }

        .page-heading h1 {
            color: var(--navy-deep);
            font-size: clamp(1.8rem, 3vw, 2.6rem);
            font-weight: 800;
            letter-spacing: -0.04em;
        }

        .page-heading p {
            color: var(--muted);
        }

        .panel,
        .book-card,
        .stat-card {
            border: 1px solid var(--line);
            border-radius: 18px;
            background: rgba(255,255,255,0.85);
            box-shadow: var(--shadow);
        }

        .stat-card {
            position: relative;
            min-height: 150px;
            overflow: hidden;
            padding: 1rem 1.1rem;
        }

        .stat-card::after {
            position: absolute;
            right: -28px;
            bottom: -45px;
            width: 130px;
            height: 130px;
            border: 12px solid rgba(231, 187, 88, 0.18);
            border-radius: 50%;
            content: "";
        }

        .stat-card .icon {
            display: grid;
            width: 42px;
            height: 42px;
            place-items: center;
            border-radius: 12px;
            background: var(--navy-soft);
            color: var(--navy-deep);
            font-size: 1.15rem;
        }

        .stat-card .number {
            color: var(--navy-deep);
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.05em;
        }

        .stat-card small {
            color: var(--muted);
            font-weight: 600;
        }

        .section-title {
            color: var(--navy-deep);
            font-size: 1.28rem;
            font-weight: 800;
            letter-spacing: -0.025em;
        }

        .book-cover {
            display: grid;
            min-height: 118px;
            place-items: center;
            background: linear-gradient(135deg, var(--navy-soft) 0%, #dfeef4 100%);
            color: var(--navy-deep);
            font-size: 2.1rem;
        }

        .book-cover-art {
            position: relative;
            display: flex;
            min-height: 270px;
            aspect-ratio: 2 / 3;
            flex-direction: column;
            align-items: stretch;
            justify-content: space-between;
            overflow: hidden;
            padding: 1.25rem;
            color: #fff;
            text-align: left;
        }

        .book-cover-image {
            display: block;
            width: 100%;
            min-height: 270px;
            aspect-ratio: 2 / 3;
            object-fit: cover;
        }

        .book-cover--compact,
        .book-cover-image.book-cover--compact {
            width: 86px;
            height: 108px;
            min-height: 108px;
            flex: 0 0 86px;
            aspect-ratio: auto;
        }

        .book-cover-art--compact {
            padding: .5rem;
        }

        .book-cover-art--compact .book-cover-art__category {
            font-size: .42rem;
        }

        .book-cover-art--compact .book-cover-art__title {
            font-size: .72rem;
        }

        .book-cover-art--compact .book-cover-art__icon,
        .book-cover-art--compact .book-cover-art__footer {
            display: none;
        }

        .book-cover-art::after {
            position: absolute;
            right: -2rem;
            bottom: 3.5rem;
            width: 9rem;
            height: 9rem;
            border: 1px solid rgba(255, 255, 255, .2);
            border-radius: 50%;
            content: "";
        }

        .book-cover-art--general { background: linear-gradient(145deg, #234b59, #36776e); }
        .book-cover-art--science { background: linear-gradient(145deg, #24476c, #397fa0); }
        .book-cover-art--history { background: linear-gradient(145deg, #70412f, #b27645); }
        .book-cover-art--literature { background: linear-gradient(145deg, #533b62, #9a627b); }
        .book-cover-art--religion { background: linear-gradient(145deg, #315d4d, #73965e); }

        .book-cover-art__category,
        .book-cover-art__footer {
            position: relative;
            z-index: 1;
            font-size: .7rem;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .book-cover-art__title {
            position: relative;
            z-index: 1;
            display: -webkit-box;
            overflow: hidden;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: clamp(1.2rem, 2vw, 1.65rem);
            font-weight: 700;
            line-height: 1.2;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 4;
        }

        .book-cover-art__icon {
            position: relative;
            z-index: 1;
            width: 4.5rem;
            height: auto;
            align-self: flex-end;
            opacity: .8;
        }

        .book-cover-art__footer {
            display: flex;
            justify-content: space-between;
            gap: .5rem;
            border-top: 1px solid rgba(255, 255, 255, .45);
            padding-top: .65rem;
            font-size: .58rem;
            letter-spacing: .06em;
        }

        .book-card {
            height: 100%;
            overflow: hidden;
        }

        .book-card h3 {
            color: var(--navy-deep);
            font-size: 1.05rem;
            font-weight: 800;
            line-height: 1.4;
        }

        .book-card .meta,
        .loan-meta {
            color: var(--muted);
            font-size: .86rem;
        }

        .btn-gold {
            border-color: var(--gold);
            background: linear-gradient(135deg, var(--gold) 0%, #d8a746 100%);
            color: var(--navy-deep);
            font-weight: 700;
        }

        .btn-gold:hover {
            border-color: #c89434;
            background: #c89434;
            color: var(--navy-deep);
        }

        .btn-outline-navy {
            border-color: var(--navy);
            color: var(--navy);
            font-weight: 700;
        }

        .btn-outline-navy:hover {
            background: var(--navy);
            color: #fff;
        }

        .badge-available {
            background: var(--green);
            color: var(--green-strong);
            font-weight: 700;
        }

        .badge-empty {
            background: #f9e0de;
            color: #a74640;
            font-weight: 700;
        }

        .empty-state {
            padding: 38px 20px;
            color: var(--muted);
            text-align: center;
        }

        .empty-state i {
            display: block;
            margin-bottom: 10px;
            color: var(--gold);
            font-size: 2rem;
        }

        .hero-panel {
            background: linear-gradient(135deg, #163a52 0%, #1f4d68 100%);
            color: #fff;
            border: 0;
            overflow: hidden;
        }

        .hero-panel .title {
            font-size: clamp(1.5rem, 2vw, 2.1rem);
            font-weight: 800;
            letter-spacing: -0.04em;
        }

        .hero-panel .sub {
            color: rgba(255,255,255,0.8);
            font-size: .95rem;
        }

        .hero-panel .badge {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.14);
            color: #fff;
        }

        footer {
            border-top: 1px solid var(--line);
            background: rgba(255,255,255,0.72);
            color: var(--muted);
            font-size: .86rem;
        }

        @media (max-width: 991px) {
            .user-name { margin-top: 10px; }
            .user-nav .nav-link { margin-top: 2px; }
        }

        @media (max-width: 575px) {
            .page-wrap { padding: 28px 16px 44px; }
            .stat-card { min-height: 120px; }
        }
    </style>
    @stack('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg user-nav">
    <div class="container-fluid px-4 px-lg-5">
        <a class="navbar-brand" href="{{ route('user.dashboard') }}"><span class="brand-mark"><i class="bi bi-book-half"></i></span>Perpustakaan Sekolah</a>
        <button class="navbar-toggler border-light" type="button" data-bs-toggle="collapse" data-bs-target="#userMenu" aria-label="Buka menu"><i class="bi bi-list text-white"></i></button>
        <div class="collapse navbar-collapse" id="userMenu">
            <div class="navbar-nav ms-lg-4">
                <a class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}" href="{{ route('user.dashboard') }}"><i class="bi bi-house me-1"></i>Beranda</a>
                <a class="nav-link {{ request()->routeIs('user.catalog', 'user.book.show') ? 'active' : '' }}" href="{{ route('user.catalog') }}"><i class="bi bi-grid me-1"></i>Katalog Buku</a>
                <a class="nav-link {{ request()->routeIs('user.loans') ? 'active' : '' }}" href="{{ route('user.loans') }}"><i class="bi bi-journal-bookmark me-1"></i>Peminjaman Saya</a>
                <a class="nav-link {{ request()->routeIs('user.returns') ? 'active' : '' }}" href="{{ route('user.returns') }}"><i class="bi bi-arrow-return-left me-1"></i>Pengembalian</a>
                <a class="nav-link {{ request()->routeIs('user.history') ? 'active' : '' }}" href="{{ route('user.history') }}"><i class="bi bi-clock-history me-1"></i>History</a>
                <a class="nav-link {{ request()->routeIs('user.profile*') ? 'active' : '' }}" href="{{ route('user.profile') }}"><i class="bi bi-person me-1"></i>Profil</a>
            </div>
            <div class="ms-lg-auto d-flex align-items-center mt-3 mt-lg-0">
                <a class="user-name text-decoration-none me-3" href="{{ route('user.profile') }}"><span class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>{{ auth()->user()->name }}</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-outline-light" type="submit"><i class="bi bi-box-arrow-right me-1"></i>Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>
<main>
    <div class="page-wrap">
        @if(session('success'))
            <div class="alert alert-success border-0 rounded-4">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger border-0 rounded-4">{{ session('error') }}</div>
        @endif
        @yield('content')
    </div>
</main>
<footer>
    <div class="container py-4 d-flex flex-wrap justify-content-between gap-2">
        <span>Perpustakaan Sekolah</span>
        <span>Jam layanan: Senin-Jumat, 08.00-15.00</span>
        <span>&copy; {{ date('Y') }} Perpustakaan Sekolah</span>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>