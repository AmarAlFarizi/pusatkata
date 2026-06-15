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
    <header x-data="{ open: false }" class="sticky top-0 z-40 bg-canvas/90 backdrop-blur border-b border-ink/10">
        <div class="mx-auto max-w-7xl px-6">
            <div class="flex h-16 items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 font-display text-xl font-semibold text-ink">
                    @if ($settings->logo)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($settings->logo) }}" alt="{{ config('app.name') }}" class="h-9 w-auto">
                    @else
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-primary text-on-primary text-sm font-bold">P</span>
                        {{ config('app.name') }}
                    @endif
                </a>

                <nav class="hidden md:flex items-center gap-1">
                    @foreach ([
                        'home' => 'Beranda',
                        'catalog.index' => 'Katalog',
                        'services' => 'Layanan',
                        'track' => 'Lacak Naskah',
                        'posts.index' => 'Blog',
                        'about' => 'Tentang',
                    ] as $routeName => $label)
                        <a href="{{ route($routeName) }}"
                           @class([
                               'px-3 py-2 rounded-xl text-sm font-medium transition',
                               'text-primary' => request()->routeIs($routeName),
                               'text-ink hover:text-primary' => ! request()->routeIs($routeName),
                           ])>
                            {{ $label }}
                        </a>
                    @endforeach
                    <a href="{{ route('contact') }}" class="ml-3 btn-primary !px-5 !py-2 !text-sm">Hubungi Kami</a>
                </nav>

                <button @click="open = !open" class="md:hidden inline-flex items-center justify-center rounded-xl p-2 text-ink hover:bg-canvas-soft" aria-label="Buka menu">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>

            <nav x-show="open" x-cloak class="md:hidden pb-4 space-y-1">
                @foreach ([
                    'home' => 'Beranda',
                    'catalog.index' => 'Katalog',
                    'services' => 'Layanan',
                    'track' => 'Lacak Naskah',
                    'posts.index' => 'Berita',
                    'about' => 'Tentang',
                    'contact' => 'Kontak',
                ] as $routeName => $label)
                    <a href="{{ route($routeName) }}"
                       @class([
                           'block px-3 py-2 rounded-xl text-sm font-medium',
                           'text-primary bg-canvas-soft' => request()->routeIs($routeName),
                           'text-ink hover:bg-canvas-soft' => ! request()->routeIs($routeName),
                       ])>
                        {{ $label }}
                    </a>
                @endforeach
            </nav>
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
