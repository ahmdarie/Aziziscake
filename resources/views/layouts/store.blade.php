<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BreadHouse') - Toko Roti Artisan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root { --primary:#8B4513; --dark:#2C1810; --accent:#D2691E; }
        body { font-family:'Poppins',sans-serif; background:#f8f9fa; }
        .navbar-store { background:var(--dark); }
        .navbar-store .navbar-brand { font-family:'Playfair Display',serif; color:#fff; font-size:1.4rem; }
        .navbar-store .nav-link { color:rgba(255,255,255,.8); font-weight:500; }
        .navbar-store .nav-link:hover,.navbar-store .nav-link.active { color:#fff; }
        .hero-section { background:linear-gradient(135deg,var(--dark) 0%,var(--primary) 100%); color:#fff; padding:5rem 0; }
        .section-title { font-family:'Playfair Display',serif; color:var(--dark); }
        .product-card { border:none; border-radius:16px; overflow:hidden; transition:transform .2s,box-shadow .2s; background:#fff; }
        .product-card:hover { transform:translateY(-4px); box-shadow:0 12px 24px rgba(0,0,0,.08); }
        .product-card .card-img-top { height:220px; object-fit:cover; }
        .product-price { color:var(--primary); font-weight:700; font-size:1.05rem; }
        .btn-primary { background:var(--primary); border-color:var(--primary); }
        .btn-primary:hover { background:var(--dark); border-color:var(--dark); }
        footer { background:var(--dark); color:rgba(255,255,255,.6); padding:2rem 0; font-size:.9rem; }
    </style>
    @stack('styles')
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-store sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}"><i class="bi bi-basket2-fill me-2"></i>BreadHouse</a>
        <button class="navbar-toggler bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('shop.*') ? 'active' : '' }}" href="{{ route('shop.index') }}">Toko</a></li>
                @auth
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('cart.*') ? 'active' : '' }}" href="{{ route('cart.index') }}"><i class="bi bi-cart3 me-1"></i>Keranjang</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}" href="{{ route('orders.index') }}">Pesanan</a></li>
                @if(auth()->user()->role === 'admin')
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-1"></i>Admin</a></li>
                @endif
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"><i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}</a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="dropdown-item text-danger">Logout</button></form>
                        </li>
                    </ul>
                </li>
                @else
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Daftar</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- Flash Messages -->
<div class="container mt-3">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
</div>

<!-- Content -->
@yield('content')

<!-- Footer -->
<footer class="mt-auto">
    <div class="container text-center">
        <p class="mb-1"><i class="bi bi-basket2-fill me-1"></i><strong>BreadHouse</strong> — Roti Artisan Premium</p>
        <small>&copy; {{ date('Y') }} BreadHouse Indonesia. All rights reserved.</small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>

