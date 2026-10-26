@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow">
        <div class="card-header bg-warning"><h4>Edit Transaksi</h4></div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger"><ul class="mb-0">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul></div>
            @endif

            <form action="{{ route('transaksi.update', $transaksi) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Anggota</label>
                    <select name="id_anggota" class="form-select" required>
                        @foreach($anggota as $item)
                            <option value="{{ $item->id_anggota }}" @selected(old('id_anggota', $transaksi->id_anggota) == $item->id_anggota)>
                                {{ $item->nama_lengkap }} ({{ $item->nis }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Buku</label>
                    <select name="id_buku" class="form-select" required>
                        @foreach($buku as $item)
                            <option value="{{ $item->id_buku }}" @selected(old('id_buku', $transaksi->id_buku) == $item->id_buku)>
                                {{ $item->judul_buku }} (stok: {{ $item->stok }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" class="form-control" value="{{ old('tanggal_pinjam', $transaksi->tanggal_pinjam->format('Y-m-d')) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal Jatuh Tempo</label>
                    <input type="date" class="form-control" value="{{ ($transaksi->tanggal_jatuh_tempo ?? $transaksi->tanggal_pinjam->copy()->addDays(7))->format('Y-m-d') }}" readonly>
                    <small class="text-muted">Otomatis {{ config('perpustakaan.lama_peminjaman_hari') }} hari setelah tanggal pinjam.</small>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            @foreach(['dipinjam' => 'Dipinjam', 'dikembalikan' => 'Dikembalikan', 'terlambat' => 'Terlambat'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('status', $transaksi->status) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Denda</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="denda" class="form-control" value="{{ old('denda', $transaksi->denda) }}" min="0" step="1000">
                        </div>
                        <small class="text-muted">Otomatis: Rp {{ number_format(config('perpustakaan.denda_per_hari'), 0, ',', '.') }} per hari keterlambatan.</small>
                    </div>
                </div>
                <button class="btn btn-success" type="submit">Simpan Perubahan</button>
                <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection