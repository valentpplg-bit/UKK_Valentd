@extends('layouts.app')

@section('content')

<div class="stats-grid mb-4">
    <div>
        <a href="{{ route('anggota.index') }}" class="stat-card card bg-blue-1 text-white text-decoration-none">
            <div class="card-body">
                <h5>Anggota</h5>
                <h1>{{ number_format($totalAnggota) }}</h1>
                <span class="more-btn">More info</span>
            </div>
        </a>
    </div>

    <div>
        <a href="{{ route('buku.index') }}" class="stat-card card bg-blue-1 text-white text-decoration-none">
            <div class="card-body">
                <h5>Jenis Buku</h5>
                <h1>{{ number_format($totalBuku) }}</h1>
                <span class="more-btn">More info</span>
            </div>
        </a>
    </div>

    <div>
        <a href="{{ route('transaksi.index') }}" class="stat-card card bg-gold-1 text-white text-decoration-none">
            <div class="card-body">
                <h5>Peminjam</h5>
                <h1>{{ number_format($totalPeminjaman) }}</h1>
                <span class="more-btn">More info</span>
            </div>
        </a>
    </div>

    <div>
        <a href="{{ route('report.index') }}" class="stat-cardphp  card bg-red-1 text-white text-decoration-none">
            <div class="card-body">
                <h5>Di Kembalikan</h5>
                <h1>{{ number_format($totalTransaksi) }}</h1>
                <span class="more-btn">More info</span>
            </div>
        </a>
    </div>
</div>

<div class="table-card card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Transaksi Terbaru</h5>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Buku</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksiTerbaru as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->anggota?->nama_lengkap ?? '-' }}</td>
                            <td>{{ $item->buku?->judul_buku ?? '-' }}</td>
                            <td>{{ $item->tanggal_pinjam?->format('d/m/Y') ?? '-' }}</td>
                            <td>
                                <span class="badge-status {{ $item->status === 'dipinjam' ? 'bg-success' : ($item->status === 'terlambat' ? 'bg-danger' : 'bg-primary') }} text-white">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection