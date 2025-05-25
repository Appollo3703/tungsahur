@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-lg border-0 mb-4"> {{-- Menggunakan card utama dengan bayangan dan tanpa border --}}
        <div class="card-body p-4 p-md-5"> {{-- Padding lebih besar di desktop --}}
            <div class="row gx-lg-5 align-items-start"> {{-- Menggunakan gx-lg-5 untuk gap besar di layar large --}}
                <div class="col-12 col-lg-7 mb-4 mb-lg-0"> {{-- Kolom untuk gambar --}}
                    @if ($barang->gambar)
                        <img src="{{ asset('storage/' . $barang->gambar) }}" class="img-fluid rounded shadow-sm" alt="{{ $barang->nama }}" style="max-height: 450px; width: 100%; object-fit: contain;"> {{-- img-fluid, rounded, shadow-sm, object-fit-contain --}}
                    @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="min-height: 300px; height: 100%; width: 100%;">
                            <span class="fs-5">Tidak ada gambar</span>
                        </div>
                    @endif
                </div>
                <div class="col-12 col-lg-5"> {{-- Kolom untuk detail barang --}}
                    <h1 class="mb-3 fw-bold">{{ $barang->nama }}</h1>

                    <div class="mb-3">
                        <span class="badge bg-{{ $barang->status === 'hilang' ? 'danger' : 'success' }} text-uppercase fs-6 py-2 px-3 rounded-pill">
                            {{ ucfirst($barang->status) }}
                        </span>
                    </div>

                    <h5 class="mt-4 fw-bold">Deskripsi:</h5>
                    <p class="text-secondary">{{ $barang->deskripsi }}</p>

                    <h5 class="mt-4 fw-bold">Lokasi Kehilangan:</h5>
                    <p class="text-secondary"><i class="bi bi-geo-alt-fill me-2"></i> {{ $barang->lokasi }}</p>

                    <p class="small text-muted mt-4">
                        Dilaporkan pada {{ $barang->created_at->format('d M Y, H:i') }}
                    </p>

                    <hr class="my-4">

                    <h4 class="mb-3 fw-bold">Informasi Pelapor</h4>
                    <ul class="list-unstyled text-secondary">
                        <li class="mb-2">
                            <i class="bi bi-person-fill me-2"></i> <strong>Nama:</strong> {{ $barang->user->name }}
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-envelope-fill me-2"></i> <strong>Email:</strong> <a href="mailto:{{ $barang->user->email }}" class="text-decoration-none">{{ $barang->user->email }}</a>
                        </li>
                        @if ($barang->kontak)
                            <li class="mb-2">
                                <i class="bi bi-phone-fill me-2"></i> <strong>Kontak:</strong>
                                @php
                                    $kontak = preg_replace('/\D/', '', $barang->kontak); // Hapus non-digit
                                    $isWhatsapp = preg_match('/^(08|62)/', $kontak); // Cek apakah format WA
                                    if (str_starts_with($kontak, '08')) {
                                        $kontak = '62' . substr($kontak, 1); // Ubah 08 menjadi 628
                                    }
                                @endphp
                                @if ($isWhatsapp)
                                    <a href="https://wa.me/{{ $kontak }}" target="_blank" class="text-success text-decoration-none">
                                        <i class="bi bi-whatsapp me-1"></i> {{ $barang->kontak }}
                                    </a>
                                @else
                                    {{ $barang->kontak }}
                                @endif
                            </li>
                        @endif
                    </ul>

                    <div class="mt-4">
                        <a href="{{ route('barang.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar Barang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection