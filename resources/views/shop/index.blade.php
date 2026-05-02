@extends('layouts.store')
@section('title', 'Toko - Aziziscake')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- ── Filter Sidebar ── -->
        <div class="col-lg-3 mb-4">
            <div class="card p-3">
                <h6 class="fw-bold mb-3"><i class="bi bi-funnel me-2"></i>Filter Produk</h6>
                <form action="{{ route('shop.index') }}" method="GET">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Cari Produk</label>
                        <input type="text" name="search" class="form-control" placeholder="Nama produk..." value="{{ request('search') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Brand</label>
                        <select name="brand_id" class="form-select">
                            <option value="">Semua Brand</option>
                            @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Harga Minimum</label>
                        <input type="number" name="min_price" class="form-control" placeholder="0" value="{{ request('min_price') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Harga Maksimum</label>
                        <input type="number" name="max_price" class="form-control" placeholder="1000000" value="{{ request('max_price') }}">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                    <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary w-100 mt-2">Reset</a>
                </form>
            </div>
        </div>

        <!-- ── Products Grid ── -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Semua Produk <span class="text-muted fs-6">({{ $products->total() }} item)</span></h4>
            </div>

            @if($products->isEmpty())
            <div class="text-center py-5">
                <div style="font-size:5rem">🔍</div>
                <h5 class="mt-3">Produk tidak ditemukan</h5>
                <p class="text-muted">Coba gunakan kata kunci lain atau reset filter.</p>
            </div>
            @else
            <div class="row g-4">
                @foreach($products as $product)
                <div class="col-sm-6 col-xl-4">
                    <div class="card product-card h-100">
                        @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top" alt="{{ $product->product_name }}">
                        @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:220px;font-size:4rem;">🍞</div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <span class="badge mb-2" style="background:var(--primary);width:fit-content">{{ $product->brand->name }}</span>
                            <h6 class="fw-semibold mb-1">{{ $product->product_name }}</h6>
                            <p class="text-muted small flex-grow-1">{{ Str::limit($product->description, 80) }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                    <small class="text-muted">Stok: {{ $product->stock }}</small>
                                </div>
                                <a href="{{ route('shop.show', $product) }}" class="btn btn-primary btn-sm">Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $products->withQueryString()->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection