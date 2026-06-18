@extends('layouts.public')

@section('title', 'Akses Ditolak — ' . config('app.name'))
@section('meta_description', 'Anda tidak memiliki akses ke halaman ini.')

@section('content')
    @include('partials.error-body', [
        'code' => '403',
        'badge' => 'Akses ditolak',
        'heading' => 'Maaf, halaman ini tidak bisa diakses',
        'message' => 'Anda tidak memiliki izin untuk membuka halaman ini. Jika ini sebuah kekeliruan, silakan hubungi kami.',
    ])
@endsection
