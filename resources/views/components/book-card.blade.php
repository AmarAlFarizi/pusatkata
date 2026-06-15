@props(['book'])

<a href="{{ route('catalog.show', $book) }}"
   class="group flex flex-col overflow-hidden rounded-xl bg-canvas ring-1 ring-ink/10 transition hover:ring-ink/25 hover:shadow-lg hover:-translate-y-1">
    <div class="aspect-[3/4] w-full flex items-center justify-center bg-canvas-soft p-5">
        @if ($book->cover)
            <img src="{{ \Illuminate\Support\Facades\Storage::url($book->cover) }}"
                 alt="Sampul {{ $book->title }}"
                 class="max-h-full max-w-full object-contain rounded-sm shadow-md ring-1 ring-black/5 transition group-hover:scale-105">
        @else
            <div class="flex h-full w-full items-center justify-center rounded-sm bg-canvas text-4xl text-mute">Buku</div>
        @endif
    </div>
    <div class="flex flex-1 flex-col p-5">
        @if ($book->category)
            <span class="eyebrow mb-1.5">{{ $book->category->name }}</span>
        @endif
        <h3 class="font-display text-lg font-semibold leading-snug text-ink line-clamp-2">{{ $book->title }}</h3>
        <p class="mt-1 text-sm text-body-mid">{{ $book->author }}</p>
        <div class="mt-auto pt-4 flex items-center justify-between">
            @if ($book->price)
                <span class="font-semibold text-ink">Rp {{ number_format($book->price, 0, ',', '.') }}</span>
            @else
                <span class="text-sm text-body-mid">Hubungi kami</span>
            @endif
            @if ($book->isPublished())
                <span class="badge-pill !bg-primary/10 !text-primary">ISBN Terbit</span>
            @else
                <span class="badge-pill">Pengajuan</span>
            @endif
        </div>
    </div>
</a>
