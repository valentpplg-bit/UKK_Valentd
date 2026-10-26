@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Laporan Transaksi</h3>
        <button type="button" class="btn btn-outline-secondary" onclick="window.print()">
            <i class="bi bi-printer"></i> Cetak
        </button>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('report.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Tanggal mulai</label>
                    <input type="date" name="mulai" class="form-control" value="{{ $filters['mulai'] ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal sampai</label>
                    <input type="date" name="sampai" class="form-control" value="{{ $filters['sampai'] ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua status</option>
                        @foreach(['dipinjam' => 'Dipinjam', 'dikembalikan' => 'Dikembalikan', 'terlambat' => 'Terlambat' ] as $value => $label)
                            <option value="{{ $value }}" @selected(($filters['status'] ?? '') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Tampilkan</button>
                    <a href="{{ route('report.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md"><div class="card border-primary"><div class="card-body"><small>Total transaksi</small><h4>{{ $ringkasan['total'] }}</h4></div></div></div>
        <div class="col-md"><div class="card border-warning"><div class="card-body"><small>Sedang dipinjam</small><h4>{{ $ringkasan['dipinjam'] }}</h4></div></div></div>
        <div class="col-md"><div class="card border-success"><div class="card-body"><small>Dikembalikan</small><h4>{{ $ringkasan['dikembalikan'] }}</h4></div></div></div>
        <div class="col-md"><div class="card border-danger"><div class="card-body"><small>Terlambat</small><h4>{{ $ringkasan['terlambat'] }}</h4></div></div></div>
        <div class="col-md"><div class="card border-dark"><div class="card-body"><small>Total denda</small><h4>Rp {{ number_format($ringkasan['denda'], 0, ',', '.') }}</h4></div></div></div>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead><tr><th>No</th><th>Anggota</th><th>Buku</th><th>Pinjam</th><th>Jatuh Tempo</th><th>Kembali</th><th>Status</th><th>Denda</th></tr></thead>
                <tbody>
                    @forelse($transaksi as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->anggota?->nama_lengkap ?? '-' }}</td>
                            <td>{{ $item->buku?->judul_buku ?? '-' }}</td>
                            <td>{{ optional($item->tanggal_pinjam)->format('d-m-Y') ?? '-' }}</td>
                            <td>{{ optional($item->tanggal_jatuh_tempo ?? optional($item->tanggal_pinjam)->copy()->addDays(config('perpustakaan.lama_peminjaman_hari')))->format('d-m-Y') ?? '-' }}</td>
                            <td>{{ $item->tanggal_kembali?->format('d-m-Y') ?? '-' }}</td>
                            <td>{{ ucfirst($item->status ?? 'belum_diketahui') }}</td>
                            <td>Rp {{ number_format($item->denda ?? 0, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center">Tidak ada data transaksi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection