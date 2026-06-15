@extends('layouts.public')

@section('title', 'Layanan Penerbitan — ' . config('app.name'))
@section('meta_description', 'Layanan penerbitan buku ber-ISBN untuk penulis dan institusi.')

@section('content')
    <div class="bg-canvas-soft">
        <div class="mx-auto max-w-4xl px-6 py-16">
            <p class="eyebrow mb-3">Layanan</p>
            <h1 class="font-display text-4xl font-medium text-ink sm:text-5xl">Layanan Penerbitan</h1>
        </div>
    </div>

    <div class="mx-auto max-w-3xl px-6 py-16">
        @if ($settings->services_content)
            <div class="prose-content max-w-none">
                {!! $settings->services_content !!}
            </div>
        @else
            <p class="text-body-mid">Konten layanan belum tersedia.</p>
        @endif

        <div class="mt-12 rounded-xl bg-ink px-8 py-12 text-center text-on-primary">
            <h2 class="font-display text-2xl font-medium text-on-primary">Tertarik menerbitkan buku Anda?</h2>
            <p class="mt-2 text-mute">Hubungi kami untuk konsultasi tanpa biaya.</p>
            <a href="{{ route('contact') }}" class="mt-6 btn-primary">Hubungi Kami</a>
        </div>
    </div>
@endsection
