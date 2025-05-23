<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ayo Temukan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">AyoTemukan</a>

    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="{{ route('barang.index') }}">Barang Hilang</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
      </ul>

      <ul class="navbar-nav ms-auto">
        @guest
          <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
        @else
          <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              {{ Auth::user()->name }}
            </a>
            <div class="dropdown-menu dropdown-menu-end">
              <a class="dropdown-item" href="{{ route('profile.edit') }}">Profil</a>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="dropdown-item">Logout</button>
              </form>
            </div>
          </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>


<main class="container py-4">
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
