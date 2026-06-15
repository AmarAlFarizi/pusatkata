@extends('layouts.public')

@section('title', $post->title . ' — ' . config('app.name'))
@section('meta_description', Str::limit(strip_tags($post->excerpt ?? $post->body ?? ''), 150))

@section('content')
    <article class="mx-auto max-w-3xl px-6 py-16">
        <nav class="mb-8 text-sm text-body-mid">
            <a href="{{ route('posts.index') }}" class="hover:text-primary">Berita</a>
            <span class="mx-2">/</span>
            <span class="text-ink">{{ Str::limit($post->title, 40) }}</span>
        </nav>

        <p class="eyebrow mb-3">{{ optional($post->published_at)->translatedFormat('d F Y') }}</p>
        <h1 class="font-display text-4xl font-medium leading-tight text-ink">{{ $post->title }}</h1>

        @if ($post->cover)
            <img src="{{ $post->coverUrl() }}" alt="" class="mt-8 w-full rounded-xl object-cover">
        @endif

        <div class="prose-content mt-8 max-w-none">
            {!! $post->body !!}
        </div>

        <div class="mt-12">
            <a href="{{ route('posts.index') }}" class="btn-text">&larr; Kembali ke daftar berita</a>
        </div>
    </article>
@endsection
