@extends('layouts.public')

@section('title', 'Katalog Buku — ' . config('app.name'))
@section('meta_description', 'Jelajahi katalog buku ber-ISBN kami. Cari berdasarkan judul, penulis, atau ISBN dan filter per kategori.')

@section('content')
    <div class="bg-canvas-soft">
        <div class="mx-auto max-w-7xl px-6 py-16">
            <p class="eyebrow mb-3">Katalog</p>
            <h1 class="font-display text-4xl font-medium text-ink sm:text-5xl">Katalog Buku</h1>
            <p class="mt-3 max-w-xl text-lg text-body">Temukan buku terbitan kami — cari dan saring sesuai kebutuhan.</p>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-6 py-12">
        @livewire('book-catalog')
    </div>
@endsection
