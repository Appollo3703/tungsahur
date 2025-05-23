@extends('layouts.app')

@section('content')
<div class="bg-primary text-white py-5 text-center" style="background-color: #5A3FFF !important;">
    <div class="container">
        <h1 class="fw-bold display-5">Temukan Barang Anda <br> <span class="text-light">dengan AyoTemukan</span></h1>
        <p class="lead mt-3">Platform lost and found terpercaya di Indonesia. Bantu temukan barang hilang atau laporkan barang yang Anda temukan dengan mudah.</p>
        <div class="mt-4">
            <a href="{{ route('barang.create') }}" class="btn btn-light text-primary fw-semibold me-2">Laporkan Barang Hilang</a>
            <a href="{{ route('barang.create') }}" class="btn btn-dark fw-semibold">Laporkan Barang Ditemukan</a>
        </div>
    </div>
</div>

<!-- Form Pencarian -->
<div class="container mt-n5">
    <div class="bg-white shadow rounded p-4">
        <form action="{{ route('barang.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="search" class="form-label">Kata Kunci</label>
                <input type="text" class="form-control" name="search" placeholder="Contoh: Dompet, Kunci, Handphone...">
            </div>
            <div class="col-md-3">
                <label for="kategori" class="form-label">Kategori</label>
                <select class="form-select" name="kategori">
                    <option value="">Semua Kategori</option>
                    <!-- Tambahkan opsi kategori di sini -->
                </select>
            </div>
            <div class="col-md-3">
                <label for="lokasi" class="form-label">Lokasi</label>
                <select class="form-select" name="lokasi">
                    <option value="">Semua Lokasi</option>
                    <!-- Tambahkan opsi lokasi di sini -->
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Cari</button>
            </div>
        </form>
    </div>
</div>

<!-- Barang Hilang Terbaru -->
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Barang Hilang Terbaru</h4>
        <a href="{{ route('barang.index') }}" class="text-decoration-none">Lihat Semua</a>
    </div>
    <div class="row">
        @foreach ($barangs as $barang)
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm h-100">
                @if($barang->gambar)
                <img src="{{ asset('storage/' . $barang->gambar) }}" class="card-img-top" alt="{{ $barang->nama }}">
                @else
                <div class="card-img-top d-flex align-items-center justify-content-center" style="height: 180px; background-color: #f0f0f0;">
                    <span class="text-muted">Tidak ada gambar</span>
                </div>
                @endif
                <div class="card-body">
                    <span class="badge bg-{{ $barang->status === 'hilang' ? 'danger' : 'success' }} text-uppercase">{{ $barang->status }}</span>
                    <h5 class="card-title mt-2">{{ $barang->nama }}</h5>
                    <p class="card-text small">{{ Str::limit($barang->deskripsi, 80) }}</p>
                    <p class="text-muted small"><i class="bi bi-geo-alt"></i> {{ $barang->lokasi }}</p>
                    <a href="{{ route('barang.show', $barang) }}" class="text-decoration-none">Lihat Detail</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
