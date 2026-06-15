@extends('layouts.public')

@section('title', config('app.name') . ' — Penerbit Buku ber-ISBN')

@section('content')
    {{-- ───────── Hero ───────── --}}
    <section class="relative overflow-hidden bg-canvas">
        <div class="absolute inset-0 dot-grid opacity-60"></div>
        <div class="absolute -top-32 right-0 h-72 w-[42rem] rounded-full bg-primary/10 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-6 py-16 lg:py-24 grid items-center gap-12 lg:grid-cols-2">
            <div class="text-center lg:text-left">
                <span class="animate-rise d-1 badge-pill ring-1 ring-ink/10">Penerbit buku ber-ISBN</span>

                <h1 class="animate-rise d-2 mt-6 font-display text-4xl font-medium leading-[1.05] text-ink sm:text-5xl lg:text-[60px]">
                    {{ $settings->hero_title ?: 'Menerbitkan karya, satu naskah satu cerita' }}
                </h1>

                <p class="animate-rise d-3 mx-auto mt-6 max-w-xl text-lg text-body lg:mx-0 lg:text-xl">
                    {{ $settings->hero_subtitle ?: 'Dari naskah hingga buku ber-ISBN di tangan pembaca. Jelajahi katalog kami atau terbitkan karya Anda bersama kami.' }}
                </p>

                <div class="animate-rise d-4 mt-8 flex flex-wrap justify-center gap-3 lg:justify-start">
                    <a href="{{ route('catalog.index') }}" class="btn-primary">Lihat Katalog</a>
                    <a href="{{ route('services') }}" class="btn-tertiary">Terbitkan Buku</a>
                </div>
            </div>

            {{-- Interactive image accordion (Alpine) --}}
            <div class="animate-rise d-5">
                @if ($featuredBooks->isNotEmpty())
                    <x-hero-accordion :books="$featuredBooks" />
                @else
                    <div class="flex h-[400px] items-center justify-center rounded-xl bg-canvas-soft dot-grid">
                        <span class="font-display text-5xl text-ink/15">Katalog</span>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ───────── Marquee ───────── --}}
    <div class="border-y border-ink/10">
        <x-marquee :items="['Penerbit Buku ber-ISBN', 'Penyuntingan Profesional', 'Desain Sampul', 'Cetak Berkualitas', 'Distribusi Luas']"
                   direction="left" duration="34s"
                   class="bg-ink py-4 text-on-primary" />
        <x-marquee :items="['ISBN Resmi', 'Naskah Menjadi Buku', 'Pendampingan Penuh', 'Karya Anda Prioritas Kami']"
                   direction="right" duration="28s"
                   class="bg-primary py-4 text-on-primary" />
    </div>

    {{-- ───────── Galeri Buku (carousel) ───────── --}}
    @if ($galleryBooks->isNotEmpty())
        <div class="bg-canvas">
            <x-book-gallery :books="$galleryBooks" />
        </div>
    @endif

    {{-- ───────── Intro ───────── --}}
    <section class="bg-canvas-soft">
        <div class="mx-auto max-w-3xl px-6 py-24 text-center" data-reveal>
            <p class="eyebrow mb-4"></p>
            <p class="font-display text-2xl font-medium leading-relaxed text-ink sm:text-3xl">
                Kami percaya setiap gagasan layak menjadi buku. Sebagai penerbit ber-ISBN, kami mendampingi penulis dari naskah mentah hingga karya yang rapi, sah, dan siap dibaca.
            </p>
        </div>
    </section>

    {{-- ───────── Alur Penerbitan (sticky tabs) ───────── --}}
    <x-publishing-flow />

    {{-- ───────── Stats ───────── --}}
    <section class="bg-ink text-on-primary">
        <div class="mx-auto max-w-6xl px-6 py-20 grid gap-10 sm:grid-cols-3" data-reveal>
            @foreach ([
                ['value' => $stats['published'], 'label' => 'Buku ber-ISBN terbit'],
                ['value' => $stats['titles'], 'label' => 'Total judul di katalog'],
                ['value' => $stats['categories'], 'label' => 'Kategori buku'],
            ] as $i => $stat)
                <div class="text-center sm:text-left" style="--reveal-delay: {{ $i * 100 }}ms">
                    <div class="font-display text-6xl font-medium text-on-primary">{{ $stat['value'] }}</div>
                    <p class="mt-2 text-mute">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ───────── Keunggulan (accordion + preview) ───────── --}}
    <x-why-us-accordion />

    {{-- ───────── Testimoni (stagger) ───────── --}}
    <section class="bg-canvas">
        <div class="mx-auto max-w-6xl px-6 pt-24">
            <div class="mb-6 text-center" data-reveal>
                <p class="eyebrow mb-3">Testimoni</p>
                <h2 class="font-display text-3xl font-medium text-ink sm:text-4xl">Kata mereka tentang kami</h2>
            </div>
        </div>
        <div class="pb-12" data-reveal>
            <x-stagger-testimonials />
        </div>
    </section>

    {{-- ───────── Berita ───────── --}}
    @if ($latestPosts->isNotEmpty())
        <section class="bg-canvas-soft">
            <div class="mx-auto max-w-6xl px-6 py-24">
                <div class="mb-12 flex flex-wrap items-end justify-between gap-4" data-reveal>
                    <div>
                        <p class="eyebrow mb-3">Kabar Terbaru</p>
                        <h2 class="font-display text-3xl font-medium text-ink sm:text-4xl">Berita &amp; Artikel</h2>
                    </div>
                    <a href="{{ route('posts.index') }}" class="btn-text">Semua berita &rarr;</a>
                </div>
                <div class="grid gap-6 md:grid-cols-3" data-reveal>
                    @foreach ($latestPosts as $post)
                        <x-post-card :post="$post" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ───────── FAQ ───────── --}}
    <x-faq-section />
    
    {{-- ───────── CTA + Form ───────── --}}
    <section class="bg-canvas">
        <div class="mx-auto max-w-6xl px-6 py-24 grid gap-10 lg:grid-cols-2 lg:items-center">
            <div data-reveal>
                <p class="eyebrow mb-4">Mulai Sekarang</p>
                <h2 class="font-display text-3xl font-medium leading-tight text-ink sm:text-4xl">Punya naskah atau pertanyaan? Mari bicara.</h2>
                <p class="mt-4 text-lg text-body">Ceritakan rencana buku Anda. Tim kami akan membantu dari konsultasi awal hingga buku terbit ber-ISBN.</p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('services') }}" class="btn-secondary">Lihat Layanan</a>
                    @if ($settings->whatsapp_number)
                        <a href="https://wa.me/{{ preg_replace('/\D+/', '', $settings->whatsapp_number) }}" target="_blank" rel="noopener" class="btn-tertiary">Chat WhatsApp</a>
                    @endif
                </div>
            </div>
            <div data-reveal style="--reveal-delay: 120ms" class="rounded-xl bg-canvas-soft p-6 sm:p-8">
                @livewire('contact-form')
            </div>
        </div>
    </section>

    
@endsection
