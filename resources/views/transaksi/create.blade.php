@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow">
        <div class="card-header bg-primary text-white"><h4>Pinjam Buku</h4></div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger"><ul class="mb-0">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul></div>
            @endif

            @if($anggota->isEmpty() || $buku->isEmpty())
                <div class="alert alert-warning">Pastikan sudah ada anggota dan buku dengan stok tersedia.</div>
            @else
                <form action="{{ route('transaksi.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Anggota</label>
                        <select name="id_anggota" class="form-select" required>
                            <option value="">Pilih anggota</option>
                            @foreach($anggota as $item)
                                <option value="{{ $item->id_anggota }}" @selected(old('id_anggota') == $item->id_anggota)>
                                    {{ $item->nama_lengkap }} ({{ $item->nis }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Buku</label>
                        <select name="id_buku" class="form-select" required>
                            <option value="">Pilih buku</option>
                            @foreach($buku as $item)
                                <option value="{{ $item->id_buku }}" @selected(old('id_buku') == $item->id_buku)>
                                    {{ $item->judul_buku }} (stok: {{ $item->stok }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" class="form-control" value="{{ old('tanggal_pinjam', now()->format('Y-m-d')) }}" required>
                    </div>
                    <div class="alert alert-info">Tanggal jatuh tempo otomatis {{ config('perpustakaan.lama_peminjaman_hari') }} hari setelah tanggal pinjam.</div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                @foreach(['dipinjam' => 'Dipinjam', 'dikembalikan' => 'Dikembalikan', 'terlambat' => 'Terlambat'] as $value => $label)
                                    <option value="{{ $value }}" @selected(old('status', 'dipinjam') === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Denda</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="denda" class="form-control" value="{{ old('denda', 0) }}" min="0" step="1000">
                            </div>
                            <small class="text-muted">Rp {{ number_format(config('perpustakaan.denda_per_hari'), 0, ',', '.') }} per hari keterlambatan.</small>
                        </div>
                    </div>
                    <button class="btn btn-success" type="submit">Simpan</button>
                    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection