@extends('layouts.app')

@section('content')
<div class="text-center">
    <h1 class="mb-4">Selamat Datang di Ayo Temukan</h1>
    <p class="lead">Temukan atau laporkan barang hilang di area kampus Anda</p>
    <a href="{{ route('barang.index') }}" class="btn btn-primary mt-3">Lihat Barang Hilang</a>
</div>
@endsection
