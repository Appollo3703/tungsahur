{{-- resources/views/barang/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Laporkan Barang Baru')

@section('content')
    <div class="container my-4 my-lg-5 create-barang-page">
        <div class="row justify-content-center">
            <div class="col-lg-9 col-xl-7">

                <div class="text-center mb-5">
                    <i class="bi bi-file-earmark-plus-fill display-2 mb-3" style="color: var(--app-primary-color);"></i>
                    <h1 class="h2 fw-bolder" style="color: var(--app-primary-color);">Laporkan Barang</h1>
                    <p class="text-muted fs-5 fw-light px-md-4">Bantu civitas kampus dengan melaporkan barang yang hilang
                        atau Anda temukan secara detail.</p>
                </div>

                <div class="card shadow-xl border-light rounded-4">
                    <div class="card-body p-4 p-lg-5">
                        <form method="POST" action="{{ route('barang.store') }}" enctype="multipart/form-data">

                            @csrf
                            <input type="hidden" name="_redirect_after_action"
                                value="{{ $redirectAfterAction ?? route('barang.index') }}">

                            <div class="mb-4">
                                <label for="nama" class="form-label fs-5 fw-semibold text-dark-emphasis">Nama Barang
                                    <span class="text-danger">*</span></label>
                                <input type="text" name="nama" id="nama"
                                    class="form-control form-control-lg rounded-3 @error('nama') is-invalid @enderror"
                                    value="{{ old('nama') }}" required
                                    placeholder="Contoh: Dompet Kulit Warna Coklat Tua">
                                @error('nama')
                                    <div class="invalid-feedback fw-medium small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="deskripsi" class="form-label fs-5 fw-semibold text-dark-emphasis">Deskripsi
                                    Lengkap <span class="text-danger">*</span></label>
                                <textarea name="deskripsi" id="deskripsi"
                                    class="form-control form-control-lg rounded-3 @error('deskripsi') is-invalid @enderror" rows="4" required
                                    placeholder="Sebutkan ciri-ciri spesifik, merek, warna, kondisi terakhir, isi penting (jika ada), dll.">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback fw-medium small">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr class="my-4 bg-light-subtle" style="height: 2px; opacity: 0.5;">

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label for="status" class="form-label fw-medium text-dark-emphasis">Status Laporan
                                        <span class="text-danger">*</span></label>
                                    <select name="status" id="status"
                                        class="form-select form-select-lg rounded-3 @error('status') is-invalid @enderror"
                                        required>
                                        <option value="" disabled {{ old('status') ? '' : 'selected' }}>-- Pilih
                                            Status --</option>
                                        <option value="hilang" {{ old('status') == 'hilang' ? 'selected' : '' }}>Saya
                                            Kehilangan Barang</option>
                                        <option value="ditemukan" {{ old('status') == 'ditemukan' ? 'selected' : '' }}>
                                            Saya Menemukan Barang</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="kategori_id" class="form-label fw-medium text-dark-emphasis">Kategori
                                        Barang <span class="text-danger">*</span></label>
                                    <select name="kategori_id" id="kategori_id"
                                        class="form-select form-select-lg rounded-3 @error('kategori_id') is-invalid @enderror"
                                        required>
                                        <option value="" disabled {{ old('kategori_id') ? '' : 'selected' }}>--
                                            Pilih Kategori --</option>
                                        @if (isset($kategoris) && $kategoris->count() > 0)
                                            @foreach ($kategoris as $kategori_item)
                                                <option value="{{ $kategori_item->id }}"
                                                    {{ old('kategori_id') == $kategori_item->id ? 'selected' : '' }}>
                                                    {{ $kategori_item->nama_kategori }}
                                                </option>
                                            @endforeach
                                        @else
                                            <option value="" disabled>Kategori tidak tersedia</option>
                                        @endif
                                    </select>
                                    @error('kategori_id')
                                        <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="lokasi" class="form-label fw-medium text-dark-emphasis">Lokasi Terakhir
                                        / Ditemukan <span class="text-danger">*</span></label>
                                    <input type="text" name="lokasi" id="lokasi"
                                        class="form-control rounded-3 @error('lokasi') is-invalid @enderror"
                                        value="{{ old('lokasi') }}" required
                                        placeholder="Contoh: Perpustakaan Lt. 3, Area Parkir Motor Gedung B">
                                    @error('lokasi')
                                        <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-7">
                                    <label for="kontak" class="form-label fw-medium text-dark-emphasis">Kontak Anda
                                        (Opsional)</label>
                                    <input type="text" name="kontak" id="kontak"
                                        class="form-control rounded-3 @error('kontak') is-invalid @enderror"
                                        value="{{ old('kontak') }}" placeholder="No. WA, Username IG, dll.">
                                    <small class="form-text text-muted mt-1 d-block">Akan ditampilkan publik.</small>
                                    @error('kontak')
                                        <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-5">
                                    <label for="gambar" class="form-label fw-medium text-dark-emphasis">Foto Barang
                                        (Opsional)</label>
                                    <input type="file" name="gambar" id="gambar"
                                        class="form-control rounded-3 @error('gambar') is-invalid @enderror"
                                        accept="image/jpeg,image/png,image/jpg">
                                    <small class="form-text text-muted mt-1 d-block">Format: JPG, PNG. Maks: 5MB.</small>
                                    @error('gambar')
                                        <div class="invalid-feedback small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div
                                class="d-grid gap-2 d-md-flex justify-content-md-end pt-4 mt-3 border-top border-light-subtle">
                                <a href="{{ route('barang.index') }}"
                                    class="btn btn-outline-secondary btn-lg rounded-pill px-4 py-2">Batal</a>
                                <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 py-2 shadow-sm">
                                    <i class="bi bi-cloud-arrow-up-fill me-2"></i>Publikasikan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <p class="text-center text-muted small mt-4">
                    Pastikan semua informasi akurat. Semoga barang segera kembali atau menemukan pemiliknya!
                </p>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        :root {
            --app-input-border-radius: 0.6rem;
            --app-pill-border-radius: 50rem;
            --app-primary-color: #003366;
            --app-primary-hover-color: color-mix(in srgb, var(--app-primary-color) 85%, black);
            --app-accent-color: #75A5D1;
            --app-accent-color-rgb: 117, 165, 209;
        }

        .form-control,
        .form-select {
            padding: 0.75rem 1.1rem;
            font-size: 0.95rem;
            border-radius: var(--app-input-border-radius) !important;
            border: 1px solid var(--bs-border-color-translucent);
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            background-color: var(--bs-body-bg);
        }

        .form-control-lg,
        .form-select-lg {
            padding: 0.85rem 1.35rem;
            font-size: 1rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--app-accent-color);
            box-shadow: 0 0 0 0.25rem rgba(var(--app-accent-color-rgb), 0.3);
            background-color: var(--bs-body-bg);
        }

        .form-label.fw-semibold,
        .form-label.fw-medium {
            color: var(--bs-gray-700);
            margin-bottom: 0.4rem;
        }

        .text-dark-emphasis {
            color: var(--bs-dark-text-emphasis) !important;
        }

        .card.shadow-xl {
            box-shadow: 0 1rem 2.5rem rgba(0, 0, 0, 0.06) !important;
        }

        .btn-lg {
            padding: 0.8rem 1.75rem;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .btn-primary {
            background-color: var(--app-primary-color) !important;
            border-color: var(--app-primary-color) !important;
        }

        .btn-primary:hover {
            background-color: var(--app-primary-hover-color) !important;
            border-color: var(--app-primary-hover-color) !important;
        }

        .rounded-pill {
            border-radius: var(--app-pill-border-radius) !important;
        }
    </style>
@endpush
