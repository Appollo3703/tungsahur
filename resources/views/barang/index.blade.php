@extends('layouts.app')

@section('content')
<div class="container py-4"> {{-- Tambahkan padding atas dan bawah --}}
    <h2 class="mb-4 fw-bold">Daftar Barang Hilang</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Filter Search dan Status --}}
    <form method="GET" action="{{ route('barang.index') }}" class="row mb-4 g-3 align-items-center justify-content-start"> {{-- mb-4 untuk jarak, g-3 untuk gap, justify-content-start --}}
        <div class="col-12 col-md-5"> {{-- Ukuran kolom disesuaikan --}}
            <input type="text" name="search" class="form-control form-control-lg" placeholder="Cari barang atau lokasi..." value="{{ request('search') }}">
        </div>
        <div class="col-12 col-md-3"> {{-- Ukuran kolom disesuaikan --}}
            <select name="status" class="form-select form-select-lg">
                <option value="">Semua Status</option>
                <option value="hilang" {{ request('status') == 'hilang' ? 'selected' : '' }}>Hilang</option>
                <option value="ditemukan" {{ request('status') == 'ditemukan' ? 'selected' : '' }}>Ditemukan</option>
            </select>
        </div>
        <div class="col-12 col-md-2"> {{-- Ukuran kolom disesuaikan --}}
            <button class="btn btn-secondary btn-lg w-100">Filter</button>
        </div>
        @auth
            <div class="col-12 col-md-2 d-flex justify-content-md-end"> {{-- Untuk menempatkan tombol di kanan --}}
                <a href="{{ route('barang.create') }}" class="btn btn-primary btn-lg w-100">Laporkan Barang</a>
            </div>
        @endauth
    </form>

    {{-- Daftar Barang dalam format Card Grid --}}
    @if ($barangs->isEmpty())
        <div class="alert alert-info text-center py-4 mt-5">
            <h4 class="alert-heading">Belum ada barang dilaporkan!</h4>
            <p>Silakan laporkan barang yang Anda temukan atau yang hilang.</p>
            @auth
                <a href="{{ route('barang.create') }}" class="btn btn-primary mt-3">Laporkan Sekarang</a>
            @endauth
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mt-3"> {{-- Grid untuk card, g-4 untuk gap antar card --}}
            @foreach ($barangs as $barang)
            <div class="col">
                <div class="card h-100 shadow-sm border-0"> {{-- h-100 agar tinggi card sama, shadow-sm untuk bayangan, border-0 untuk tanpa border --}}
                    @if($barang->gambar)
                        <a href="{{ route('barang.show', $barang->id) }}">
                        <img src="{{ asset('storage/' . $barang->gambar) }}" class="card-img-top object-fit-cover" alt="{{ $barang->nama }}" style="height: 220px;"> {{-- object-fit-cover untuk gambar agar tidak distretch --}}
                        </a>
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 220px;">
                            <span class="text-muted small">Tidak ada gambar</span>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <span class="badge bg-{{ $barang->status === 'hilang' ? 'danger' : 'success' }} text-uppercase mb-2 align-self-start">
                            {{ ucfirst($barang->status) }}
                        </span>
                        <h5 class="card-title fw-bold text-truncate">{{ $barang->nama }}</h5> {{-- text-truncate agar judul tidak terlalu panjang --}}
                        <p class="card-text text-muted small mb-2"><i class="bi bi-geo-alt-fill me-1"></i> {{ $barang->lokasi }}</p> {{-- bi-geo-alt-fill untuk ikon lokasi --}}
                        <p class="card-text small mb-3 flex-grow-1">{{ Str::limit($barang->deskripsi, 100) }}</p> {{-- flex-grow-1 agar deskripsi mengambil ruang yang tersedia --}}
                        <div class="d-flex flex-wrap gap-2 mt-auto"> {{-- mt-auto untuk menempelkan tombol ke bawah card --}}
                            <a href="{{ route('barang.show', $barang->id) }}" class="btn btn-info btn-sm text-white">Lihat Detail</a>

                            @if ($barang->kontak)
                                @php
                                    $kontak = preg_replace('/\D/', '', $barang->kontak); // Hapus non-digit
                                    $isWhatsapp = preg_match('/^(08|62)/', $kontak); // Cek apakah format WA
                                    if (str_starts_with($kontak, '08')) {
                                        $kontak = '62' . substr($kontak, 1); // Ubah 08 menjadi 628
                                    }
                                @endphp
                                @if ($isWhatsapp)
                                    <a href="https://wa.me/{{ $kontak }}" target="_blank" class="btn btn-success btn-sm">
                                        <i class="bi bi-whatsapp me-1"></i> Kontak WA
                                    </a>
                                @else
                                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="{{ $barang->kontak }}" title="Info Kontak">
                                        <i class="bi bi-person-lines-fill me-1"></i> Kontak
                                    </button>
                                @endif
                            @endif

                            @auth
                                @if (auth()->id() === $barang->user_id)
                                    <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus barang ini?')">Hapus</button>
                                    </form>
                                    <form action="{{ route('barang.ubahStatus', $barang->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-secondary btn-sm" onclick="return confirm('Yakin ingin ubah status barang ini?')">
                                            Ubah Status
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top-0 pt-0 pb-3"> {{-- pt-0 pb-3 untuk padding bawah --}}
                        <small class="text-muted">Dilaporkan pada {{ $barang->created_at->format('d M Y') }}</small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-5 d-flex justify-content-center"> {{-- Margin atas dan rata tengah --}}
            {{ $barangs->links() }}
        </div>
    @endif
</div>

{{-- Script untuk mengaktifkan Popover --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        })
    });
</script>
@endpush
@endsection