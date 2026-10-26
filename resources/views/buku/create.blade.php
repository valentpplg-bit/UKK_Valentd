@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            <h4>Tambah Buku</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Gambar Buku</label>
                    <input type="file" name="gambar" class="form-control" accept="image/*">
                </div>

                <div class="mb-3">
                    <label class="form-label">Judul Buku</label>
                    <input type="text" name="judul_buku" class="form-control" value="{{ old('judul_buku') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Penulis</label>
                    <input type="text" name="penulis" class="form-control" value="{{ old('penulis') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Penerbit</label>
                    <input type="text" name="penerbit" class="form-control" value="{{ old('penerbit') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Tahun</label>
                    <input type="number" name="tahun" class="form-control" value="{{ old('tahun') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <input type="text" name="kategori" class="form-control" value="{{ old('kategori') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control" value="{{ old('stok') }}">
                </div>

                <button type="submit" class="btn btn-success">
                    Simpan
                </button>

                <a href="{{ route('buku.index') }}" class="btn btn-secondary">
                    Kembali
                </a>

            </form>

        </div>

    </div>

</div>

@endsection