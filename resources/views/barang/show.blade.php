@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detail Barang Hilang</h2>

    <div class="card mb-3">
        @if ($barang->gambar)
            <img src="{{ asset('storage/' . $barang->gambar) }}" class="card-img-top" style="max-height: 300px; object-fit: cover;" alt="gambar">
        @endif
        <div class="card-body">
            <h5 class="card-title">{{ $barang->nama }}</h5>
            <p class="card-text"><strong>Deskripsi:</strong> {{ $barang->deskripsi }}</p>
            <p class="card-text"><strong>Lokasi Kehilangan:</strong> {{ $barang->lokasi }}</p>
            <p class="card-text"><strong>Status:</strong> 
                <span class="badge bg-{{ $barang->status === 'hilang' ? 'danger' : 'success' }}">
                    {{ ucfirst($barang->status) }}
                </span>
            </p>
            <!-- Tambahan di bawah informasi barang -->
            <p><strong>Pelapor:</strong> {{ $barang->user->name }}</p>
            <p><strong>Kontak Pelapor:</strong>
                @if ($barang->kontak)
                    {{ $barang->kontak }}
                @else
                    <em>Belum tersedia</em>
                @endif
            </p>
            <p><strong>Email Pelapor:</strong> <a href="mailto:{{ $barang->user->email }}">{{ $barang->user->email }}</a></p>
            <p class="card-text"><small class="text-muted">Dilaporkan pada {{ $barang->created_at->format('d M Y') }}</small></p>
        </div>
    </div>

    <a href="{{ route('barang.index') }}" class="btn btn-secondary">← Kembali</a>
</div>
@endsection
