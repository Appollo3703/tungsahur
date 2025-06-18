<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AyoTemukan - @yield('title', config('app.name', 'Laravel'))</title>
    <link rel="icon" href="{{ asset('images/logo-ayotemukan.png') }}" type="image/png">
    @stack('styles')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="tw-font-sans tw-antialiased tw-flex tw-flex-col tw-min-h-screen">

    <nav class="navbar navbar-expand-lg navbar-dark navbar-professional tw-bg-custom-dark-blue shadow-sm sticky-top">
        <div class="container">
            {{-- Brand dengan Logo dan Teks --}}
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('images/logo-ayotemukan.png') }}" alt="AyoTemukan Logo" style="height: 40px;">
                <span>AyoTemukan</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavContent"
                aria-controls="navbarNavContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('home') || Request::is('/') ? 'active' : '' }}"
                            href="{{ url('/') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('barang.index*') ? 'active' : '' }}"
                            href="{{ route('barang.index') }}">Semua Laporan Barang</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('dashboard') ? 'active' : '' }}"
                                href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                    @endauth
                </ul>
                <ul class="navbar-nav align-items-center"> {{-- 'align-items-center' untuk vertikal alignment tombol di desktop --}}
                    @guest
                        <li class="nav-item">
                            <a class="btn btn-sm btn-navbar-login me-lg-2 mb-2 mb-lg-0"
                                href="{{ route('login') }}">Masuk</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-sm btn-navbar-register" href="{{ route('register') }}">Register</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center" href="#"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                                {{-- Opsional: Avatar Pengguna --}}
                                {{-- <img src="{{ Auth::user()->profile_photo_url ?? 'https://placehold.co/32x32/EBF4FF/7F9CF5?text=' . strtoupper(substr(Auth::user()->name, 0, 1)) }}" alt="{{ Auth::user()->name }}" class="navbar-user-avatar rounded-circle me-2"> --}}
                                <span>{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i
                                            class="bi bi-person-circle me-2"></i>Profil</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                {{-- ... link profil ... --}}
                                @if (Auth::user()->is_admin)
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i
                                                class="bi bi-shield-lock-fill me-2"></i>Admin Panel</a></li>
                                @endif
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item"><i
                                                class="bi bi-box-arrow-right me-2"></i>Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        @yield('content')
    </main>

    <footer class="tw-py-4 tw-mt-auto tw-bg-gray-100 dark:tw-bg-gray-800 tw-text-center">
        <div class="container">
            <small class="tw-text-gray-600 dark:tw-text-gray-400">AyoTemukan &copy; {{ date('Y') }}</small>
        </div>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const activeNavLink = document.querySelector('.navbar-professional .navbar-nav .nav-link.active');
            if (activeNavLink) {
                const pageName = activeNavLink.textContent.trim();
                if (pageName && pageName !== "{{ config('app.name', 'Laravel') }}") {
                    document.title = `${pageName} - Ayo Temukan`;
                }
            }

            const navbarEl = document.querySelector('.navbar.sticky-top');
            const bodyEl = document.body;
            if (navbarEl && bodyEl.classList.contains('body-needs-padding-top')) {
                const navbarHeight = navbarEl.offsetHeight;
                if (navbarHeight > 0) {
                    bodyEl.style.paddingTop = navbarHeight + 'px';
                }
            }
        });
    </script>
</body>

</html>
