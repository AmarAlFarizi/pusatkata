@extends('layouts.public')

@section('title', $book->title . ' — ' . config('app.name'))
@section('meta_description', Str::limit(strip_tags($book->synopsis ?? ''), 150))

@section('content')
    @php $buyUrl = $book->buyUrl($settings->whatsapp_number); @endphp

    <div class="mx-auto max-w-7xl px-6 py-12">
        <nav class="mb-8 text-sm text-body-mid">
            <a href="{{ route('catalog.index') }}" class="hover:text-primary">Katalog</a>
            <span class="mx-2">/</span>
            <span class="text-ink">{{ $book->title }}</span>
        </nav>

        <div class="grid gap-12 md:grid-cols-[340px_1fr]">
            <div>
                <div class="rounded-xl bg-canvas-soft p-6 flex items-center justify-center">
                    @if ($book->cover)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($book->cover) }}" alt="Sampul {{ $book->title }}" class="max-h-[480px] w-auto max-w-full rounded-md object-contain shadow-lg ring-1 ring-black/5">
                    @else
                        <div class="flex aspect-[3/4] w-full items-center justify-center rounded-md bg-canvas text-5xl text-mute">Buku</div>
                    @endif
                </div>
            </div>

            <div>
                @if ($book->category)
                    <a href="{{ route('catalog.index', ['kategori' => $book->category->slug]) }}" class="eyebrow">{{ $book->category->name }}</a>
                @endif
                <h1 class="mt-2 font-display text-3xl font-medium text-ink sm:text-4xl">{{ $book->title }}</h1>
                <p class="mt-2 text-lg text-body">oleh {{ $book->author }}</p>

                <dl class="mt-8 grid grid-cols-2 gap-5 text-sm sm:max-w-md">
                    <div>
                        <dt class="text-body-mid">Status ISBN</dt>
                        <dd class="mt-0.5 font-semibold text-ink">{{ $book->isbn_status->label() }}</dd>
                    </div>
                    @if ($book->isPublished() && $book->isbn_number)
                        <div>
                            <dt class="text-body-mid">Nomor ISBN</dt>
                            <dd class="mt-0.5 font-semibold text-ink">{{ $book->isbn_number }}</dd>
                        </div>
                    @endif
                    @if ($book->year)
                        <div>
                            <dt class="text-body-mid">Tahun Terbit</dt>
                            <dd class="mt-0.5 font-semibold text-ink">{{ $book->year }}</dd>
                        </div>
                    @endif
                    @if ($book->pages)
                        <div>
                            <dt class="text-body-mid">Jumlah Halaman</dt>
                            <dd class="mt-0.5 font-semibold text-ink">{{ $book->pages }} halaman</dd>
                        </div>
                    @endif
                </dl>

                @if ($book->price)
                    <div class="mt-8">
                        <span class="font-display text-3xl font-medium text-ink">Rp {{ number_format($book->price, 0, ',', '.') }}</span>
                    </div>
                @endif

                <div class="mt-6">
                    @if ($buyUrl)
                        <a href="{{ $buyUrl }}" target="_blank" rel="noopener" class="btn-primary">
                            {{ $book->buysViaMarketplace() ? 'Beli di Marketplace' : 'Tanya / Beli via WhatsApp' }}
                        </a>
                    @else
                        <p class="text-body-mid">Hubungi kami untuk informasi pembelian.</p>
                    @endif
                </div>

                @if ($book->synopsis)
                    <div class="mt-10">
                        <h2 class="font-display text-xl font-semibold text-ink">Sinopsis</h2>
                        <p class="mt-3 whitespace-pre-line leading-relaxed text-body">{{ $book->synopsis }}</p>
                    </div>
                @endif
            </div>
        </div>

        @if ($relatedBooks->isNotEmpty())
            <section class="mt-20">
                <h2 class="mb-8 font-display text-2xl font-medium text-ink">Buku Lainnya</h2>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($relatedBooks as $related)
                        <x-book-card :book="$related" />
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection
