@extends('layouts.public')

@section('title', 'Lacak Naskah — ' . config('app.name'))
@section('meta_description', 'Lacak tahap produksi naskah buku Anda berdasarkan judul, seperti cek resi.')

@section('content')
    <div class="bg-canvas-soft">
        <div class="mx-auto max-w-3xl px-6 py-16 text-center">
            <p class="eyebrow mb-3">Lacak Naskah</p>
            <h1 class="font-display text-4xl font-medium text-ink sm:text-5xl">Cek tahap naskah Anda</h1>
            <p class="mt-3 text-lg text-body">Masukkan judul naskah untuk melihat sudah sampai tahap mana proses penerbitannya.</p>
        </div>
    </div>

    <div class="mx-auto max-w-3xl px-6 py-12">
        @livewire('book-tracker')
    </div>
@endsection
