<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --sidebar-bg: #24262d;
            --sidebar-deep: #1b1d22;
            --sidebar-hover: rgba(255,255,255,0.06);
            --active-green: #2bb673;
            --content-bg: #edf1f3;
            --topbar-bg: rgba(255,255,255,0.8);
            --text-dark: #1d242b;
            --text-soft: #5c6773;
            --line-soft: rgba(29,36,43,0.12);
            --shadow-soft: 0 12px 26px rgba(25, 34, 40, 0.12);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--content-bg);
            color: var(--text-dark);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            width: 220px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: linear-gradient(180deg, var(--sidebar-bg) 0%, var(--sidebar-deep) 100%);
            color: white;
            z-index: 20;
            box-shadow: 6px 0 18px rgba(13, 18, 22, 0.18);
        }

        .sidebar .logo {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 16px 14px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .sidebar .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.1rem;
            font-weight: 800;
        }

        .sidebar .brand-mark {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 22px;
            height: 22px;
            border-radius: 6px;
            background: rgba(255,255,255,0.08);
            font-size: 0.8rem;
        }

        .sidebar .menu-toggle {
            background: transparent;
            border: none;
            color: rgba(255,255,255,0.7);
            font-size: 1.2rem;
            padding: 2px 6px;
        }

        .sidebar .profile-box {
            padding: 14px 12px 10px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .profile-card {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,0.04);
            border-radius: 10px;
            padding: 8px 10px;
        }

        .profile-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: linear-gradient(135deg, #61d7a5, #2bb673);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 800;
            color: white;
        }

        .profile-meta {
            font-size: 0.7rem;
            line-height: 1.2;
            color: rgba(255,255,255,0.8);
        }

        .nav-section {
            padding-top: 10px;
        }

        .sidebar a,
        .sidebar button {
            display: flex;
            align-items: center;
            gap: 10px;
            width: calc(100% - 18px);
            margin: 6px 9px;
            padding: 10px 12px;
            border-radius: 8px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            font-weight: 600;
            background: transparent;
            border: none;
            text-align: left;
            transition: all 0.2s ease;
        }

        .sidebar a:hover,
        .sidebar button:hover {
            background: var(--sidebar-hover);
            color: white;
        }

        .sidebar a.active {
            background: rgba(43,182,115,0.14);
            color: white;
            border-left: 3px solid var(--active-green);
            padding-left: 9px;
        }

        .content {
            margin-left: 220px;
            min-height: 100vh;
        }

        .navbar-custom {
            background: rgba(255,255,255,0.82);
            border-bottom: 1px solid var(--line-soft);
            padding: 14px 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 3px 12px rgba(24, 31, 37, 0.06);
        }

        .navbar-custom h4 {
            margin: 0;
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-dark);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--text-soft);
            font-size: 0.9rem;
        }

        .topbar-right .user-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(43,182,115,0.12);
            color: #1d7d4d;
            border-radius: 999px;
            padding: 5px 10px;
            font-weight: 700;
        }

        .page-shell {
            padding: 18px 18px 24px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-soft);
            min-height: 155px;
            color: white;
            text-decoration: none;
        }

        .stat-card .card-body {
            min-height: 155px;
            padding: 20px 18px 12px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .stat-card h5 {
            margin: 0;
            font-size: 1rem;
            font-weight: 700;
            opacity: 0.95;
        }

        .stat-card h1 {
            margin: 0;
            font-size: 2.5rem;
            font-weight: 800;
            line-height: 1.2;
        }

        .more-btn {
            display: inline-block;
            align-self: flex-start;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 0.7rem;
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.2);
            font-weight: 700;
            color: white;
            text-decoration: none;
        }

        .bg-blue-1 { background: linear-gradient(135deg, #1d90ff 0%, #0a6df0 100%); }
        .bg-green-1 { background: linear-gradient(135deg, #1d90ff 0%, #0fa36d 100%); }
        .bg-gold-1 { background: linear-gradient(135deg, #f7d76b 0%, #f0b62d 100%); }
        .bg-red-1 { background: linear-gradient(135deg, #f65d6f 0%, #d83c4c 100%); }

        .table-card {
            background: rgba(255,255,255,0.72);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(29,36,43,0.06);
        }

        .table-card .card-header {
            background: linear-gradient(90deg, rgba(24,108,208,0.08), rgba(24,108,208,0.03));
            border-bottom: 1px solid rgba(29,36,43,0.08);
            padding: 14px 18px;
        }

        .table-card .card-header h5 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--text-dark);
        }

        .table thead th {
            background: rgba(24,108,208,0.06);
            color: #1b2d3a;
            border-bottom: 1px solid rgba(29,36,43,0.08);
            font-weight: 700;
        }

        .table tbody td {
            color: #2a3540;
            vertical-align: middle;
        }

        .badge-status {
            border-radius: 999px;
            padding: 6px 12px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .footer-bar {
            position: fixed;
            bottom: 0;
            left: 220px;
            right: 0;
            background: rgba(255,255,255,0.8);
            border-top: 1px solid var(--line-soft);
            color: var(--text-soft);
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.82rem;
        }

        @media (max-width: 991px) {
            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }
            .content {
                margin-left: 0;
            }
            .footer-bar {
                left: 0;
            }
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

</head>

<body>

<div class="sidebar">
    <div class="logo">
        <div class="brand">
            <span class="brand-mark"><i class="bi bi-book-half"></i></span>
            <span>Perpus</span>
        </div>
        <button type="button" class="menu-toggle"><i class="bi bi-list"></i></button>
    </div>

    <div class="profile-box">
        <div class="profile-card">
            <div class="profile-avatar">A</div>
            <div class="profile-meta">
                <div style="font-weight:700;">Admin</div>
                <div>Online</div>
            </div>
        </div>
    </div>

    <div class="nav-section">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-house-door"></i>
            Dashboard
        </a>

        <a href="{{ route('buku.index') }}" class="{{ request()->routeIs('buku.*') ? 'active' : '' }}">
            <i class="bi bi-book"></i>
            Data Buku
        </a>

        <a href="{{ route('anggota.index') }}" class="{{ request()->routeIs('anggota.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i>
            Anggota
        </a>

        <a href="{{ route('transaksi.index') }}" class="{{ request()->routeIs('transaksi.*') ? 'active' : '' }}">
            <i class="bi bi-repeat"></i>
            Transaksi
        </a>

        <a href="{{ route('report.index') }}" class="{{ request()->routeIs('report.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text"></i>
            Report
        </a>

        <form action="{{ route('logout') }}" method="POST" class="mt-2">
            @csrf
            <button type="submit" class="{{ request()->routeIs('logout') ? 'active' : '' }}">
                <i class="bi bi-box-arrow-right"></i>
                Logout
            </button>
        </form>
    </div>
</div>

<div class="content">
    <div class="navbar-custom">
        <h4>Dashboard</h4>
        <div class="topbar-right">
            <span>Welcome, <strong>{{ auth()->user()->name ?? 'Admin' }}</strong></span>
            <span class="user-status"><i class="bi bi-circle-fill" style="font-size:0.5rem;"></i> Petugas</span>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: var(--text-soft); text-decoration:none; font-weight:700;">Sign out</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                @csrf
            </form>
        </div>
    </div>

    <div class="page-shell">
        @yield('content')
    </div>
</div>

<div class="footer-bar">
    <span>Copyright © 2025 Informasi Perpustakaan Codekop All rights | Powered in 0.0933 seconds.</span>
    <span>Made with <i class="bi bi-heart-fill" style="color:#e11d48;"></i> Codekop</span>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')

</body>
</html>