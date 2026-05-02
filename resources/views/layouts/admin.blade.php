<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Admin') - Aziziscake</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root { --primary:#8B4513; --dark:#2C1810; --accent:#D2691E; }
        body { font-family:'Poppins',sans-serif; background:#f4f6f9; }
        .admin-sidebar { width:260px; min-height:100vh; background:var(--dark); position:fixed; top:0; left:0; z-index:1000; overflow-y:auto; }
        .admin-sidebar .sidebar-brand { font-family:'Playfair Display',serif; color:#fff; font-size:1.3rem; padding:1.4rem 1.2rem; display:block; text-decoration:none; border-bottom:1px solid rgba(255,255,255,.1); }
        .admin-sidebar .nav-link { color:rgba(255,255,255,.75); border-radius:8px; margin:2px 8px; padding:.55rem .9rem; font-size:.9rem; transition:all .2s; }
        .admin-sidebar .nav-link:hover,.admin-sidebar .nav-link.active { background:var(--primary); color:#fff !important; }
        .admin-sidebar .nav-link i { width:20px; }
        .admin-sidebar .sidebar-heading { color:rgba(255,255,255,.35); font-size:.7rem; text-transform:uppercase; letter-spacing:.1em; padding:.6rem 1.2rem .3rem; }
        .main-content { margin-left:260px; min-height:100vh; }
        .top-bar { background:#fff; border-bottom:1px solid #e9ecef; padding:.75rem 1.5rem; position:sticky; top:0; z-index:100; }
        .stat-card { border:none; border-radius:16px; overflow:hidden; }
        .stat-card .card-body { padding:1.5rem; }
        .stat-icon { width:56px; height:56px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.5rem; }
        @media(max-width:768px){.admin-sidebar{transform:translateX(-100%);}.main-content{margin-left:0;}}
    </style>
    @stack('styles')
</head>
<body>

<!-- ── Sidebar ── -->
<div class="admin-sidebar">
    <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
<i class="bi bi-basket2-fill me-2"></i>Aziziscake
    </a>

    <nav class="nav flex-column pb-4">
        <span class="sidebar-heading">Utama</span>
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-speedometer2 me-2"></i>Dashboard
        </a>

        <span class="sidebar-heading mt-3">Katalog</span>
        <a class="nav-link {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}" href="{{ route('admin.brands.index') }}">
            <i class="bi bi-award me-2"></i>Brand
        </a>
        <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
            <i class="bi bi-grid me-2"></i>Produk
        </a>

        <span class="sidebar-heading mt-3">Transaksi</span>
        <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
            <i class="bi bi-bag me-2"></i>Pesanan
        </a>

        <span class="sidebar-heading mt-3">Akun</span>
        <a class="nav-link" href="{{ route('home') }}">
            <i class="bi bi-shop me-2"></i>Lihat Toko
        </a>
        <form action="{{ route('logout') }}" method="POST" class="mx-2 mt-1">
            @csrf
            <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent text-danger">
                <i class="bi bi-box-arrow-right me-2"></i>Logout
            </button>
        </form>
    </nav>
</div>

<!-- ── Main ── -->
<div class="main-content">
    <!-- Top Bar -->
    <div class="top-bar d-flex align-items-center justify-content-between">
        <h6 class="mb-0 fw-semibold">@yield('page-title', 'Dashboard')</h6>
        <div class="d-flex align-items-center gap-2">
            <span class="text-muted small"><i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}</span>
        </div>
    </div>

    <!-- Flash -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mx-4 mt-3 mb-0">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mx-4 mt-3 mb-0">
        <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Content -->
    <div class="p-4">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>