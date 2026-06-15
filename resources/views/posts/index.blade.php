@extends('layouts.public')

@section('title', 'Berita & Artikel — ' . config('app.name'))
@section('meta_description', 'Berita, pengumuman, dan artikel terbaru dari penerbit.')

@section('content')
    <div class="bg-canvas-soft">
        <div class="mx-auto max-w-7xl px-6 py-16">
            <p class="eyebrow mb-3">Kabar Terbaru</p>
            <h1 class="font-display text-4xl font-medium text-ink sm:text-5xl">Berita &amp; Artikel</h1>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-6 py-16">
        @if ($posts->isEmpty())
            <p class="rounded-xl bg-canvas-soft p-12 text-center text-body-mid">Belum ada artikel.</p>
        @else
            <div class="grid gap-6 md:grid-cols-3">
                @foreach ($posts as $post)
                    <x-post-card :post="$post" />
                @endforeach
            </div>

            <div class="mt-10">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
@endsection
