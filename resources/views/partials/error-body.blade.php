@php
    $code = $code ?? '404';
    $badge = $badge ?? 'Halaman tidak ditemukan';
    $heading = $heading ?? 'Sepertinya halaman ini sudah berpindah rak';
    $message = $message ?? 'Halaman yang Anda cari tidak ada atau sudah dipindahkan.';
@endphp

<section class="relative overflow-hidden bg-canvas">
    <div class="absolute inset-0 dot-grid opacity-60"></div>
    <div class="absolute -top-24 left-1/2 h-72 w-[42rem] -translate-x-1/2 rounded-full bg-primary/10 blur-3xl"></div>

    <div class="relative mx-auto flex max-w-3xl flex-col items-center px-6 py-24 text-center lg:py-32">
        <span class="badge-pill ring-1 ring-ink/10">{{ $code }} — {{ $badge }}</span>

        <h1 class="mt-6 font-display text-[5rem] font-medium leading-none text-ink sm:text-[8rem]">
            {{ substr($code, 0, 1) }}<span class="text-primary">{{ substr($code, 1, 1) }}</span>{{ substr($code, 2) }}
        </h1>

        <h2 class="mt-4 font-display text-2xl font-medium text-ink sm:text-3xl">{{ $heading }}</h2>
        <p class="mt-3 max-w-xl text-lg text-body">{{ $message }}</p>

        <div class="mt-8 flex flex-wrap justify-center gap-3">
            <a href="{{ route('home') }}" class="btn-primary">Kembali ke Beranda</a>
            <a href="{{ route('catalog.index') }}" class="btn-tertiary">Lihat Katalog</a>
        </div>

        <form action="{{ route('catalog.index') }}" method="GET" class="mt-8 w-full max-w-md">
            <div class="flex items-center gap-2 rounded-full border border-ink/15 bg-canvas px-4 py-2.5">
                <svg class="h-5 w-5 text-body-mid" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <input type="search" name="q" placeholder="Cari judul buku..." class="w-full bg-transparent text-ink placeholder:text-body-mid focus:outline-none">
                <button type="submit" class="shrink-0 rounded-full bg-ink px-4 py-1.5 text-sm font-semibold text-on-primary transition hover:bg-ink-soft">Cari</button>
            </div>
        </form>

        <div class="mt-10 flex flex-wrap items-center justify-center gap-x-6 gap-y-2 text-sm text-body-mid">
            <span>Tautan cepat:</span>
            <a href="{{ route('services') }}" class="font-medium text-ink hover:text-primary">Layanan</a>
            <a href="{{ route('track') }}" class="font-medium text-ink hover:text-primary">Lacak Naskah</a>
            <a href="{{ route('posts.index') }}" class="font-medium text-ink hover:text-primary">Blog</a>
            <a href="{{ route('contact') }}" class="font-medium text-ink hover:text-primary">Kontak</a>
        </div>
    </div>
</section>
