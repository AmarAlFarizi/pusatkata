<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
@php
    $defaultDescription = 'Penerbit buku ber-ISBN. Layanan penerbitan naskah, katalog buku, dan pelacakan proses penerbitan.';
    $ogImage = $settings->logo ? url(\Illuminate\Support\Facades\Storage::url($settings->logo)) : null;
@endphp
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <meta name="description" content="@yield('meta_description', $defaultDescription)">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1">

    {{-- Open Graph --}}
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:locale" content="id_ID">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('title', config('app.name'))">
    <meta property="og:description" content="@yield('meta_description', $defaultDescription)">
    <meta property="og:url" content="{{ url()->current() }}">
    @hasSection('og_image')
        <meta property="og:image" content="@yield('og_image')">
        <meta name="twitter:image" content="@yield('og_image')">
    @elseif ($ogImage)
        <meta property="og:image" content="{{ $ogImage }}">
        <meta name="twitter:image" content="{{ $ogImage }}">
    @endif

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', config('app.name'))">
    <meta name="twitter:description" content="@yield('meta_description', $defaultDescription)">

    @stack('head')

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    {{-- Structured data: Organization --}}
    <script type="application/ld+json">
        {!! json_encode(array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => config('app.name'),
            'url' => url('/'),
            'logo' => $ogImage,
            'description' => $defaultDescription,
            'email' => $settings->contact_email,
            'telephone' => $settings->contact_phone,
            'address' => $settings->contact_address,
            'sameAs' => array_values(array_filter([
                $settings->social_instagram,
                $settings->social_facebook,
                $settings->social_twitter,
            ])),
        ]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
</head>
<body class="min-h-screen bg-canvas text-body antialiased flex flex-col">
    <header class="sticky top-0 z-40 border-b border-ink/10 bg-canvas">
        <div x-data="{ mobile: false }" class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-6 py-3">

            {{-- Left: logo + nav --}}
            <div class="flex items-center gap-6">
                <a href="{{ route('home') }}" class="flex shrink-0 items-center gap-2 font-display text-xl font-semibold text-ink">
                    @if ($settings->logo)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($settings->logo) }}" alt="{{ config('app.name') }}" class="h-9 w-auto">
                    @else
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-primary text-on-primary text-sm font-bold">P</span>
                        <span>{{ config('app.name') }}</span>
                    @endif
                </a>

                @php $jelajahActive = request()->routeIs('services') || request()->routeIs('posts.*') || request()->routeIs('about'); @endphp
                <nav class="hidden items-center gap-1 md:flex">
                    @foreach (['home' => 'Beranda', 'catalog.index' => 'Katalog', 'track' => 'Lacak Naskah'] as $routeName => $label)
                        <a href="{{ route($routeName) }}"
                           @class([
                               'rounded-lg px-3 py-2 text-sm font-medium transition',
                               'text-primary' => request()->routeIs($routeName),
                               'text-ink hover:bg-canvas-soft' => ! request()->routeIs($routeName),
                           ])>{{ $label }}</a>
                    @endforeach

                    {{-- Mega menu "Jelajahi" --}}
                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button type="button" @click="open = !open"
                                @class([
                                    'flex items-center gap-1 rounded-lg px-3 py-2 text-sm font-medium transition',
                                    'text-primary' => $jelajahActive,
                                    'text-ink hover:bg-canvas-soft' => ! $jelajahActive,
                                ])>
                            Jelajahi
                            <svg class="h-3.5 w-3.5 transition-transform" :class="open ? 'rotate-180' : ''" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                        </button>

                        <div x-show="open" x-cloak x-transition class="absolute left-0 top-full pt-3">
                            <div class="grid w-[560px] gap-3 rounded-2xl bg-canvas p-4 shadow-xl ring-1 ring-ink/10 lg:grid-cols-[0.85fr_1fr]">
                                {{-- Featured --}}
                                <a href="{{ route('services') }}" class="relative flex flex-col justify-end overflow-hidden rounded-xl bg-ink p-5 text-on-primary">
                                    <div class="absolute inset-0 dot-grid opacity-15"></div>
                                    <div class="relative">
                                        <span class="eyebrow mb-2 block">Layanan</span>
                                        <p class="font-display text-lg font-semibold">Terbitkan Buku Anda</p>
                                        <p class="mt-1 text-sm text-mute">Dari naskah hingga buku ber-ISBN, kami dampingi.</p>
                                    </div>
                                </a>
                                {{-- List --}}
                                <div class="grid content-start gap-1">
                                    @foreach ([
                                        ['route' => 'posts.index', 'title' => 'Blog', 'desc' => 'Artikel & kabar seputar penerbitan.'],
                                        ['route' => 'about', 'title' => 'Tentang Kami', 'desc' => 'Mengenal profil penerbit.'],
                                    ] as $item)
                                        <a href="{{ route($item['route']) }}" class="block rounded-xl p-3 transition hover:bg-canvas-soft">
                                            <div class="text-sm font-semibold text-ink">{{ $item['title'] }}</div>
                                            <p class="text-sm text-body-mid">{{ $item['desc'] }}</p>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>

            {{-- Right: search + CTA + mobile toggle --}}
            <div class="flex items-center gap-3">
                <form action="{{ route('catalog.index') }}" method="GET" class="relative hidden md:block">
                    <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-body-mid" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    <input type="search" name="q" placeholder="Cari buku..."
                           class="w-40 rounded-lg border border-ink/15 bg-canvas py-2 pl-9 pr-3 text-sm text-ink placeholder:text-body-mid focus:border-ink focus:outline-none lg:w-52">
                </form>

                <a href="{{ route('contact') }}" class="hidden shrink-0 rounded-lg bg-ink px-4 py-2 text-sm font-semibold text-on-primary transition hover:bg-ink-soft sm:inline-flex">Hubungi Kami</a>

                <button @click="mobile = true" class="inline-flex items-center justify-center rounded-lg p-2 text-ink md:hidden" aria-label="Buka menu">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>

            {{-- Mobile sheet --}}
            <div x-show="mobile" x-cloak class="fixed inset-0 z-50 md:hidden">
                <div x-show="mobile" x-transition.opacity @click="mobile = false" class="absolute inset-0 bg-ink/40"></div>
                <div x-show="mobile"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="-translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="-translate-x-full"
                     class="absolute inset-y-0 left-0 w-[280px] bg-canvas px-5 py-6 shadow-xl">
                    <div class="flex items-center justify-between">
                        <span class="font-display text-lg font-semibold text-ink">{{ config('app.name') }}</span>
                        <button @click="mobile = false" class="rounded-lg p-2 text-ink" aria-label="Tutup menu">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form action="{{ route('catalog.index') }}" method="GET" class="relative mt-6">
                        <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-body-mid" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                        <input type="search" name="q" placeholder="Cari buku..." class="w-full rounded-lg border border-ink/15 bg-canvas py-2.5 pl-9 pr-3 text-sm text-ink placeholder:text-body-mid focus:border-ink focus:outline-none">
                    </form>

                    <nav class="mt-6 flex flex-col space-y-1">
                        @foreach (['home' => 'Beranda', 'catalog.index' => 'Katalog', 'track' => 'Lacak Naskah', 'services' => 'Layanan', 'posts.index' => 'Blog', 'about' => 'Tentang'] as $routeName => $label)
                            <a href="{{ route($routeName) }}"
                               @class([
                                   'rounded-lg px-3 py-2.5 text-base font-medium',
                                   'bg-canvas-soft text-primary' => request()->routeIs($routeName),
                                   'text-ink' => ! request()->routeIs($routeName),
                               ])>{{ $label }}</a>
                        @endforeach
                        <a href="{{ route('contact') }}" class="mt-4 rounded-lg bg-ink px-4 py-3 text-center text-base font-semibold text-on-primary">Hubungi Kami</a>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="bg-ink text-canvas-soft mt-24">
        <div class="mx-auto max-w-7xl px-6 py-16 grid gap-10 md:grid-cols-3">
            <div>
                <div class="flex items-center gap-2.5 font-display text-xl font-semibold text-on-primary mb-3">
                    @php $footerLogo = $settings->logo_footer ?: $settings->logo; @endphp
                    @if ($footerLogo)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($footerLogo) }}" alt="{{ config('app.name') }}" class="h-9 w-auto">
                    @else
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-primary text-on-primary text-sm font-bold">P</span>
                        {{ config('app.name') }}
                    @endif
                </div>
                <p class="text-sm text-mute max-w-xs">Penerbit buku ber-ISBN. Menerbitkan karya, menyebarkan gagasan.</p>
            </div>
            <div>
                <div class="eyebrow !text-canvas-soft mb-4">Tautan</div>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="{{ route('catalog.index') }}" class="text-mute hover:text-on-primary transition">Katalog Buku</a></li>
                    <li><a href="{{ route('services') }}" class="text-mute hover:text-on-primary transition">Layanan Penerbitan</a></li>
                    <li><a href="{{ route('posts.index') }}" class="text-mute hover:text-on-primary transition">Blog</a></li>
                    <li><a href="{{ route('about') }}" class="text-mute hover:text-on-primary transition">Tentang Kami</a></li>
                </ul>
            </div>
            <div>
                <div class="eyebrow !text-canvas-soft mb-4">Kontak</div>
                <ul class="space-y-2.5 text-sm text-mute">
                    @if ($settings->contact_address)
                        <li>{{ $settings->contact_address }}</li>
                    @endif
                    @if ($settings->contact_email)
                        <li><a href="mailto:{{ $settings->contact_email }}" class="hover:text-on-primary transition">{{ $settings->contact_email }}</a></li>
                    @endif
                    @if ($settings->contact_phone)
                        <li>{{ $settings->contact_phone }}</li>
                    @endif
                </ul>
                <div class="flex gap-4 mt-4 text-sm">
                    @foreach (['social_instagram' => 'Instagram', 'social_facebook' => 'Facebook', 'social_twitter' => 'Twitter/X'] as $field => $label)
                        @if ($settings->{$field})
                            <a href="{{ $settings->{$field} }}" target="_blank" rel="noopener" class="text-mute hover:text-on-primary transition">{{ $label }}</a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="border-t border-white/10">
            <div class="mx-auto max-w-7xl px-6 py-5 text-sm text-mute">
                &copy; {{ date('Y') }} {{ config('app.name') }}. Semua hak dilindungi.
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
