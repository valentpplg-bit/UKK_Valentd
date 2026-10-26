@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card">
        <div class="card-header">
            <h3>Edit Buku</h3>
        </div>

        <div class="card-body">

            <form action="{{ route('buku.update', $buku->id_buku) }}" method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Gambar Buku</label>
                    <input type="file" name="gambar" class="form-control" accept="image/*">
                    @if($buku->gambar)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $buku->gambar) }}" alt="Cover buku" style="width: 120px; height: 180px; object-fit: cover; border-radius: 8px;">
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label>Judul Buku</label>
                    <input type="text" name="judul_buku" class="form-control"
                           value="{{ $buku->judul_buku }}">
                </div>

                <div class="mb-3">
                    <label>Penulis</label>
                    <input type="text" name="penulis" class="form-control"
                           value="{{ $buku->penulis }}">
                </div>

                <div class="mb-3">
                    <label>Penerbit</label>
                    <input type="text" name="penerbit" class="form-control"
                           value="{{ $buku->penerbit }}">
                </div>

                <div class="mb-3">
                    <label>Tahun</label>
                    <input type="number" name="tahun" class="form-control"
                           value="{{ $buku->tahun }}">
                </div>

                <div class="mb-3">
                    <label>Kategori</label>
                    <input type="text" name="kategori" class="form-control"
                           value="{{ $buku->kategori }}">
                </div>

                <div class="mb-3">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control">{{ $buku->deskripsi }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Stok</label>
                    <input type="number" name="stok" class="form-control"
                           value="{{ $buku->stok }}">
                </div>

                <button type="submit" class="btn btn-success">Update</button>

                <a href="{{ route('buku.index') }}" class="btn btn-secondary">
                    Kembali
                </a>

            </form>

        </div>
    </div>

</div>

@endsection 