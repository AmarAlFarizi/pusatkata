@extends('layouts.public')

@section('title', 'Halaman Tidak Ditemukan — ' . config('app.name'))
@section('meta_description', 'Halaman yang Anda cari tidak ditemukan.')

@section('content')
    @include('partials.error-body', [
        'code' => '404',
        'badge' => 'Halaman tidak ditemukan',
        'heading' => 'Sepertinya halaman ini sudah berpindah rak',
        'message' => 'Halaman yang Anda cari tidak ada, sudah dipindahkan, atau tautannya keliru. Mari kembali menelusuri katalog kami.',
    ])
@endsection
