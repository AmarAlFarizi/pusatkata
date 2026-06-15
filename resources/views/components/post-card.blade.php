@props(['post'])

<article class="group flex flex-col overflow-hidden rounded-xl bg-canvas ring-1 ring-ink/10 transition hover:ring-ink/25 hover:shadow-lg">
    @if ($post->cover)
        <div class="h-44 w-full overflow-hidden bg-canvas-soft">
            <img src="{{ $post->coverUrl() }}" alt=""
                 class="h-full w-full object-cover transition group-hover:scale-105">
        </div>
    @else
        <div class="h-44 w-full bg-canvas-soft"></div>
    @endif
    <div class="flex flex-1 flex-col p-6">
        <time class="text-sm text-body-mid">{{ optional($post->published_at)->translatedFormat('d F Y') }}</time>
        <h3 class="mt-1.5 font-display text-xl font-semibold leading-snug text-ink line-clamp-2">{{ $post->title }}</h3>
        <p class="mt-2 text-sm leading-relaxed text-body line-clamp-3">{{ $post->excerpt }}</p>
        <a href="{{ route('posts.show', $post) }}" class="mt-auto pt-4 text-sm font-bold text-ink transition hover:text-primary">Baca selengkapnya &rarr;</a>
    </div>
</article>
