@extends('layouts.public')

@section('title', 'Kontak — ' . config('app.name'))

@section('content')
    <div class="bg-canvas-soft">
        <div class="mx-auto max-w-7xl px-6 py-16">
            <p class="eyebrow mb-3">Kontak</p>
            <h1 class="font-display text-4xl font-medium text-ink sm:text-5xl">Kami senang mendengar dari Anda</h1>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-6 py-16 grid gap-12 md:grid-cols-2">
        <div>
            <h2 class="font-display text-xl font-semibold text-ink mb-5">Informasi Kontak</h2>
            <ul class="space-y-4 text-body">
                @if ($settings->contact_address)
                    <li class="flex gap-3"><span class="text-primary font-bold">→</span><span>{{ $settings->contact_address }}</span></li>
                @endif
                @if ($settings->contact_email)
                    <li class="flex gap-3"><span class="text-primary font-bold">→</span><a href="mailto:{{ $settings->contact_email }}" class="hover:text-primary">{{ $settings->contact_email }}</a></li>
                @endif
                @if ($settings->contact_phone)
                    <li class="flex gap-3"><span class="text-primary font-bold">→</span><span>{{ $settings->contact_phone }}</span></li>
                @endif
            </ul>

            @if ($settings->whatsapp_number)
                <a href="https://wa.me/{{ preg_replace('/\D+/', '', $settings->whatsapp_number) }}" target="_blank" rel="noopener" class="mt-8 btn-secondary">
                    Chat via WhatsApp
                </a>
            @endif
        </div>

        <div class="rounded-xl bg-canvas-soft p-6 sm:p-8">
            <h2 class="font-display text-xl font-semibold text-ink mb-5">Kirim Pesan</h2>
            @livewire('contact-form')
        </div>
    </div>
@endsection
