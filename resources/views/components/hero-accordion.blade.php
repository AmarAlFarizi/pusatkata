@props(['books'])

@php
    // Fallback gambar bertema buku/pustaka (Unsplash) bila cover belum diunggah.
    $fallbacks = [
        'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?q=80&w=1200&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1512820790803-83ca734da794?q=80&w=1200&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?q=80&w=1200&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?q=80&w=1200&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=1200&auto=format&fit=crop',
    ];
    $items = $books->take(5)->values();
    $last = max($items->count() - 1, 0);
@endphp

<div x-data="{ active: {{ $last }} }"
     class="flex w-full items-stretch gap-2 sm:gap-3">
    @foreach ($items as $i => $book)
        @php $img = $book->cover ? \Illuminate\Support\Facades\Storage::url($book->cover) : $fallbacks[$i % count($fallbacks)]; @endphp
        <div @mouseenter="active = {{ $i }}"
             @click="active = {{ $i }}"
             :class="active === {{ $i }} ? 'flex-[6]' : 'flex-[1]'"
             class="group relative h-[400px] min-w-0 sm:h-[440px] cursor-pointer overflow-hidden rounded-xl ring-1 ring-ink/10 transition-all duration-700 ease-in-out">

            <img src="{{ $img }}" alt="Sampul {{ $book->title }}"
                 class="absolute inset-0 h-full w-full object-cover"
                 onerror="this.onerror=null;this.src='https://placehold.co/400x450/201515/fffefb?text=Buku';">

            {{-- Overlay gradien --}}
            <div class="absolute inset-0 bg-gradient-to-t from-ink/80 via-ink/20 to-transparent"></div>

            {{-- Caption: horizontal saat aktif, vertikal (rotate) saat tidak --}}
            <span class="absolute whitespace-nowrap font-display text-base font-semibold text-on-primary transition-all duration-300 ease-in-out sm:text-lg"
                  :class="active === {{ $i }}
                      ? 'bottom-6 left-1/2 -translate-x-1/2 rotate-0'
                      : 'bottom-24 left-1/2 -translate-x-1/2 rotate-90'">
                {{ Str::limit($book->title, 22) }}
            </span>

            {{-- Tautan muncul saat panel aktif --}}
            <a href="{{ route('catalog.show', $book) }}"
               x-show="active === {{ $i }}"
               x-transition.opacity.duration.300ms
               class="absolute bottom-5 right-5 inline-flex items-center gap-1 rounded-full bg-primary px-3 py-1.5 text-xs font-bold text-on-primary shadow-lg">
                Lihat &rarr;
            </a>
        </div>
    @endforeach
</div>
