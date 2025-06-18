@extends('layouts.app')

@section('title', 'Telusuri Laporan Barang')

@section('content')
    <div class="container py-4 py-lg-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pt-md-2">
            <h1 class="h2 fw-bolder mb-3 mb-md-0" style="color: var(--app-navbar-bg, #003366);">Temukan Barangmu</h1>
            @auth
                {{-- Mengirim URL halaman index saat ini (termasuk filter) sebagai 'from' --}}
                <a href="{{ route('barang.create') }}?from={{ urlencode(Request::fullUrl()) }}"
                    class="btn btn-primary btn-lg rounded-pill shadow-sm px-4 py-2">
                    <i class="bi bi-plus-circle-fill me-2"></i>Laporkan Barang
                </a>
            @endauth
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0" role="alert">
                <div class="d-flex align-items-center"><i class="bi bi-check-circle-fill fs-4 me-3"></i><span
                        class="fw-medium">{{ session('success') }}</span></div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error') || session('info'))
            <div class="alert {{ session('error') ? 'alert-danger' : 'alert-info' }} alert-dismissible fade show rounded-4 shadow-sm border-0"
                role="alert">
                <div class="d-flex align-items-center"><i
                        class="bi {{ session('error') ? 'bi-exclamation-triangle-fill' : 'bi-info-circle-fill' }} fs-4 me-3"></i><span
                        class="fw-medium">{{ session('error') ?? session('info') }}</span></div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Filter --}}
        <div class="card shadow-sm mb-4 rounded-4 border-light">
            <div class="card-body p-3 p-lg-4">
                <form method="GET" action="{{ route('barang.index') }}" class="row gx-3 gy-2 align-items-end">
                    <div class="col-lg-4 col-md-12">
                        <label for="search_keyword" class="form-label small fw-medium text-muted">Kata
                            Kunci</label>
                        <input type="text" name="search" id="search_keyword"
                            class="form-control form-control-lg rounded-pill border-light-subtle"
                            placeholder="Cari nama barang, lokasi..." value="{{ request('search') }}">
                    </div>
                    <div class="col-lg col-md-4">
                        <label for="search_status" class="form-label small fw-medium text-muted">Status</label>
                        <select name="status" id="search_status"
                            class="form-select form-select-lg rounded-pill border-light-subtle">
                            {{-- Opsi Filter Status Diperbarui --}}
                            <option value="aktif" {{ request('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Semua
                                Barang</option>
                            <option value="hilang" {{ request('status') == 'hilang' ? 'selected' : '' }}>Hilang</option>
                            <option value="ditemukan" {{ request('status') == 'ditemukan' ? 'selected' : '' }}>Ditemukan
                            </option>
                        </select>
                    </div>
                    <div class="col-lg col-md-4">
                        <label for="search_kategori" class="form-label small fw-medium text-muted">Kategori</label>
                        <select name="kategori" id="search_kategori"
                            class="form-select form-select-lg rounded-pill border-light-subtle">
                            <option value="">Semua Kategori</option>
                            @if (isset($kategoris) && $kategoris->count() > 0)
                                @foreach ($kategoris as $kategori_item)
                                    <option value="{{ $kategori_item->slug }}"
                                        {{ request('kategori') == $kategori_item->slug ? 'selected' : '' }}>
                                        {{ $kategori_item->nama_kategori }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-lg-auto col-md-4">
                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill shadow-sm">
                            <i class="bi bi-search"></i> Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if ($barangs->isEmpty())
            <div class="text-center py-5 mt-4 bg-light rounded-4 shadow-sm">
                <i class="bi bi-binoculars-fill fs-1 text-primary mb-3 d-block"></i>
                <h4 class="text-muted fw-normal">Belum Ada Laporan yang Sesuai</h4>
                <p class="mb-3 text-secondary">Coba kata kunci atau filter yang berbeda, atau laporkan barang jika Anda
                    kehilangan/menemukan sesuatu.</p>
                @auth
                    <a href="{{ route('barang.create') }}?from={{ urlencode(Request::fullUrl()) }}"
                        class="btn btn-primary rounded-pill px-4 py-2">
                        <i class="bi bi-plus-circle-fill me-2"></i>Buat Laporan Sekarang
                    </a>
                @endauth
            </div>
        @else
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4">
                @foreach ($barangs as $barang)
                    <div class="col d-flex align-items-stretch">
                        {{-- Tambahkan kelas item-is-finished jika status barang selesai --}}
                        <div
                            class="card w-100 shadow-sm border-light rounded-4 item-card-ayotemukan overflow-hidden @if ($barang->status === 'selesai') item-is-finished @endif">
                            <div class="item-card-img-container position-relative">
                                <a href="{{ route('barang.show', $barang->id) }}" class="text-decoration-none">
                                    @if ($barang->gambar)
                                        <img src="{{ asset('storage/' . $barang->gambar) }}"
                                            class="card-img-top item-card-image" alt="{{ $barang->nama }}">
                                    @else
                                        <div
                                            class="item-card-image-placeholder d-flex align-items-center justify-content-center bg-light-subtle text-secondary-emphasis">
                                            <i class="bi bi-image fs-1"></i>
                                        </div>
                                    @endif
                                </a>
                                <span
                                    class="badge item-card-status-badge rounded-pill 
                                    @if ($barang->status === 'hilang') bg-danger text-white 
                                    @elseif($barang->status === 'ditemukan') bg-success text-white
                                    @else bg-secondary text-white @endif">
                                    {{-- Badge untuk status 'selesai' --}}

                                    @if ($barang->status === 'hilang')
                                        <i class="bi bi-exclamation-triangle-fill me-1" style="font-size: 0.8em;"></i>
                                    @elseif($barang->status === 'ditemukan')
                                        <i class="bi bi-patch-question-fill me-1" style="font-size: 0.8em;"></i>
                                    @else
                                        {{-- Untuk status 'selesai' --}}
                                        <i class="bi bi-patch-check-fill me-1" style="font-size: 0.8em;"></i>
                                    @endif
                                    {{ ucfirst($barang->status) }}
                                </span>
                            </div>

                            <div class="card-body d-flex flex-column p-3">
                                <h5 class="card-title fw-semibold text-dark mb-1 item-card-title">
                                    <a href="{{ route('barang.show', $barang->id) }}"
                                        class="text-decoration-none text-inherit stretched-link"
                                        title="{{ $barang->nama }}">{{ $barang->nama }}</a>
                                </h5>

                                <small class="text-muted mb-1 d-block item-card-info">
                                    <i class="bi bi-geo-alt-fill me-1 opacity-75"></i>
                                    {{ Str::limit($barang->lokasi, 30) }}
                                </small>
                                <p class="card-text small mb-3 flex-grow-1 text-secondary item-card-description">
                                    {{ Str::limit($barang->deskripsi, 70) }}
                                </p>

                                @if ($barang->kategori)
                                    <small class="text-primary fw-medium mb-2 d-block item-card-kategori">
                                        <i
                                            class="bi bi-tag-fill me-1 opacity-75"></i>{{ $barang->kategori->nama_kategori }}
                                    </small>
                                @endif

                                <div class="mt-auto">
                                    @auth
                                        @if (auth()->id() === $barang->user_id)
                                            {{-- Tombol Aksi dengan Gaya Segmented Pill --}}
                                            <div class="btn-group btn-group-sm w-100 m-2 custom-segmented-pill" role="group"
                                                aria-label="Aksi Laporan Pengguna">
                                                {{-- Tombol Edit --}}
                                                <a href="{{ route('barang.edit', $barang->id) }}?from_page={{ urlencode(Request::fullUrl()) }}"
                                                    class="btn btn-outline-primary @if ($barang->status === 'selesai') disabled @endif"
                                                    title="Edit Laporan">
                                                    <i class="bi bi-pencil-fill"></i> <span
                                                        class="action-btn-text">Edit</span>
                                                </a>

                                                @if ($barang->status !== 'selesai')
                                                    {{-- Tombol Ubah Status (Toggle Hilang/Ditemukan)
                                                    <form action="{{ route('barang.ubahStatus', $barang->id) }}"
                                                        method="POST" class="d-flex">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="_redirect_to_after_action"
                                                            value="{{ Request::fullUrl() }}">
                                                        <button type="submit" class="btn btn-outline-secondary w-100"
                                                            onclick="return confirm('Ubah status barang ini menjadi \'{{ $barang->status === 'hilang' ? 'Ditemukan' : 'Hilang' }}\'?')"
                                                            title="Ubah Status (Hilang/Ditemukan)">
                                                            <i class="bi bi-arrow-repeat"></i>
                                                            <span
                                                                class="action-btn-text">{{ $barang->status === 'hilang' ? 'Jadi Ditemukan' : 'Jadi Hilang' }}</span>
                                                        </button>
                                                    </form> --}}

                                                    {{-- Tombol Tandai Selesai --}}
                                                    <form action="{{ route('barang.tandaiSelesai', $barang->id) }}"
                                                        method="POST" class="d-flex">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="_redirect_to_after_action"
                                                            value="{{ Request::fullUrl() }}">
                                                        <button type="submit" class="btn btn-outline-success w-100"
                                                            onclick="return confirm('Tandai laporan ini sebagai selesai/sudah dikembalikan?')"
                                                            title="Tandai Laporan Selesai">
                                                            <i class="bi bi-check2-square"></i>
                                                            <span class="action-btn-text">Selesai</span>
                                                        </button>
                                                    </form>
                                                @else
                                                    {{-- Tampilan jika sudah selesai (tombol disabled) --}}
                                                    <button type="button" class="btn btn-outline-secondary w-100 disabled"
                                                        title="Laporan sudah selesai">
                                                        <i class="bi bi-check2-all"></i> <span class="action-btn-text">Sudah
                                                            Selesai</span>
                                                    </button>
                                                @endif

                                                {{-- Tombol Hapus --}}
                                                <button type="button"
                                                    class="btn btn-outline-danger @if ($barang->status === 'selesai') disabled @endif"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteBarangModal-index-{{ $barang->id }}"
                                                    title="Hapus Laporan"><i class="bi bi-trash-fill"></i> <span
                                                        class="action-btn-text">Hapus</span></button>
                                            </div>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                            <div class="card-footer bg-light-subtle border-top-0 pt-2 pb-2 px-3">
                                <div class="d-flex justify-content-between align-items-center item-card-footer-info">
                                    <small class="text-muted"><i
                                            class="bi bi-person-circle me-1 opacity-75"></i>{{ Str::words($barang->user->name, 1, '') }}</small>
                                    <small class="text-muted"><i
                                            class="bi bi-clock-history me-1 opacity-75"></i>{{ $barang->created_at->diffForHumans(null, true) }}</small>
                                </div>
                            </div>
                        </div>
                        {{-- Modal Hapus --}}
                        <div class="modal fade" id="deleteBarangModal-index-{{ $barang->id }}" tabindex="-1"
                            aria-labelledby="deleteBarangModalLabel-index-{{ $barang->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content rounded-4 shadow">
                                    <div class="modal-header border-0 pb-0">
                                        <h5 class="modal-title text-danger-emphasis fw-bold"
                                            id="deleteBarangModalLabel-index-{{ $barang->id }}"><i
                                                class="bi bi-exclamation-triangle-fill me-2"></i>Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body py-4">
                                        Apakah Anda yakin ingin menghapus laporan: <br><strong
                                            class="fs-5 d-block mt-2">"{{ $barang->nama }}"</strong>?
                                        <p class="small text-muted mt-2 mb-0">Tindakan ini tidak dapat diurungkan.</p>
                                    </div>
                                    <div class="modal-footer border-0 pt-0">
                                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                                            data-bs-dismiss="modal">Batal</button>
                                        <form action="{{ route('barang.destroy', $barang->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            {{-- Menyimpan URL saat ini untuk redirect setelah hapus --}}
                                            <input type="hidden" name="_redirect_to_after_action"
                                                value="{{ Request::fullUrl() }}">
                                            <button type="submit" class="btn btn-danger rounded-pill px-4">Ya,
                                                Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-5 d-flex justify-content-center">
                {{ $barangs->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        :root {
            --app-card-border-radius: 0.85rem;
            /* Rounded-4 */
            /* --app-card-border-radius-v3: 0.375rem; /* Jika ingin lebih kotak (rounded-2) */
            --app-input-border-radius: 0.6rem;
            --app-pill-border-radius: 50rem;
            --app-primary-color: #003366;
            --app-primary-hover-color: color-mix(in srgb, var(--app-primary-color) 85%, black);
            --app-accent-color: #75A5D1;
            --app-accent-color-rgb: 117, 165, 209;
            --app-btn-group-border-color: var(--bs-border-color-translucent, rgba(0, 0, 0, 0.125));
        }

        /* Filter */
        .form-control-lg,
        .form-select-lg {
            padding-top: 0.7rem;
            padding-bottom: 0.7rem;
            font-size: 0.9rem;
            border-radius: var(--app-pill-border-radius) !important;
            border: 1px solid var(--bs-border-color-translucent);
        }

        .form-control-lg:focus,
        .form-select-lg:focus {
            border-color: var(--app-accent-color);
            box-shadow: 0 0 0 0.2rem rgba(var(--app-accent-color-rgb), 0.25);
        }

        .btn-lg {
            font-weight: 500;
        }

        /* Card Item Styling (Mempertahankan gaya sebelumnya yang sudah rapi) */
        .item-card-ayotemukan {
            transition: transform 0.2s ease-out, box-shadow 0.25s ease-out, opacity 0.25s ease-out;
            border-radius: var(--app-card-border-radius) !important;
            /* Menggunakan rounded-4 */
            display: flex;
            flex-direction: column;
            background-color: var(--bs-body-bg);
            position: relative;
        }

        .item-card-ayotemukan:hover {
            transform: translateY(-6px);
            box-shadow: 0 0.75rem 1.75rem rgba(0, 0, 0, 0.08) !important;
        }

        .item-card-img-container {
            border-top-left-radius: inherit;
            border-top-right-radius: inherit;
            overflow: hidden;
            height: 200px;
            /* Menyamakan tinggi kontainer gambar */
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            /* Warna background placeholder */
        }

        .item-card-image {
            /* Untuk gambar yang ada */
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Gambar akan mengisi kontainer dan mungkin terpotong */
            transition: transform 0.3s ease-out, filter 0.3s ease-out;
        }

        .item-card-ayotemukan:hover .item-card-image {
            transform: scale(1.06);
        }

        .item-card-image-placeholder {
            /* Untuk placeholder jika tidak ada gambar */
            width: 100%;
            height: 100%;
            border-bottom: 1px solid var(--bs-border-color-translucent);
        }

        .item-card-status-badge {
            position: absolute;
            top: 0.75rem;
            left: 0.75rem;
            font-size: 0.78rem;
            padding: 0.35rem 0.75rem;
            font-weight: 500;
            letter-spacing: 0.3px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            z-index: 1;
        }

        .bg-danger.text-white {
            background-color: var(--bs-danger) !important;
        }

        .bg-success.text-white {
            background-color: var(--bs-success) !important;
        }

        .bg-secondary.text-white {
            background-color: var(--bs-secondary) !important;
        }


        .item-card-title {
            font-size: 1.05rem;
            line-height: 1.3;
            min-height: calc(1.3em * 1);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .item-card-title a {
            color: var(--bs-gray-800);
        }

        .item-card-title a:hover {
            color: var(--app-primary-color);
        }

        .item-card-kategori {
            font-size: 0.8rem;
            line-height: 1.2;
        }

        .item-card-info {
            font-size: 0.85rem;
            line-height: 1.3;
        }

        .item-card-description {
            font-size: 0.875rem;
            line-height: 1.45;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            min-height: calc(1.45em * 2);
        }

        .item-card-footer-info {
            font-size: 0.8rem;
        }

        .text-inherit {
            color: inherit !important;
        }

        .stretched-link::after {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 0;
            content: "";
            /* z-index lebih rendah dari tombol */
        }

        /* Tombol Aksi Segmented Pill */
        .custom-segmented-pill {
            border: 1px solid var(--app-btn-group-border-color);
            border-radius: var(--app-pill-border-radius) !important;
            display: flex;
            /* Menggunakan flex agar tombol di dalamnya bisa flex-grow */
            overflow: hidden;
        }

        .custom-segmented-pill .btn,
        .custom-segmented-pill form {
            /* Form juga flex item */
            flex-grow: 1;
            /* Semua item akan mencoba mengisi ruang secara merata */
            display: flex;
            /* Untuk button di dalam form agar width 100% */
        }

        .custom-segmented-pill form>.btn {
            width: 100%;
            /* Button di dalam form mengisi lebar form */
        }

        .custom-segmented-pill .btn {
            border-radius: 0 !important;
            border: none !important;
            box-shadow: none !important;
            padding: 0.35rem 0.5rem;
            /* Padding disesuaikan agar lebih pas */
            font-size: 0.75rem;
            /* Ukuran font disesuaikan */
            line-height: 1.4;
            white-space: nowrap;
            /* Mencegah teks wrap di tombol */
            position: relative;
            z-index: 2;
            /* Pastikan tombol di atas stretched-link */
        }

        .custom-segmented-pill>*:not(:last-child) {
            /* Separator */
            border-right: 1px solid var(--app-btn-group-border-color) !important;
        }

        /* Warna hover tombol outline (sama seperti di dashboard) */
        .custom-segmented-pill .btn-outline-primary:hover {
            color: #fff;
            background-color: var(--bs-primary);
        }

        .custom-segmented-pill .btn-outline-success:hover {
            color: #fff;
            background-color: var(--bs-success);
        }

        .custom-segmented-pill .btn-outline-danger:hover {
            color: #fff;
            background-color: var(--bs-danger);
        }

        .custom-segmented-pill .btn-outline-secondary:hover {
            color: #fff;
            background-color: var(--bs-secondary);
        }

        .item-is-finished {
            opacity: 0.7;
        }

        .item-is-finished:hover {
            opacity: 0.9;
        }

        .item-is-finished .item-card-image {
            filter: grayscale(75%);
        }

        .item-is-finished:hover .item-card-image {
            filter: grayscale(20%);
        }

        /* Tombol Utama dan lainnya */
        .btn-primary {
            background-color: var(--app-primary-color) !important;
            border-color: var(--app-primary-color) !important;
        }

        .btn-primary:hover {
            background-color: var(--app-primary-hover-color) !important;
            border-color: var(--app-primary-hover-color) !important;
        }

        .btn-secondary {
            background-color: var(--bs-gray-200);
            border-color: var(--bs-gray-300);
            color: var(--bs-gray-700);
        }

        .btn-secondary:hover {
            background-color: var(--bs-gray-300);
            border-color: var(--bs-gray-400);
            color: var(--bs-gray-800);
        }

        @media (max-width: 575.98px) {

            /* sm breakpoint (smartphone) */
            .custom-segmented-pill {
                /* Tombol akan wrap jika tidak cukup ruang karena display:flex pada parent tidak diubah jadi column */
            }

            .action-btn-text {
                /* display: none; -- Biarkan teks muncul, atau aktifkan untuk hanya ikon */
            }
        }
    </style>
@endpush
