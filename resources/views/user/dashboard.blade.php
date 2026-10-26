@extends('layouts.user')
@section('title', 'Beranda User - Perpustakaan Sekolah')
@section('content')
<div class="page-heading mb-4">
    <h1>Halo, {{ $anggota?->nama_lengkap ?? auth()->user()->name }} 👋</h1>
    <p class="mb-0">Selamat datang kembali di perpustakaan digital Anda.</p>
</div>

<div class="panel hero-panel p-4 mb-4">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
        <div>
            <span class="badge rounded-pill px-3 py-2 mb-3">Member aktif</span>
            <div class="title mb-2">Riwayat membaca Anda hari ini</div>
            <div class="sub">Buku yang Anda pinjam dan daftar bacaan terbaru siap dipantau dengan cepat.</div>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('user.catalog') }}" class="btn btn-gold"><i class="bi bi-search me-1"></i>Cari buku</a>
            <a href="{{ route('user.loans') }}" class="btn btn-outline-light"><i class="bi bi-journal-text me-1"></i>Peminjaman</a>
        </div>
    </div>
</div>

<div class="row g-3 mb-5">
    @foreach([
        ['Buku Dipinjam', $borrowedCount, 'bi-bookmark-heart'],
        ['Peminjaman', $totalCount, 'bi-journal-check'],
        ['Dikembalikan', $returnedCount, 'bi-check2-circle'],
        ['Buku Baru', $recentBooks->count(), 'bi-book-half']
    ] as [$label, $value, $icon])
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="icon mb-3"><i class="bi {{ $icon }}"></i></div>
                <div class="number">{{ number_format($value) }}</div>
                <small>{{ $label }}</small>
            </div>
        </div>
    @endforeach
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="section-title mb-0">Buku yang sedang dipinjam</h2>
    <a href="{{ route('user.loans') }}" class="btn btn-sm btn-outline-navy">Lihat semua</a>
</div>

<div class="row g-3 mb-5">
    @forelse($activeLoans as $loan)
        <div class="col-12 col-lg-6">
            <div class="panel p-3 h-100">
                <div class="d-flex gap-3">
                    <x-book-cover :book="$loan->buku" class="book-cover--compact rounded" />
                    <div class="flex-grow-1">
                        <h3 class="h6 mb-1">{{ $loan->buku->judul_buku }}</h3>
                        <p class="loan-meta mb-2">{{ $loan->buku->penulis }}</p>
                        <div class="loan-meta">Dipinjam: {{ $loan->tanggal_pinjam->format('d/m/Y') }}</div>
                        <div class="loan-meta">Jatuh tempo: {{ $loan->tanggal_jatuh_tempo?->format('d/m/Y') ?? '-' }}</div>
                        <a href="{{ route('user.book.show', $loan->buku) }}" class="btn btn-sm btn-outline-navy mt-3">Detail</a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="panel empty-state">
                <i class="bi bi-journal"></i>
                <div>Belum ada buku yang sedang dipinjam.</div>
                <a href="{{ route('user.catalog') }}" class="btn btn-sm btn-gold mt-3">Lihat katalog buku</a>
            </div>
        </div>
    @endforelse
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="section-title mb-0">Buku terbaru</h2>
    <a href="{{ route('user.catalog') }}" class="btn btn-sm btn-outline-navy">Buka katalog</a>
</div>

<div class="row g-3">
    @foreach($recentBooks as $book)
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="book-card">
                <x-book-cover :book="$book" />
                <div class="p-3">
                    <h3>{{ $book->judul_buku }}</h3>
                    <p class="meta mb-1">{{ $book->penulis }}</p>
                    <p class="meta mb-3">{{ $book->kategori ?: 'Umum' }} · Stok {{ $book->stok }}</p>
                    <a href="{{ route('user.book.show', $book) }}" class="btn btn-sm btn-outline-navy">Detail buku</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection