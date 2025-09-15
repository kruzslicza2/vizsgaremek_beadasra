<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>CarHub Autókereskedés</title>
     <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="CarHub Autókereskedés - Minőségi használt autók széles választéka">
    <meta name="keywords" content="autó, kereskedés, használt autó, CarHub, jármű, adásvétel">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome ikonok -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { background: linear-gradient(135deg, #f8f9fa 70%, #e3eafc 100%); }
        .navbar-brand { font-weight: bold; }
        .navbar { box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .card:hover { box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15); }
        footer { box-shadow: 0 -2px 8px rgba(0,0,0,0.05); }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4 shadow sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-car me-2"></i>
                CarHub Autókereskedés
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ms-auto">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('cars.index') }}">Hirdetések</a>
        </li>
        @auth
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('cars.my') ? 'active' : '' }}" href="{{ route('cars.my') }}">
                    Hirdetéseim
                </a>
            </li>
                @if(Auth::check() && Auth::user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('brands.index') }}">Márkák</a>
                    </li>
                @endif
            <li class="nav-item">
                <a class="nav-link" href="{{ route('cars.create') }}">Új hirdetés</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('favorites.index') }}">Kedvencek</a>
            </li>

            @php
             $unreadCount = auth()->user()->unreadMessages()->count();
            @endphp
        <li class="nav-item">
            <a class="nav-link position-relative" href="{{ route('messages.index') }}">
                Üzenetek
                @if($unreadCount > 0)
                    <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle">
                        {{ $unreadCount }}
                    </span>
                @endif
            </a>
        </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('profile.show') }}">Profil</a>
            </li>
             <!-- Admin menü -->
            @if(Auth::user()->role === 'admin')
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
        Admin
    </a>
    <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li><a class="dropdown-item" href="{{ route('admin.users') }}">Felhasználók kezelése</a></li>
        <li><a class="dropdown-item" href="{{ route('admin.cars') }}">Hirdetések kezelése</a></li>
        <li><a class="dropdown-item" href="{{ route('brands.index') }}">Márkák kezelése</a></li>
    </ul>
</li>
@endif
            <li class="nav-item">
                <a class="nav-link" href="/logout">Kijelentkezés</a>
            </li>
        @else
            <li class="nav-item">
                <a class="nav-link" href="/login">Bejelentkezés</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/reg">Regisztráció</a>
            </li>
        @endauth
    </ul>
</div>

        </div>
    </nav>
    <div class="container">
        <div class="container mt-3">
    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif
</div>
    </div>
    @yield('content')
    <footer class="bg-light text-center py-3 mt-5 border-top">
        <small>&copy; {{ date('Y') }} CarHub Autókereskedés - Minden jog fenntartva</small>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
