@extends('layouts.store')
@section('title', 'Aziziscake - Toko Kue Premium')

@section('content')
<!-- ── Hero ── -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <p class="text-warning fw-semibold mb-2"><i class="bi bi-star-fill me-1"></i>Toko Roti Artisan #1</p>
                <h1 class="display-4 fw-bold mb-3">Roti Segar Dibuat dengan Cinta</h1>
                <p class="lead mb-4 opacity-90">Kami menghadirkan roti artisan premium dari bahan pilihan terbaik, dipanggang segar setiap hari untuk keluarga Anda.</p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('shop.index') }}" class="btn btn-warning btn-lg fw-semibold">
                        <i class="bi bi-shop me-2"></i>Belanja Sekarang
                    </a>
                    <a href="#featured" class="btn btn-outline-light btn-lg">Lihat Produk</a>
                </div>
                <div class="row g-3 mt-4">
                    <div class="col-4 text-center">
                        <h3 class="fw-bold mb-0">50+</h3>
                        <small class="opacity-75">Jenis Roti</small>
                    </div>
                    <div class="col-4 text-center">
                        <h3 class="fw-bold mb-0">1K+</h3>
                        <small class="opacity-75">Pelanggan</small>
                    </div>
                    <div class="col-4 text-center">
                        <h3 class="fw-bold mb-0">5★</h3>
                        <small class="opacity-75">Rating</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-center mt-5 mt-lg-0">
                <div style="font-size:12rem;line-height:1;">🍞</div>
            </div>
        </div>
    </div>
</section>

<!-- ── Keunggulan ── -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="row g-4 text-center">
            @foreach([
                ['bi-clock','Dipanggang Segar','Setiap hari fresh dari oven pukul 05.00 pagi'],
                ['bi-shield-check','Bahan Alami','Tanpa pengawet, tanpa pewarna buatan'],
                ['bi-truck','Pengiriman Cepat','Antar ke rumah Anda dalam kondisi terbaik'],
                ['bi-heart','Dibuat dengan Cinta','Resep turun-temurun dengan passion bakery'],
            ] as [$icon, $title, $desc])
            <div class="col-md-3">
                <div class="card p-4 h-100 text-center">
                    <div class="mb-3" style="font-size:2.5rem;color:var(--primary)"><i class="bi {{ $icon }}"></i></div>
                    <h6 class="fw-bold">{{ $title }}</h6>
                    <p class="text-muted small mb-0">{{ $desc }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ── Featured Products ── -->
<section id="featured" class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="section-title mb-1">Produk Unggulan</h2>
                <p class="text-muted">Pilihan terlaris dan terpopuler kami</p>
            </div>
            <a href="{{ route('shop.index') }}" class="btn btn-outline-primary">Lihat Semua <i class="bi bi-arrow-right ms-1"></i></a>
        </div>

        <div class="row g-4">
            @foreach($featuredProducts as $product)
            <div class="col-sm-6 col-lg-3">
                <div class="card product-card h-100">
                    @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top" alt="{{ $product->product_name }}">
                    @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:220px;font-size:4rem;">🍞</div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <span class="badge bg-secondary mb-2 w-fit">{{ $product->brand->name }}</span>
                        <h6 class="fw-semibold">{{ $product->product_name }}</h6>
                        <p class="text-muted small flex-grow-1">{{ Str::limit($product->description, 60) }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <a href="{{ route('shop.show', $product) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ── Brands ── -->
<section class="py-5 bg-white">
    <div class="container">
        <h2 class="section-title text-center mb-5">Brand Kami</h2>
        <div class="row g-3 justify-content-center">
            @foreach($brands as $brand)
            <div class="col-auto">
                <a href="{{ route('shop.index', ['brand_id' => $brand->id]) }}" class="btn btn-outline-secondary btn-lg rounded-pill">
                    {{ $brand->name }} <span class="badge bg-secondary ms-1">{{ $brand->products_count }}</span>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ── CTA ── -->
<section class="py-5" style="background:var(--primary)">
    <div class="container text-center text-white">
        <h2 class="mb-3">Siap Memesan Roti Segar?</h2>
        <p class="lead mb-4 opacity-90">Daftar sekarang dan nikmati pengalaman belanja roti artisan premium.</p>
        @guest
        <a href="{{ route('register') }}" class="btn btn-warning btn-lg fw-semibold">Daftar Gratis <i class="bi bi-arrow-right ms-2"></i></a>
        @else
        <a href="{{ route('shop.index') }}" class="btn btn-warning btn-lg fw-semibold">Belanja Sekarang <i class="bi bi-arrow-right ms-2"></i></a>
        @endguest
    </div>
</section>
@endsection