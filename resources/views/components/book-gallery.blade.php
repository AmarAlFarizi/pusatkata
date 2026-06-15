@props([
    'books',
    'title' => 'Buku Terbaru',
    'description' => 'Jelajahi judul-judul terbaru dari katalog kami.',
])

<section class="py-20 lg:py-24"
         x-data="{
            canPrev: false,
            canNext: true,
            active: 0,
            update() {
                const el = this.$refs.track;
                this.canPrev = el.scrollLeft > 4;
                this.canNext = el.scrollLeft < (el.scrollWidth - el.clientWidth - 4);
                const card = el.querySelector('[data-card]');
                const step = card ? card.offsetWidth + 20 : el.clientWidth;
                this.active = Math.round(el.scrollLeft / step);
            },
            step() {
                const el = this.$refs.track;
                const card = el.querySelector('[data-card]');
                return card ? card.offsetWidth + 20 : el.clientWidth;
            },
            prev() { this.$refs.track.scrollBy({ left: -this.step(), behavior: 'smooth' }); },
            next() { this.$refs.track.scrollBy({ left: this.step(), behavior: 'smooth' }); },
            goTo(i) { this.$refs.track.scrollTo({ left: this.step() * i, behavior: 'smooth' }); }
         }"
         x-init="$nextTick(() => update())">

    <div class="mx-auto max-w-7xl px-6">
        <div class="mb-10 flex items-end justify-between gap-6 lg:mb-12" data-reveal>
            <div>
                <p class="eyebrow mb-3">Katalog</p>
                <h2 class="font-display text-3xl font-medium text-ink md:text-4xl lg:text-5xl">{{ $title }}</h2>
                <p class="mt-3 max-w-lg text-body">{{ $description }}</p>
            </div>
            <div class="hidden shrink-0 gap-2 md:flex">
                <button @click="prev()" :disabled="!canPrev" aria-label="Sebelumnya"
                        class="flex h-11 w-11 items-center justify-center rounded-full border border-ink/20 text-ink transition hover:bg-ink hover:text-on-primary disabled:opacity-30 disabled:hover:bg-transparent disabled:hover:text-ink">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                </button>
                <button @click="next()" :disabled="!canNext" aria-label="Berikutnya"
                        class="flex h-11 w-11 items-center justify-center rounded-full border border-ink/20 text-ink transition hover:bg-ink hover:text-on-primary disabled:opacity-30 disabled:hover:bg-transparent disabled:hover:text-ink">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Track — padding kiri disamakan dengan max-w-7xl agar lurus dengan section lain --}}
    <div x-ref="track" @scroll.passive="update()"
         class="flex gap-5 overflow-x-auto scroll-smooth pb-2 pr-6 pl-[max(1.5rem,calc(50vw-616px))] [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden">
        @foreach ($books as $i => $book)
            <a href="{{ route('catalog.show', $book) }}" data-card
               class="group relative flex h-[27rem] w-[78vw] max-w-[320px] shrink-0 snap-start flex-col overflow-hidden rounded-xl bg-ink ring-1 ring-ink/10 sm:w-[340px] lg:max-w-[340px]">

                {{-- Cover penuh, tidak terpotong --}}
                <div class="relative flex min-h-0 flex-1 items-center justify-center p-6">
                    <div class="absolute inset-0 dot-grid opacity-10"></div>
                    @if ($book->cover)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($book->cover) }}" alt="Sampul {{ $book->title }}"
                             class="relative max-h-full max-w-full object-contain rounded-sm shadow-xl ring-1 ring-black/20 transition-transform duration-500 group-hover:scale-105">
                    @else
                        <div class="relative flex h-44 w-32 items-center justify-center rounded-sm bg-canvas/10 text-mute ring-1 ring-white/10">
                            <span class="font-display text-sm">Tanpa sampul</span>
                        </div>
                    @endif
                </div>

                {{-- Info --}}
                <div class="p-6 pt-0 text-on-primary">
                    @if ($book->category)
                        <span class="mb-2 inline-flex rounded-full bg-on-primary/15 px-2.5 py-0.5 text-xs font-medium text-on-primary">{{ $book->category->name }}</span>
                    @endif
                    <div class="font-display text-lg font-semibold leading-snug line-clamp-1">{{ $book->title }}</div>
                    <p class="mt-0.5 text-sm text-mute line-clamp-1">{{ $book->author }}</p>
                    <div class="mt-3 flex items-center text-sm font-semibold text-primary">
                        Lihat detail
                        <svg class="ml-2 h-4 w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    {{-- Dots --}}
    <div class="mt-8 flex justify-center gap-2">
        @foreach ($books as $i => $book)
            <button @click="goTo({{ $i }})" aria-label="Ke buku {{ $i + 1 }}"
                    class="h-2 w-2 rounded-full transition-colors"
                    :class="active === {{ $i }} ? 'bg-primary' : 'bg-primary/20'"></button>
        @endforeach
    </div>
</section>
