@extends('layouts.public')

@section('title', 'Tentang Kami — ' . config('app.name'))

@section('content')
    <div class="bg-canvas-soft">
        <div class="mx-auto max-w-4xl px-6 py-16">
            <p class="eyebrow mb-3">Tentang Kami</p>
            <h1 class="font-display text-4xl font-medium text-ink sm:text-5xl">Mengenal penerbit kami</h1>
        </div>
    </div>

    <div class="mx-auto max-w-3xl px-6 py-16">
        @if ($settings->about_content)
            <div class="prose-content max-w-none">
                {!! $settings->about_content !!}
            </div>
        @else
            <p class="text-body-mid">Konten tentang kami belum tersedia.</p>
        @endif
    </div>
@endsection
