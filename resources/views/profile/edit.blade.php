@extends('layouts.app')

@section('title', 'Pengaturan Akun Saya')

@section('content')
    <div class="container my-4 my-md-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">

                <div class="text-center mb-4 pt-3">
                    <h1 class="h2 fw-bold">Pengaturan Akun</h1>
                    <p class="text-muted">Kelola informasi profil, preferensi, dan keamanan akun Anda.</p>
                </div>

                @if (session('status') === 'profile-updated')
                    <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        Informasi profil berhasil diperbarui.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('status') === 'password-updated')
                    <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        Password berhasil diperbarui.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Informasi Profil --}}
                <div class="card profile-card mb-4 rounded-4 border-0 shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="card-title h5 fw-semibold mb-1">Informasi Pribadi</h3>
                        <p class="card-subtitle text-muted small mb-4">Perbarui nama dan alamat email Anda.</p>
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                {{-- Ubah Password --}}
                <div class="card profile-card mb-4 rounded-4 border-0 shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="card-title h5 fw-semibold mb-1">Keamanan Akun</h3>
                        <p class="card-subtitle text-muted small mb-4">Ubah password Anda secara berkala untuk menjaga
                            keamanan.</p>
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                {{-- Hapus Akun --}}
                <div class="card profile-card rounded-4 border-danger border-0 shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="card-title h5 fw-semibold mb-1 text-danger">Zona Berbahaya</h3>
                        <p class="card-subtitle text-muted small mb-4">Tindakan ini tidak dapat diurungkan. Pertimbangkan
                            baik-baik.</p>
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .profile-card .form-label {
            font-weight: 500;
            color: #343a40;
            /* Lebih gelap sedikit dari default */
        }

        .profile-card .form-control {
            border-radius: 0.5rem;
            /* Sedikit lebih bulat */
            border: 1px solid #ced4da;
            padding: 0.75rem 1rem;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .profile-card .form-control:focus {
            border-color: var(--app-navbar-accent-color, #75A5D1);
            /* Warna aksen dari navbar */
            box-shadow: 0 0 0 0.25rem rgba(var(--app-navbar-accent-color-rgb, 117, 165, 209), 0.25);
        }

        .profile-card .btn-primary {
            background-color: var(--app-navbar-bg, #003366);
            /* Warna utama dari navbar */
            border-color: var(--app-navbar-bg, #003366);
            padding: 0.6rem 1.25rem;
            font-weight: 500;
            border-radius: 0.5rem;
        }

        .profile-card .btn-primary:hover {
            background-color: #002244;
            /* Lebih gelap sedikit saat hover */
            border-color: #002244;
        }

        .profile-card .btn-danger {
            padding: 0.6rem 1.25rem;
            font-weight: 500;
            border-radius: 0.5rem;
        }

        .card-title.h5 {
            color: var(--app-navbar-bg, #003366);
        }

        .card.border-danger .card-title.h5 {
            color: var(--bs-danger);
        }

        /* Modern Profile Page Styles */
        body {
            /* Sedikit override untuk background jika diperlukan, atau atur di Tailwind config */
            /* background-color: #f8f9fa; */
            /* Contoh warna background body yang netral */
        }

        .profile-card .form-label {
            font-weight: 500;
            color: #343a40;
            margin-bottom: 0.5rem;
        }

        .profile-card .form-control {
            border-radius: 0.5rem;
            /* Rounded inputs */
            border: 1px solid #dee2e6;
            /* Softer border */
            padding: 0.75rem 1.1rem;
            /* More padding */
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            font-size: 0.95rem;
        }

        .profile-card .form-control:focus {
            border-color: var(--app-navbar-accent-color, #75A5D1);
            /* Warna aksen dari variabel CSS Anda */
            box-shadow: 0 0 0 0.25rem rgba(var(--app-navbar-accent-color-rgb, 117, 165, 209), 0.25);
            /* Menggunakan variabel RGB jika ada */
        }

        .profile-card .btn-primary {
            background-color: var(--app-navbar-bg, #003366);
            /* Warna utama dari variabel CSS Anda */
            border-color: var(--app-navbar-bg, #003366);
            padding: 0.65rem 1.5rem;
            /* Padding tombol */
            font-weight: 500;
            border-radius: 0.5rem;
            /* Tombol rounded */
            transition: background-color .15s ease-in-out, border-color .15s ease-in-out, transform .15s ease-in-out;
        }

        .profile-card .btn-primary:hover {
            background-color: #002244;
            /* Warna hover lebih gelap */
            border-color: #002244;
            transform: translateY(-1px);
        }

        .profile-card .btn-danger {
            padding: 0.65rem 1.5rem;
            font-weight: 500;
            border-radius: 0.5rem;
        }

        .profile-card .btn-danger:hover {
            transform: translateY(-1px);
        }

        .profile-card .card-title.h5 {
            /* Styling untuk sub-judul di dalam card */
            color: var(--app-navbar-bg, #003366);
            /* Menggunakan warna utama navbar */
        }

        .profile-card.border-danger .card-title.h5 {
            /* Khusus untuk card hapus akun */
            color: var(--bs-danger);
        }

        .alert i.bi {
            /* Styling ikon di alert */
            vertical-align: text-bottom;
        }
    </style>
@endpush

{{-- Pastikan @stack('scripts') ada di layouts/app.blade.php sebelum </body> --}}
