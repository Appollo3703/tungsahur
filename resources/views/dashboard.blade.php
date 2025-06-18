@extends('layouts.app')

@section('title', 'Dashboard Saya')

@section('content')
    <div class="container py-4 py-lg-5 dashboard-page">

        {{-- Header Dashboard --}}
        <div class="dashboard-header mb-4 mb-lg-5 p-4 p-lg-5 rounded-4 shadow-sm">
            <div class="row align-items-center gy-3">
                <div class="col-lg-7 col-md-6 text-center text-md-start">
                    <h1 class="h2 fw-bolder text-white mb-1">Selamat Datang, {{ $user->name ?? 'Pengguna' }}!</h1>
                    <p class="lead fs-6 text-white-85 mb-0">Ini adalah dasbor pribadi Anda di AyoTemukan. Kelola laporan Anda
                        dan temukan apa yang Anda cari.</p>
                </div>
                <div class="col-lg-5 col-md-6 text-center text-md-end">
                    <div class="btn-toolbar justify-content-center justify-content-md-end dashboard-header-actions"
                        role="toolbar" aria-label="Header actions">
                        <div class="btn-group me-sm-2 mb-2 mb-sm-0" role="group">
                            <a href="{{ route('barang.create') }}?from={{ urlencode(route('dashboard')) }}"
                                class="btn btn-light rounded-pill px-3 py-2 shadow-sm text-nowrap">
                                <i class="bi bi-plus-circle-fill me-1"></i> Laporkan Barang
                            </a>
                        </div>
                        <div class="btn-group" role="group">
                            <a href="{{ route('profile.edit') }}"
                                class="btn btn-outline-light rounded-pill px-3 py-2 shadow-sm text-nowrap">
                                <i class="bi bi-person-circle me-1"></i> Profil Saya
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Ringkasan Statistik (Sama seperti sebelumnya) --}}
        <div class="row g-3 g-lg-4 mb-4 mb-lg-5">
            <div class="col-md-4 col-sm-6">
                <div class="card shadow-sm border-0 rounded-3 h-100">
                    <div class="card-body text-center p-3 p-lg-4 d-flex flex-column justify-content-center">
                        <i class="bi bi-journal-text display-4 text-primary mb-2"></i>
                        <h3 class="card-title fs-1 fw-bolder text-primary mb-0">{{ $totalLaporan ?? 0 }}</h3>
                        <p class="card-text text-muted small mb-0">Total Laporan Dibuat</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="card shadow-sm border-0 rounded-3 h-100">
                    <div class="card-body text-center p-3 p-lg-4 d-flex flex-column justify-content-center">
                        <i class="bi bi-hourglass-split display-4 text-success mb-2"></i>
                        <h3 class="card-title fs-1 fw-bolder text-success mb-0">{{ $totalAktif ?? 0 }}</h3>
                        <p class="card-text text-muted small mb-0">Laporan Aktif</p>
                        <small class="text-black-50 d-block">(Hilang/Ditemukan)</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="card shadow-sm border-0 rounded-3 h-100">
                    <div class="card-body text-center p-3 p-lg-4 d-flex flex-column justify-content-center">
                        <i class="bi bi-patch-check-fill display-4 text-secondary mb-2"></i>
                        <h3 class="card-title fs-1 fw-bolder text-secondary mb-0">{{ $totalSelesai ?? 0 }}</h3>
                        <p class="card-text text-muted small mb-0">Laporan Selesai</p>
                        <small class="text-black-50 d-block">(Sudah Kembali/Diambil)</small>
                    </div>
                </div>
            </div>
        </div>


        {{-- Daftar Laporan Barang Pengguna --}}
        <div class="mb-4">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center mb-3">
                <h3 class="fw-semibold mb-2 mb-sm-0" style="color: var(--app-navbar-bg, #003366);">Laporan Barang Anda</h3>
                @if ($laporanBarangs->total() > 0 && $laporanBarangs->lastItem() > 0)
                    <small class="text-muted">Menampilkan
                        {{ $laporanBarangs->firstItem() }}-{{ $laporanBarangs->lastItem() }} dari
                        {{ $laporanBarangs->total() }} laporan</small>
                @elseif($laporanBarangs->total() > 0)
                    <small class="text-muted">Menampilkan {{ $laporanBarangs->total() }} laporan</small>
                @endif
            </div>

            @if ($laporanBarangs->isEmpty())
                <div class="text-center py-5 bg-light rounded-4 shadow-sm">
                    <i class="bi bi-journal-richtext fs-1 text-muted mb-3 d-block"></i>
                    <p class="text-muted fs-5">Anda belum membuat laporan barang apapun.</p>
                    <a href="{{ route('barang.create') }}?from={{ urlencode(route('dashboard')) }}"
                        class="btn btn-primary rounded-pill px-4 py-2 mt-2">
                        <i class="bi bi-plus-circle-fill me-2"></i>Buat Laporan Pertama Anda
                    </a>
                </div>
            @else
                <div class="list-group list-group-flush shadow-sm rounded-4 overflow-hidden">
                    @foreach ($laporanBarangs as $barang)
                        <div
                            class="list-group-item list-group-item-action p-3 px-lg-4 py-lg-3 @if ($barang->status === 'selesai') item-selesai-dashboard @endif">
                            <div class="row align-items-center g-2">
                                <div class="col-auto dashboard-item-img-col"> {{-- Gambar selalu muncul --}}
                                    @if ($barang->gambar)
                                        <img src="{{ asset('storage/' . $barang->gambar) }}"
                                            alt="{{ Str::limit($barang->nama, 20) }}"
                                            class="img-fluid rounded border dashboard-item-img">
                                    @else
                                        <div
                                            class="bg-light d-flex align-items-center justify-content-center rounded border dashboard-item-img-placeholder">
                                            <i class="bi bi-image text-muted fs-4"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col dashboard-item-content">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h6 class="mb-1 fw-semibold text-truncate">
                                            <a href="{{ route('barang.show', $barang->id) }}"
                                                class="text-decoration-none text-dark stretched-link-custom"
                                                title="{{ $barang->nama }}">{{ $barang->nama }}</a>
                                        </h6>
                                        <span
                                            class="badge rounded-pill fs-08rem ms-2 flex-shrink-0 
                                    @if ($barang->status === 'hilang') bg-danger-soft text-danger-emphasis 
                                    @elseif($barang->status === 'ditemukan') bg-success-soft text-success-emphasis
                                    @else bg-secondary-soft text-secondary-emphasis @endif">
                                            {{ ucfirst($barang->status) }}
                                        </span>
                                    </div>
                                    <small class="text-muted d-block item-meta-info">
                                        <span title="Kategori"><i
                                                class="bi bi-tag-fill me-1 opacity-75"></i>{{ $barang->kategori->nama_kategori ?? 'N/A' }}</span>
                                        <span class="mx-1">|</span>
                                        <span title="Lokasi"><i
                                                class="bi bi-geo-alt-fill me-1 opacity-75"></i>{{ Str::limit($barang->lokasi, 18) }}</span>
                                    </small>
                                    <small class="text-black-50 d-block mt-1 item-meta-info"><i
                                            class="bi bi-clock-history me-1"></i>Dilaporkan
                                        {{ $barang->created_at->diffForHumans() }}</small>
                                </div>
                                {{-- Tombol Aksi (Gaya Segmented Pill) --}}
                                <div class="col-12 col-md-auto mt-2 mt-md-0">
                                    <div class="btn-group btn-group-sm w-100 w-md-auto custom-segmented-pill"
                                        role="group">
                                        {{-- Link Edit dengan parameter from_page untuk redirect --}}
                                        <a href="{{ route('barang.edit', $barang->id) }}?from_page={{ urlencode(Request::fullUrl()) }}"
                                            class="btn btn-outline-primary @if ($barang->status === 'selesai') disabled @endif"
                                            title="Edit Laporan">
                                            <i class="bi bi-pencil-fill"></i> <span class="action-btn-text">Edit</span>
                                        </a>

                                        @if ($barang->status !== 'selesai')
                                            {{-- Tombol Tandai Selesai --}}
                                            <form action="{{ route('barang.tandaiSelesai', $barang->id) }}" method="POST"
                                                class="d-flex">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="source" value="dashboard">
                                                <input type="hidden" name="_redirect_to_after_action"
                                                    value="{{ Request::fullUrl() }}">
                                                <button type="submit" class="btn btn-outline-success w-100"
                                                    onclick="return confirm('Tandai laporan ini sebagai selesai?')"
                                                    title="Tandai Selesai">
                                                    <i class="bi bi-check2-square"></i>
                                                    <span class="action-btn-text">Selesai</span>
                                                </button>
                                            </form>
                                        @else
                                            {{-- Tampilan jika sudah selesai (tombol disabled) --}}
                                            <button type="button" class="btn btn-outline-secondary w-100 disabled"
                                                title="Laporan sudah selesai">
                                                <i class="bi bi-check2-all"></i> <span
                                                    class="action-btn-text">Selesai</span>
                                            </button>
                                        @endif

                                        <button type="button"
                                            class="btn btn-outline-danger @if ($barang->status === 'selesai') disabled @endif"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteBarangModal-dashboard-{{ $barang->id }}"
                                            title="Hapus Laporan">
                                            <i class="bi bi-trash-fill"></i> <span class="action-btn-text">Hapus</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Modal Hapus (Konten Tetap Sama) --}}
                        <div class="modal fade" id="deleteBarangModal-dashboard-{{ $barang->id }}" tabindex="-1"
                            aria-labelledby="deleteBarangModalLabel-dashboard-{{ $barang->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content rounded-4 shadow">
                                    <div class="modal-header border-0 pb-0">
                                        <h5 class="modal-title text-danger-emphasis fw-bold"
                                            id="deleteBarangModalLabel-dashboard-{{ $barang->id }}"><i
                                                class="bi bi-exclamation-triangle-fill me-2"></i>Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body py-4">
                                        Apakah Anda yakin ingin menghapus laporan: <br><strong
                                            class="fs-5 d-block mt-2">"{{ $barang->nama }}"</strong>?
                                    </div>
                                    <div class="modal-footer border-0 pt-0">
                                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                                            data-bs-dismiss="modal">Batal</button>
                                        <form action="{{ route('barang.destroy', $barang->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="source" value="dashboard">
                                            <input type="hidden" name="_redirect_to_after_action"
                                                value="{{ Request::fullUrl() }}">
                                            <button type="submit" class="btn btn-danger rounded-pill px-4">Ya,
                                                Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($laporanBarangs->hasPages())
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $laporanBarangs->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection

@push('styles')
    <style>
        :root {
            --app-primary-color: #003366;
            --app-accent-color: #75A5D1;
            --app-pill-border-radius: 50rem;
            --app-card-border-radius: 0.75rem;
            --app-btn-group-border-color: var(--bs-border-color-translucent, rgba(0, 0, 0, 0.125));
            /* Warna border lebih soft */
        }

        .dashboard-header {
            background: linear-gradient(135deg, var(--app-primary-color) 0%, color-mix(in srgb, var(--app-primary-color) 70%, var(--app-accent-color)) 100%);
        }

        .text-white-85 {
            color: rgba(255, 255, 255, 0.90) !important;
        }

        .fs-08rem {
            font-size: 0.8rem !important;
        }

        /* Warna soft untuk badge status */
        .bg-danger-soft {
            background-color: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.15);
        }

        .text-danger-emphasis {
            color: #931f2c !important;
        }

        .bg-success-soft {
            background-color: rgba(25, 135, 84, 0.1);
            border: 1px solid rgba(25, 135, 84, 0.15);
        }

        .text-success-emphasis {
            color: #0f5132 !important;
        }

        .bg-secondary-soft {
            background-color: rgba(108, 117, 125, 0.1);
            border: 1px solid rgba(108, 117, 125, 0.15);
        }

        .text-secondary-emphasis {
            color: #495057 !important;
        }

        .list-group-item-action {
            transition: background-color 0.15s ease-in-out, transform 0.15s ease-out;
            border-bottom: 1px solid var(--bs-border-color-translucent) !important;
        }

        .list-group-item-action:last-child {
            border-bottom: none !important;
        }

        .list-group-item-action:hover,
        .list-group-item-action:focus {
            background-color: var(--bs-gray-100);
            transform: translateX(2px);
        }

        .stretched-link-custom::after {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 1;
            content: "";
        }

        .dashboard-item-img-col {
            width: 60px;
            flex-shrink: 0;
        }

        .dashboard-item-img,
        .dashboard-item-img-placeholder {
            width: 50px !important;
            height: 50px !important;
            object-fit: cover;
        }

        .dashboard-item-content {
            min-width: 0;
        }

        .item-meta-info {
            font-size: 0.8rem;
        }

        /* Tombol Header Dashboard Responsif */
        .dashboard-header-actions .btn {
            font-size: 0.9rem;
            padding: 0.55rem 1.1rem;
            white-space: nowrap;
            /* Mencegah teks tombol wrap */
        }

        @media (max-width: 575.98px) {

            /* sm breakpoint (smartphone) */
            .dashboard-header .btn-toolbar {
                flex-direction: column;
                align-items: stretch;
            }

            .dashboard-header .btn-toolbar .btn-group {
                width: 100%;
            }

            .dashboard-header .btn-toolbar .btn-group:not(:last-child) {
                margin-bottom: 0.5rem;
                margin-right: 0 !important;
            }
        }


        /* Tombol Aksi di Daftar Laporan (Segmented Pill Style) */
        .custom-segmented-pill {
            border: 1px solid var(--app-btn-group-border-color);
            border-radius: var(--app-pill-border-radius) !important;
            display: inline-flex;
            overflow: hidden;
        }

        .custom-segmented-pill .btn,
        .custom-segmented-pill form>.btn {
            border-radius: 0 !important;
            border: none !important;
            box-shadow: none !important;
            padding: 0.3rem 0.6rem;
            font-size: 0.75rem;
            line-height: 1.4;
            flex-grow: 1;
            position: relative;
            z-index: 2;
        }

        .custom-segmented-pill>*:not(:last-child) {
            /* Berlaku untuk direct children */
            border-right: 1px solid var(--app-btn-group-border-color) !important;
        }

        .custom-segmented-pill .btn-outline-primary {
            color: var(--bs-primary);
        }

        .custom-segmented-pill .btn-outline-primary:hover {
            color: #fff;
            background-color: var(--bs-primary);
        }

        .custom-segmented-pill .btn-outline-secondary {
            color: var(--bs-secondary-text-emphasis);
        }

        .custom-segmented-pill .btn-outline-secondary:hover {
            color: #fff;
            background-color: var(--bs-secondary);
        }

        .custom-segmented-pill .btn-outline-success {
            color: var(--bs-success);
        }

        .custom-segmented-pill .btn-outline-success:hover {
            color: #fff;
            background-color: var(--bs-success);
        }

        .custom-segmented-pill .btn-outline-danger {
            color: var(--bs-danger);
        }

        .custom-segmented-pill .btn-outline-danger:hover {
            color: #fff;
            background-color: var(--bs-danger);
        }

        .item-selesai-dashboard {
            opacity: 0.7;
            background-color: var(--bs-gray-100) !important;
        }

        .item-selesai-dashboard:hover {
            opacity: 0.8;
            background-color: var(--bs-gray-200) !important;
        }

        .item-selesai-dashboard .dashboard-item-img {
            filter: grayscale(70%);
        }

        .item-selesai-dashboard:hover .dashboard-item-img {
            filter: grayscale(50%);
        }

        .rounded-pill {
            border-radius: var(--app-pill-border-radius) !important;
        }

        .btn-primary {
            background-color: var(--app-primary-color) !important;
            border-color: var(--app-primary-color) !important;
        }

        .btn-primary:hover {
            background-color: color-mix(in srgb, var(--app-primary-color) 85%, black) !important;
            border-color: color-mix(in srgb, var(--app-primary-color) 85%, black) !important;
        }

        @media (max-width: 767.98px) {

            /* md breakpoint */
            .custom-segmented-pill {
                /* Tombol aksi di list item */
                width: 100%;
                display: flex;
            }

            .custom-segmented-pill>.btn,
            .custom-segmented-pill>form {
                flex-grow: 1;
                text-align: center;
            }

            .custom-segmented-pill>form>.btn {
                width: 100%;
            }
        }

        @media (max-width: 575.98px) {

            /* sm breakpoint */
            .action-btn-text {
                /* display: none; -- Biarkan teks muncul, atau aktifkan untuk hanya ikon */
            }
        }
    </style>
@endpush
