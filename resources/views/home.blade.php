{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('title', 'Laporan Barang Hilang & Ditemukan Kampus LPKIA')

@section('content')
    {{-- HERO SECTION - V5 (Direvisi agar tidak terlalu kotak) --}}
    <section class="hero-section-v5 position-relative overflow-hidden">
        {{-- Elemen dekoratif baru untuk bentuk dinamis --}}
        <div class="hero-shape-top-left"></div>
        <div class="hero-shape-bottom-right"></div>

        {{-- Elemen dekoratif background halus (dari CSS Anda sebelumnya) --}}
        <div class="hero-v5-bg-decoration-layer1"></div>
        <div class="hero-v5-bg-decoration-layer2"></div>

        <div class="container position-relative" style="z-index: 2;">
            <div class="row align-items-center justify-content-center min-vh-75 py-5 text-center text-lg-start">
                {{-- Kolom Teks --}}
                <div class="col-lg-7 col-md-10 hero-v5-content-col">
                    <h1 class="hero-v5-title mb-3">
                        Kehilangan Sesuatu di <span class="highlight-v5">Kampus</span>? <br class="d-none d-md-block">
                        <span class="highlight-v5">AyoTemukan</span> Siap Membantu!
                    </h1>
                    <p class="hero-v5-subtitle mb-4">
                        Platform komunitas Kampus untuk melaporkan dan menemukan barang hilang. Mudah, cepat, dan
                        menghubungkan Anda kembali dengan barang berharga Anda.
                    </p>
                    <div class="hero-v5-buttons mt-4 pt-2">
                        <a href="{{ route('barang.create') }}"
                            class="btn btn-lg btn-hero-v5-primary shadow-lg me-lg-3 mb-3 mb-lg-0 rounded-pill px-4">
                            <i class="bi bi-send-plus-fill me-2"></i>Laporkan Barang
                        </a>
                        <a href="{{ route('barang.index') }}"
                            class="btn btn-lg btn-hero-v5-secondary shadow-sm rounded-pill px-4">
                            <i class="bi bi-search me-2"></i>Telusuri Laporan
                        </a>
                    </div>
                </div>
                {{-- Kolom Ilustrasi --}}
                <div class="col-lg-5 d-none d-lg-flex justify-content-center align-items-center hero-v5-illustration-col">
                    <img src="{{ asset('images/hero-section.png') }}" alt="Ilustrasi Platform Lost and Found AyoTemukan"
                        class="hero-v5-illustration img-fluid">
                </div>
            </div>
        </div>
        {{-- Indikator scroll bisa dimodifikasi bentuknya atau dihapus jika tidak diinginkan --}}
        <div class="hero-v5-scroll-indicator text-center">
            <a href="#search-form-v2-section-anchor" aria-label="Scroll ke Form Pencarian" class="text-white-50">
                <i class="bi bi-chevron-compact-down fs-1"></i>
            </a>
        </div>

        {{-- Tambahan: Shape Divider di bagian bawah hero section --}}
        <div class="hero-bottom-shape-divider">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path
                    d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"
                    class="shape-fill"></path>
            </svg>
        </div>
    </section>
    {{-- Akhir HERO SECTION --}}


    <section class="search-form-v2-section" id="search-form-v2-section-anchor">
        <div class="container">
            <div class="search-form-v2-card shadow rounded-lg p-4 p-lg-5">
                <form action="{{ route('barang.index') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-lg-4 col-md-12"> {{-- Disesuaikan --}}
                        <label for="search_keywords_home" class="form-label fw-medium mb-1">Cari Barang Apa?</label>
                        <input type="text" class="form-control form-control-lg" name="search" id="search_keywords_home"
                            placeholder="Mis: Kunci Motor, Dompet Coklat, KTM..." value="{{ request('search') }}">
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label for="search_kategori_home" class="form-label fw-medium mb-1">Kategori</label>
                        <select class="form-select form-select-lg" name="kategori" id="search_kategori_home">
                            <option value="" selected>Semua Kategori</option>
                            {{-- Loop Kategori dari Controller atau View Composer --}}
                            @php
                                // Cara cepat, idealnya $kategorisForForm dikirim dari controller route '/'
                                $kategorisForForm = \App\Models\Kategori::orderBy('nama_kategori')->get();
                            @endphp
                            @foreach ($kategorisForForm as $kategori)
                                <option value="{{ $kategori->slug }}"
                                    {{ request('kategori') == $kategori->slug ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-6"> {{-- Disesuaikan --}}
                        <label for="search_status_home" class="form-label fw-medium mb-1">Status</label>
                        <select class="form-select form-select-lg" name="status" id="search_status_home">
                            <option value="" selected>Semua Status</option>
                            <option value="hilang" {{ request('status') == 'hilang' ? 'selected' : '' }}>Barang Hilang
                            </option>
                            <option value="ditemukan" {{ request('status') == 'ditemukan' ? 'selected' : '' }}>Barang
                                Ditemukan</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-12">
                        <button type="submit" class="btn btn-primary btn-lg w-100 search-form-v2-button">
                            <i class="bi bi-search me-1"></i> Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    {{-- Barang Hilang Terbaru (Konten dari file Anda sebelumnya) --}}
    <div class="container mt-5 pt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold section-title">Laporan Barang Terbaru</h2>
            <a href="{{ route('barang.index') }}" class="text-decoration-none fw-medium">Lihat Semua <i
                    class="bi bi-arrow-right-short"></i></a>
        </div>
        <div class="row">
            @if ($barangs->count() > 0)
                @foreach ($barangs as $barang)
                    <div class="col-md-6 col-lg-3 mb-4">
                        <div class="card shadow-sm h-100 item-card">
                            @if ($barang->gambar)
                                <div class="item-card-img-container">
                                    <img src="{{ asset('storage/' . $barang->gambar) }}" class="card-img-top item-card-img"
                                        alt="{{ $barang->nama }}">
                                </div>
                            @else
                                <div class="card-img-top d-flex align-items-center justify-content-center item-card-img-placeholder"
                                    style="height: 180px;">
                                    <i class="bi bi-image-fill text-muted fs-1"></i>
                                </div>
                            @endif
                            <div class="card-body d-flex flex-column">
                                <span
                                    class="badge item-card-status bg-{{ $barang->status === 'hilang' ? 'danger' : 'success' }} text-uppercase mb-2 align-self-start">{{ $barang->status }}</span>
                                <h5 class="card-title item-card-title">{{ Str::limit($barang->nama, 45) }}</h5>
                                <p class="card-text small item-card-description">{{ Str::limit($barang->deskripsi, 80) }}
                                </p>
                                <p class="text-muted small mt-auto item-card-location"><i
                                        class="bi bi-geo-alt-fill me-1"></i> {{ Str::limit($barang->lokasi, 30) }}</p>
                                <a href="{{ route('barang.show', $barang) }}"
                                    class="btn btn-outline-primary btn-sm mt-2 item-card-button">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <p class="text-center text-muted">Belum ada barang yang dilaporkan.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Section "Bagaimana AyoTemukan Bekerja?" --}}
    <section class="how-it-works-section">
        <div class="container">
            <div class="row justify-content-center mb-4 mb-lg-5">
                <div class="col-lg-8 text-center section-header">
                    <h2 class="section-title">Bagaimana AyoTemukan Bekerja?</h2>
                    <p class="section-subtitle">Tiga langkah mudah untuk melaporkan, menemukan, dan menghubungi.</p>
                </div>
            </div>
            <div class="row g-lg-5 g-md-4 g-3 justify-content-center"> {{-- Gutter lebih besar di layar besar --}}
                {{-- Card 1: Laporkan --}}
                <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
                    <div class="card how-it-works-card text-center h-100"> {{-- h-100 untuk tinggi sama --}}
                        <div class="card-icon-top mx-auto">
                            <i class="bi bi-pencil-square"></i>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Laporkan</h5>
                            <p class="card-text flex-grow-1">Laporkan barang yang hilang atau yang kamu temukan dengan
                                mengisi formulir sederhana.</p>
                        </div>
                    </div>
                </div>

                {{-- Card 2: Temukan --}}
                <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
                    <div class="card how-it-works-card text-center h-100">
                        <div class="card-icon-top mx-auto">
                            <i class="bi bi-search"></i>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Temukan</h5>
                            <p class="card-text flex-grow-1">Cari barang yang hilang atau temukan pemilik barang yang kamu
                                temukan.</p>
                        </div>
                    </div>
                </div>

                {{-- Card 3: Hubungi --}}
                <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
                    <div class="card how-it-works-card text-center h-100">
                        <div class="card-icon-top mx-auto">
                            <i class="bi bi-chat-dots-fill"></i>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Hubungi</h5>
                            <p class="card-text flex-grow-1">Hubungi pemilik atau penemu barang melalui kontak yang
                                tersedia di platform.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Akhir Section "Bagaimana AyoTemukan Bekerja?" --}}

    {{-- Call to Action (CTA) Section --}}
    <section class="professional-cta-section">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-9 col-xl-8">
                    {{-- Opsional: Ikon di atas judul --}}
                    <div class="cta-icon-top-professional mb-4">
                        <i class="bi bi-bell-fill"></i>
                    </div>
                    <h2 class="professional-cta-title">
                        Jangan Tunda Lagi, <span class="highlight">AyoTemukan</span> Solusinya!
                    </h2>
                    <p class="professional-cta-subtitle">
                        Baik kamu kehilangan sesuatu atau menemukan barang yang bukan milik kamu, platform ini siap
                        membantu. Bergabunglah untuk menjadi No Reward Hero!
                    </p>
                    <div class="professional-cta-buttons mt-4 pt-3">
                        <a href="{{ route('barang.create') }}"
                            class="btn btn-lg btn-professional-cta-primary shadow me-sm-3 mb-3 mb-sm-0">
                            <i class="bi bi-upload me-2"></i>Buat Laporan
                        </a>
                        <a href="{{ route('barang.index') }}"
                            class="btn btn-lg btn-professional-cta-secondary shadow-sm">
                            <i class="bi bi-card-list me-2"></i>Lihat Semua Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Akhir Call to Action (CTA) Section --}}

@endsection
