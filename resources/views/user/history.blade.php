@extends('layouts.user')
@section('title', 'History - Perpustakaan Sekolah')
@section('content')
<div class="page-heading mb-4">
    <h1>History Peminjaman</h1>
    <p class="mb-0">Riwayat seluruh aktivitas peminjaman buku Anda.</p>
</div>

<div class="panel overflow-hidden">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Buku</th>
                    <th>Pinjam</th>
                    <th>Jatuh Tempo</th>
                    <th>Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($history as $item)
                    <tr>
                        <td>{{ $history->firstItem() + $loop->index }}</td>
                        <td>
                            <a class="text-decoration-none fw-semibold" style="color:var(--navy)" href="{{ route('user.book.show', $item->buku) }}">{{ $item->buku->judul_buku }}</a>
                            <small class="d-block text-muted">{{ $item->buku->penulis }}</small>
                        </td>
                        <td>{{ $item->tanggal_pinjam->format('d/m/Y') }}</td>
                        <td>{{ $item->tanggal_jatuh_tempo?->format('d/m/Y') ?? '-' }}</td>
                        <td>{{ $item->tanggal_kembali?->format('d/m/Y') ?? '-' }}</td>
                        <td>
                            <span class="badge {{ $item->status === 'dipinjam' ? 'badge-available' : ($item->status === 'terlambat' ? 'badge-empty' : 'bg-light text-dark') }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">Belum ada riwayat peminjaman.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">{{ $history->links() }}</div>
@endsection
