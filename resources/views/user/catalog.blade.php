@extends('layouts.user')
@section('title', 'Katalog Buku - Perpustakaan Sekolah')
@section('content')
<div class="page-heading mb-4"><h1>Katalog Buku</h1><p class="mb-0">Temukan bacaan yang ingin kamu jelajahi.</p></div>
<form class="panel p-3 mb-4" method="GET" action="{{ route('user.catalog') }}"><div class="input-group"><span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span><input class="form-control border-start-0" type="search" name="q" value="{{ $search }}" placeholder="Cari judul buku, penulis, atau kategori..."><button class="btn btn-gold px-4" type="submit">Cari Buku</button></div></form>
@if($books->count())
<div class="row g-4">@foreach($books as $book)<div class="col-12 col-sm-6 col-lg-4 col-xl-3"><div class="book-card"><x-book-cover :book="$book" /><div class="p-3"><div class="d-flex justify-content-between gap-2 align-items-start"><h3 class="mb-2">{{ $book->judul_buku }}</h3><span class="badge rounded-pill {{ $book->stok > 0 ? 'badge-available' : 'badge-empty' }}">{{ $book->stok > 0 ? 'Tersedia' : 'Stok Habis' }}</span></div><p class="meta mb-1">{{ $book->penulis }}</p><p class="meta mb-3">{{ $book->kategori ?: 'Umum' }} · {{ $book->stok }} eksemplar</p><div class="d-flex gap-2"><a href="{{ route('user.book.show', $book) }}" class="btn btn-sm btn-outline-navy">Detail</a>@if($book->stok > 0)<form action="{{ route('user.book.borrow', $book) }}" method="POST">@csrf<button class="btn btn-sm btn-gold" type="submit">Pinjam</button></form>@endif</div></div></div></div>@endforeach</div><div class="mt-4">{{ $books->links() }}</div>
@else
<div class="panel empty-state"><i class="bi bi-search"></i><div>Tidak ada buku yang sesuai dengan pencarian.</div><a href="{{ route('user.catalog') }}" class="btn btn-sm btn-outline-navy mt-3">Tampilkan semua buku</a></div>
@endif
@endsection