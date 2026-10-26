@props(['book'])

@php
    $category = mb_strtolower((string) ($book->kategori ?? ''));
    $theme = match (true) {
        str_contains($category, 'sains'),
        str_contains($category, 'ipa'),
        str_contains($category, 'teknologi'),
        str_contains($category, 'komputer'),
        str_contains($category, 'matematika') => 'science',
        str_contains($category, 'sejarah'),
        str_contains($category, 'biografi'),
        str_contains($category, 'geografi') => 'history',
        str_contains($category, 'novel'),
        str_contains($category, 'sastra'),
        str_contains($category, 'cerita'),
        str_contains($category, 'fiksi'),
        str_contains($category, 'komik') => 'literature',
        str_contains($category, 'agama'),
        str_contains($category, 'religi'),
        str_contains($category, 'islam') => 'religion',
        default => 'general',
    };
    $themeLabel = [
        'science' => 'Pengetahuan',
        'history' => 'Sejarah',
        'literature' => 'Sastra',
        'religion' => 'Religi',
        'general' => 'Bacaan Umum',
    ][$theme];
@endphp

@if($book->gambar)
    <img {{ $attributes->class(['book-cover', 'book-cover-image']) }}
         src="{{ asset('storage/' . $book->gambar) }}"
         alt="Sampul buku {{ $book->judul_buku }}">
@else
<div {{ $attributes->class(['book-cover', 'book-cover-art', 'book-cover-art--' . $theme]) }}
     role="img"
     aria-label="Sampul ilustrasi {{ $book->judul_buku }}">
    <span class="book-cover-art__category">{{ $themeLabel }}</span>
    <span class="book-cover-art__title">{{ $book->judul_buku }}</span>
    <svg class="book-cover-art__icon" viewBox="0 0 96 72" fill="none" aria-hidden="true">
        <path d="M48 18c-9-8-22-10-37-7v43c15-3 28-1 37 7V18Z" stroke="currentColor" stroke-width="3" stroke-linejoin="round"/>
        <path d="M48 18c9-8 22-10 37-7v43c-15-3-28-1-37 7V18Z" stroke="currentColor" stroke-width="3" stroke-linejoin="round"/>
        <path d="M18 23c10-1 18 1 24 5M18 34c10-1 18 1 24 5M78 23c-10-1-18 1-24 5M78 34c-10-1-18 1-24 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" opacity=".75"/>
    </svg>
    <span class="book-cover-art__footer">
        <span>{{ $book->penulis ?: 'Koleksi perpustakaan' }}</span>
        <span>{{ $book->tahun ?: 'EDISI' }}</span>
    </span>
</div>
@endif
