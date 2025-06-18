@extends('layouts.app')

@section('title', 'Detail Laporan: ' . Str::limit($barang->nama, 35))

@section('content')
    <div class="container py-4 py-lg-5 item-detail-page">
        <div class="row justify-content-center">
            <div class="col-lg-11 col-xl-10">
                <div
                    class="card shadow-xl border-0 rounded-4 overflow-hidden @if ($barang->status === 'selesai') item-detail-selesai @endif">
                    <div class="row g-0">
                        {{-- Kolom Gambar --}}
                        <div
                            class="col-lg-6 bg-light-subtle d-flex align-items-center justify-content-center item-detail-img-col p-3 p-md-4">
                            @if ($barang->gambar)
                                <a href="{{ asset('storage/' . $barang->gambar) }}" data-bs-toggle="modal"
                                    data-bs-target="#imageModal-{{ $barang->id }}" title="Lihat gambar lebih besar">
                                    <img src="{{ asset('storage/' . $barang->gambar) }}"
                                        class="img-fluid item-detail-image rounded-3 shadow-sm"
                                        alt="Gambar {{ $barang->nama }}">
                                </a>
                            @else
                                <div class="item-detail-image-placeholder text-center p-5 w-100">
                                    <i class="bi bi-image display-1 text-secondary opacity-25"></i>
                                    <p class="mt-3 text-muted">Gambar tidak tersedia</p>
                                </div>
                            @endif
                        </div>

                        {{-- Kolom Detail Konten --}}
                        <div class="col-lg-6 d-flex flex-column">
                            <div class="card-body p-4 p-xl-5 flex-grow-1">
                                <div class="mb-3">
                                    <span
                                        class="badge fs-6 lh-base rounded-pill 
                                    @if ($barang->status === 'hilang') bg-danger-soft text-danger-emphasis 
                                    @elseif($barang->status === 'ditemukan') bg-success-soft text-success-emphasis
                                    @else bg-secondary-soft text-secondary-emphasis @endif">

                                        {{-- Perubahan Ikon untuk Status Ditemukan --}}
                                        @if ($barang->status === 'hilang')
                                            <i class="bi bi-exclamation-diamond-fill me-1"></i>
                                        @elseif($barang->status === 'ditemukan')
                                            <i class="bi bi-hand-thumbs-up-fill me-1"></i> {{-- Ikon Baru untuk Ditemukan --}}
                                        @else
                                            <i class="bi bi-patch-check-fill me-1"></i> {{-- Ikon untuk Selesai --}}
                                        @endif
                                        Status: {{ ucfirst($barang->status) }}
                                    </span>
                                    @if ($barang->kategori)
                                        <span
                                            class="badge fs-6 lh-base rounded-pill bg-secondary-subtle text-secondary-emphasis fw-normal ms-1 m-1">
                                            <i
                                                class="bi bi-tag-fill me-1 opacity-75"></i>{{ $barang->kategori->nama_kategori }}
                                        </span>
                                    @endif
                                </div>

                                <h1 class="h2 fw-bolder mb-3 text-primary-emphasis">{{ $barang->nama }}</h1>

                                <div class="mb-4">
                                    <h6 class="fw-semibold text-dark-emphasis mb-2 text-uppercase small ls-1">Deskripsi
                                        Barang</h6>
                                    <p class="text-secondary lh-lg item-detail-description">{{ $barang->deskripsi }}</p>
                                </div>

                                <div class="mb-4">
                                    <h6 class="fw-semibold text-dark-emphasis mb-2 text-uppercase small ls-1">Lokasi
                                        Terakhir/Ditemukan</h6>
                                    <p class="text-secondary fs-5"><i
                                            class="bi bi-geo-alt-fill me-2 text-primary opacity-75"></i>
                                        {{ $barang->lokasi }}</p>
                                </div>

                                <p class="small text-muted mt-4 mb-0">
                                    <i class="bi bi-calendar3 me-1 opacity-75"></i>Dilaporkan pada:
                                    {{ $barang->created_at->translatedFormat('d F Y, \p\u\k\u\l H:i') }}
                                    @if ($barang->status === 'selesai' && $barang->updated_at->ne($barang->created_at))
                                        <br><i class="bi bi-check2-all me-1 opacity-75 text-success"></i>Diselesaikan pada:
                                        {{ $barang->updated_at->translatedFormat('d F Y, \p\u\k\u\l H:i') }}
                                    @endif
                                </p>
                            </div>

                            <div class="card-footer bg-transparent border-top-0 p-4 p-xl-5 mt-auto">
                                <h6
                                    class="fw-semibold text-dark-emphasis mb-3 pt-3 border-top border-light-subtle text-uppercase small ls-1">
                                    Informasi Pelapor</h6>
                                <ul class="list-unstyled text-secondary mb-0">
                                    <li class="mb-2 d-flex align-items-center">
                                        <i class="bi bi-person-circle me-2 fs-5 text-primary opacity-75"></i>
                                        <div>
                                            <strong class="d-block text-dark-emphasis">Nama:</strong>
                                            {{ $barang->user->name }}
                                        </div>
                                    </li>
                                    <li class="mb-2 d-flex align-items-center">
                                        <i class="bi bi-envelope-at-fill me-2 fs-5 text-primary opacity-75"></i>
                                        <div>
                                            <strong class="d-block text-dark-emphasis">Email:</strong>
                                            <a href="mailto:{{ $barang->user->email }}"
                                                class="text-decoration-none text-primary-emphasis fw-medium">{{ $barang->user->email }}</a>
                                        </div>
                                    </li>
                                    @if ($barang->kontak)
                                        <li class="d-flex align-items-center">
                                            @php
                                                $kontak = preg_replace('/\D/', '', $barang->kontak);
                                                $isWhatsapp = preg_match('/^(08|62)/', $kontak);
                                                if (str_starts_with($kontak, '08')) {
                                                    $kontakUrl = '62' . substr($kontak, 1);
                                                } else {
                                                    $kontakUrl = $kontak;
                                                }
                                            @endphp
                                            @if ($isWhatsapp)
                                                <i class="bi bi-whatsapp me-2 fs-5 text-success"></i>
                                                <div>
                                                    <strong class="d-block text-dark-emphasis">WhatsApp:</strong>
                                                    <a href="https://wa.me/{{ $kontakUrl }}?text=Halo%2C%20saya%20menemukan%20postingan%20Anda%20tentang%20barang%20%27{{ urlencode($barang->nama) }}%27%20di%20AyoTemukan."
                                                        target="_blank"
                                                        class="text-success-emphasis text-decoration-none fw-medium">
                                                        {{ $barang->kontak }} <i
                                                            class="bi bi-box-arrow-up-right small"></i>
                                                    </a>
                                                </div>
                                            @else
                                                <i
                                                    class="bi bi-telephone-outbound-fill me-2 fs-5 text-primary opacity-75"></i>
                                                <div>
                                                    <strong class="d-block text-dark-emphasis">Kontak Lain:</strong>
                                                    {{ $barang->kontak }}
                                                </div>
                                            @endif
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light-subtle p-3 p-md-4">
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
                            <a href="{{ URL::previous() != URL::current() && Str::startsWith(URL::previous(), url('/')) && !str_contains(URL::previous(), '/edit') ? URL::previous() : route('barang.index') }}"
                                class="btn btn-outline-secondary rounded-pill px-4 py-2 order-sm-1">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
                            </a>
                            @auth
                                @if (Auth::id() == $barang->user_id)
                                    <div class="btn-group order-sm-2 mt-2 mt-sm-0 custom-segmented-pill-showpage"
                                        role="group">
                                        @if ($barang->status !== 'selesai')
                                            <a href="{{ route('barang.edit', $barang->id) }}?from_page={{ urlencode(Request::fullUrl()) }}"
                                                class="btn btn-outline-primary" title="Edit Laporan">
                                                <i class="bi bi-pencil-fill"></i> Edit
                                            </a>
                                            <form action="{{ route('barang.tandaiSelesai', $barang->id) }}" method="POST"
                                                class="d-flex">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="_redirect_after_action"
                                                    value="{{ Request::fullUrl() }}">
                                                <button type="submit" class="btn btn-outline-success w-100"
                                                    onclick="return confirm('Tandai laporan ini sebagai selesai/sudah dikembalikan?')"
                                                    title="Tandai Laporan Selesai">
                                                    <i class="bi bi-check2-square"></i> Selesai
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteBarangModal-show-{{ $barang->id }}"
                                                title="Hapus Laporan">
                                                <i class="bi bi-trash-fill"></i> Hapus
                                            </button>
                                        @else
                                            <span class="badge bg-info-subtle text-info-emphasis p-2 px-3 rounded-pill fs-6"><i
                                                    class="bi bi-info-circle-fill me-1"></i> Laporan ini sudah selesai.</span>
                                        @endif
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($barang->gambar)
        <div class="modal fade" id="imageModal-{{ $barang->id }}" tabindex="-1"
            aria-labelledby="imageModalLabel-{{ $barang->id }}" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content bg-transparent border-0 shadow-none">
                    <div class="modal-header border-0 px-2 pt-2 pb-0 position-absolute top-0 end-0" style="z-index: 1056;">
                        <button type="button" class="btn-close btn-close-white shadow-lg" data-bs-dismiss="modal"
                            aria-label="Close" style="font-size: 1rem; background-color: rgba(0,0,0,0.5);"></button>
                    </div>
                    <div class="modal-body p-0 text-center">
                        <img src="{{ asset('storage/' . $barang->gambar) }}" class="img-fluid rounded-3"
                            alt="Gambar {{ $barang->nama }} diperbesar" style="max-height: 90vh;">
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal Hapus untuk halaman show --}}
    @auth
        @if (Auth::id() == $barang->user_id && $barang->status !== 'selesai')
            <div class="modal fade" id="deleteBarangModal-show-{{ $barang->id }}" tabindex="-1"
                aria-labelledby="deleteBarangModalLabel-show-{{ $barang->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-4 shadow">
                        <div class="modal-header border-0 pb-0">
                            <h5 class="modal-title text-danger-emphasis fw-bold"
                                id="deleteBarangModalLabel-show-{{ $barang->id }}"><i
                                    class="bi bi-exclamation-triangle-fill me-2"></i>Konfirmasi Hapus</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body py-4">
                            Apakah Anda yakin ingin menghapus laporan: <br><strong
                                class="fs-5 d-block mt-2">"{{ $barang->nama }}"</strong>?
                        </div>
                        <div class="modal-footer border-0 pt-0">
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                                data-bs-dismiss="modal">Batal</button>
                            <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                {{-- Redirect ke index setelah hapus dari show page --}}
                                <input type="hidden" name="_redirect_after_action" value="{{ route('barang.index') }}">
                                <button type="submit" class="btn btn-danger rounded-pill px-4">Ya, Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endauth

@endsection

@push('styles')
    <style>
        :root {
            --app-card-border-radius: 0.85rem;
            --app-primary-color: #003366;
            --app-accent-color: #75A5D1;
            --app-pill-border-radius: 50rem;
            --app-btn-group-border-color: var(--bs-border-color-translucent, rgba(0, 0, 0, 0.175));
        }

        .card.shadow-xl {
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.07) !important;
        }

        .item-detail-img-col {
            min-height: 300px;
            max-height: 550px;
            overflow: hidden;
        }

        .item-detail-image {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
            cursor: zoom-in;
        }

        .item-detail-image-placeholder {
            width: 100%;
            height: 100%;
            min-height: 300px;
        }

        .bg-danger-soft {
            background-color: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.2);
        }

        .text-danger-emphasis {
            color: #931f2c !important;
        }

        .bg-success-soft {
            background-color: rgba(25, 135, 84, 0.1);
            border: 1px solid rgba(25, 135, 84, 0.2);
        }

        .text-success-emphasis {
            color: #0f5132 !important;
        }

        .bg-secondary-soft {
            background-color: rgba(108, 117, 125, 0.1);
            border: 1px solid rgba(108, 117, 125, 0.2);
        }

        .text-secondary-emphasis {
            color: #495057 !important;
        }

        .bg-info-subtle {
            background-color: var(--bs-info-bg-subtle) !important;
        }

        .text-info-emphasis {
            color: var(--bs-info-text-emphasis) !important;
        }

        .text-primary-emphasis {
            color: var(--app-primary-color) !important;
        }

        .text-dark-emphasis {
            color: var(--bs-gray-700) !important;
        }

        .lh-lg {
            line-height: 1.7;
        }

        .ls-1 {
            letter-spacing: 0.05em;
        }

        .item-detail-description {
            white-space: pre-wrap;
        }

        .btn-lg,
        .btn-warning.btn-lg {
            padding: 0.7rem 1.5rem;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .rounded-pill {
            border-radius: var(--app-pill-border-radius) !important;
        }

        .btn-warning {
            color: #000;
        }

        .btn-warning:hover {
            color: #000;
        }

        /* Styling untuk modal zoom gambar */
        #imageModal-{{ $barang->id }} .modal-content {
            box-shadow: none;
        }

        #imageModal-{{ $barang->id }} .btn-close-white {
            filter: invert(1) grayscale(100%) brightness(200%);
            opacity: 0.85;
        }

        #imageModal-{{ $barang->id }} .btn-close-white:hover {
            opacity: 1;
        }

        .item-detail-selesai .item-detail-image {
            filter: grayscale(60%);
        }

        .item-detail-selesai .btn-warning {
            /* Tombol edit di-disable jika selesai */
            pointer-events: none;
            opacity: 0.65;
        }

        /* Tombol Aksi di Halaman Show (Segmented Pill Style) */
        .custom-segmented-pill-showpage {
            border: 1px solid var(--app-btn-group-border-color);
            border-radius: var(--app-pill-border-radius) !important;
            display: inline-flex;
            overflow: hidden;
        }

        .custom-segmented-pill-showpage .btn,
        .custom-segmented-pill-showpage form>.btn {
            border-radius: 0 !important;
            border: none !important;
            box-shadow: none !important;
            padding: 0.45rem 0.9rem;
            /* Sedikit lebih besar dari di card index */
            font-size: 0.85rem;
            /* Sedikit lebih besar */
            line-height: 1.5;
            flex-grow: 1;
        }

        .custom-segmented-pill-showpage>*:not(:last-child) {
            border-right: 1px solid var(--app-btn-group-border-color) !important;
        }

        /* Warna hover bisa disamakan dengan yang di index atau dibedakan */


        @media (max-width: 991.98px) {
            .item-detail-img-col {
                max-height: 400px;
            }

            .item-detail-image {
                border-radius: var(--app-card-border-radius) var(--app-card-border-radius) 0 0 !important;
            }

            .item-detail-image-placeholder {
                border-radius: var(--app-card-border-radius) var(--app-card-border-radius) 0 0 !important;
                min-height: 250px;
            }

            .col-lg-6.d-flex.flex-column .card-body {
                padding-top: 1.5rem;
            }

            .col-lg-6.d-flex.flex-column .card-footer:first-of-type {
                /* Target footer info pelapor */
                padding-top: 1.5rem !important;
            }
        }

        @media (max-width: 575.98px) {

            /* sm breakpoint */
            .item-detail-page .card-footer .btn-group,
            .item-detail-page .card-footer .btn {
                /* Tombol di footer show page jadi full width & bertumpuk */
                width: 100%;
                display: block;
            }

            .item-detail-page .card-footer .btn-group>.btn,
            .item-detail-page .card-footer .btn-group>form {
                width: 100%;
            }

            .item-detail-page .card-footer .btn-group>*:not(:last-child) {
                margin-bottom: 0.5rem;
                border-right: none !important;
                /* Hapus border kanan jika vertikal */
            }

            .custom-segmented-pill-showpage {
                display: flex;
                flex-direction: column;
                border: none;
                /* Hapus border grup jika vertikal */
                gap: 0.5rem;
            }

            .custom-segmented-pill-showpage .btn,
            .custom-segmented-pill-showpage form>.btn {
                border-radius: var(--app-pill-border-radius) !important;
                /* Kembalikan pill individual */
                border: 1px solid var(--app-btn-group-border-color) !important;
                /* Tambah border individual */
            }

            .custom-segmented-pill-showpage>*:not(:last-child) {
                border-right: none !important;
            }
        }
    </style>
@endpush
