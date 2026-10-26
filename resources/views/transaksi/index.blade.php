@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Data Transaksi</h3>
        <a href="{{ route('transaksi.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Pinjam Buku
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>No</th><th>Anggota</th><th>Buku</th><th>Pinjam</th>
                        <th>Jatuh Tempo</th><th>Kembali</th><th>Status</th><th>Denda</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksi as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->anggota->nama_lengkap }}</td>
                            <td>{{ $item->buku->judul_buku }}</td>
                            <td>{{ $item->tanggal_pinjam->format('d-m-Y') }}</td>
                            <td>{{ ($item->tanggal_jatuh_tempo ?? $item->tanggal_pinjam->copy()->addDays(config('perpustakaan.lama_peminjaman_hari')))->format('d-m-Y') }}</td>
                            <td>{{ $item->tanggal_kembali?->format('d-m-Y') ?? '-' }}</td>
                            <td>{{ ucfirst($item->status) }}</td>
                            <td>Rp {{ number_format($item->denda, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('transaksi.edit', $item) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('transaksi.destroy', $item) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Yakin ingin menghapus transaksi ini?')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                                @if($item->status === 'dipinjam')
                                    <form action="{{ route('transaksi.return', $item) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-success btn-sm" type="submit">Kembalikan</button>
                                    </form>
                                @else
                                    <span class="text-muted">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="text-center">Belum ada transaksi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection