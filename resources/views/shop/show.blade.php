@extends('layouts.store')
@section('title', $product->product_name . ' - Aziziscake')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('shop.index') }}">Toko</a></li>
            <li class="breadcrumb-item active">{{ $product->product_name }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        <!-- Image -->
        <div class="col-lg-5">
            <div class="card">
                @if($product->image)
                <img src="{{ asset('storage/'.$product->image) }}" class="img-fluid rounded-3" alt="{{ $product->product_name }}">
                @else
                <div class="d-flex align-items-center justify-content-center rounded-3 bg-light" style="height:400px;font-size:8rem;">🍞</div>
                @endif
            </div>
        </div>

        <!-- Info -->
        <div class="col-lg-7">
            <span class="badge mb-2" style="background:var(--primary)">{{ $product->brand->name }}</span>
            <h1 class="mb-2">{{ $product->product_name }}</h1>
            <div class="d-flex align-items-center gap-3 mb-4">
                <span class="display-6 fw-bold" style="color:var(--primary)">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                @if($product->stock > 0)
                <span class="badge bg-success">Tersedia ({{ $product->stock }})</span>
                @else
                <span class="badge bg-danger">Habis</span>
                @endif
            </div>

            <p class="text-muted mb-4">{{ $product->description }}</p>

            @auth
            @if(!auth()->user()->isAdmin() && $product->stock > 0)
            <form action="{{ route('cart.add', $product) }}" method="POST" class="d-flex gap-3 align-items-center">
                @csrf
                <div class="input-group" style="width:140px">
                    <span class="input-group-text">Qty</span>
                    <input type="number" name="quantity" class="form-control" value="1" min="1" max="{{ $product->stock }}">
                </div>
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-cart-plus me-2"></i>Tambah ke Keranjang
                </button>
            </form>
            @elseif($product->stock == 0)
            <button class="btn btn-secondary btn-lg" disabled>Stok Habis</button>
            @endif
            @else
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Login untuk Membeli</a>
            @endauth
        </div>
    </div>

    <!-- Related Products -->
    @if($related->count())
    <div class="mt-5">
        <h4 class="section-title mb-4">Produk Sejenis</h4>
        <div class="row g-4">
            @foreach($related as $rel)
            <div class="col-sm-6 col-lg-3">
                <div class="card product-card h-100">
                    @if($rel->image)
                    <img src="{{ asset('storage/'.$rel->image) }}" class="card-img-top" alt="{{ $rel->product_name }}">
                    @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:180px;font-size:3rem;">🍞</div>
                    @endif
                    <div class="card-body">
                        <h6>{{ $rel->product_name }}</h6>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="product-price small">Rp {{ number_format($rel->price, 0, ',', '.') }}</span>
                            <a href="{{ route('shop.show', $rel) }}" class="btn btn-sm btn-outline-primary">Lihat</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection