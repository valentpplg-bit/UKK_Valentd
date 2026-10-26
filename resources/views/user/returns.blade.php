@extends('layouts.user')
@section('title', 'Pengembalian - Perpustakaan Sekolah')
@section('content')
<div class="page-heading mb-4">
    <h1>Pengembalian Buku</h1>
    <p class="mb-0">Daftar buku yang sudah kamu kembalikan dan yang masih masuk status terlambat.</p>
</div>

<div class="panel overflow-hidden">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                    <th>Denda</th>
                </tr>
            </thead>
            <tbody>
                @forelse($returns as $return)
                    <tr>
                        <td>{{ $returns->firstItem() + $loop->index }}</td>
                        <td>
                            <a class="text-decoration-none fw-semibold" style="color:var(--navy)" href="{{ route('user.book.show', $return->buku) }}">{{ $return->buku->judul_buku }}</a>
                            <small class="d-block text-muted">{{ $return->buku->penulis }}</small>
                        </td>
                        <td>{{ $return->tanggal_pinjam->format('d/m/Y') }}</td>
                        <td>{{ $return->tanggal_kembali?->format('d/m/Y') ?? '-' }}</td>
                        <td>
                            <span class="badge {{ $return->status === 'terlambat' ? 'badge-empty' : 'badge-available' }}">
                                {{ $return->status === 'terlambat' ? 'Terlambat' : 'Dikembalikan' }}
                            </span>
                        </td>
                        <td>Rp {{ number_format($return->denda, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">Belum ada buku yang dikembalikan.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">{{ $returns->links() }}</div>
@endsection
