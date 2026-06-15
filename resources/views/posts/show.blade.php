@extends('layouts.public')

@section('title', $post->title . ' — ' . config('app.name'))
@section('meta_description', Str::limit(strip_tags($post->excerpt ?? $post->body ?? ''), 150))
@section('og_type', 'article')
@if ($post->cover)
    @section('og_image', \Illuminate\Support\Str::startsWith($post->cover, ['http://', 'https://']) ? $post->cover : url($post->coverUrl()))
@endif

@push('head')
    <script type="application/ld+json">
        {!! json_encode(array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $post->title,
            'image' => $post->coverUrl(),
            'datePublished' => optional($post->published_at)->toIso8601String(),
            'dateModified' => $post->updated_at?->toIso8601String(),
            'description' => Str::limit(strip_tags($post->excerpt ?? $post->body ?? ''), 300) ?: null,
            'inLanguage' => 'id',
            'mainEntityOfPage' => route('posts.show', $post),
            'author' => ['@type' => 'Organization', 'name' => config('app.name')],
            'publisher' => ['@type' => 'Organization', 'name' => config('app.name')],
        ], fn ($v) => $v !== null && $v !== ''), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
@endpush

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
