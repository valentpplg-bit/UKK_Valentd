@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">Data Buku</h3>

        <a href="{{ route('buku.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Buku
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Daftar Buku</h5>
        </div>

        <div class="card-body">

            <table class="table table-bordered table-hover">

                <thead class="table-light">

                    <tr>

                        <th>No</th>
                        <th>Gambar</th>
                        <th>Judul Buku</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Tahun</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th width="180">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($buku as $item)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>
                            @if($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}"
                                     alt="{{ $item->judul_buku }}"
                                     style="width: 60px; height: 80px; object-fit: cover; border-radius: 6px; border: 1px solid #ddd;">
                            @else
                                <div style="width: 60px; height: 80px; display:flex; align-items:center; justify-content:center; border:1px solid #ddd; border-radius:6px; color:#888; background:#f8f9fa;">
                                    <i class="bi bi-book"></i>
                                </div>
                            @endif
                        </td>

                        <td>{{ $item->judul_buku }}</td>

                        <td>{{ $item->penulis }}</td>

                        <td>{{ $item->penerbit }}</td>

                        <td>{{ $item->tahun }}</td>

                        <td>{{ $item->kategori }}</td>

                        <td>{{ $item->stok }}</td>

                        <td>

                            <a href="{{ route('buku.edit',$item->id_buku) }}"
                               class="btn btn-warning btn-sm">

                                Edit

                            </a>

                            <form action="{{ route('buku.destroy',$item->id_buku) }}"
                                  method="POST"
                                  style="display:inline;">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin menghapus data ini?')">

                                    Hapus

                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="9" class="text-center">

                            Belum ada data buku.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection