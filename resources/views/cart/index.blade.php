@extends('layouts.store')
@section('title', 'Keranjang Belanja')

@section('content')
<div class="container py-5">
    <h2 class="section-title mb-4">Keranjang Belanja</h2>

    @if($carts->isEmpty())
    <div class="text-center py-5">
        <div style="font-size:5rem">🛒</div>
        <h5 class="mt-3">Keranjang masih kosong</h5>
        <p class="text-muted">Yuk, tambahkan produk favorit Anda!</p>
        <a href="{{ route('shop.index') }}" class="btn btn-primary mt-2">Mulai Belanja</a>
    </div>
    @else
    <div class="row g-4">
        <div class="col-lg-8">
            @foreach($carts as $cart)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center g-3">
                        <div class="col-3 col-md-2">
                            @if($cart->product->image)
                            <img src="{{ asset('storage/'.$cart->product->image) }}" class="img-fluid rounded-2" alt="">
                            @else
                            <div class="bg-light rounded-2 d-flex align-items-center justify-content-center" style="height:70px;font-size:2rem;">🍞</div>
                            @endif
                        </div>
                        <div class="col-9 col-md-5">
                            <h6 class="mb-1">{{ $cart->product->product_name }}</h6>
                            <small class="text-muted">{{ $cart->product->brand->name }}</small>
                        </div>
                        <div class="col-md-3">
                            <form action="{{ route('cart.update', $cart) }}" method="POST" class="d-flex gap-2 align-items-center">
                                @csrf @method('PATCH')
                                <input type="number" name="quantity" class="form-control form-control-sm" value="{{ $cart->quantity }}" min="1" max="{{ $cart->product->stock }}" style="width:70px">
                                <button type="submit" class="btn btn-sm btn-outline-primary"><i class="bi bi-check"></i></button>
                            </form>
                        </div>
                        <div class="col-md-2 text-end">
                            <div class="fw-bold text-primary small">Rp {{ number_format($cart->product->price * $cart->quantity, 0, ',', '.') }}</div>
                            <form action="{{ route('cart.destroy', $cart) }}" method="POST" class="mt-1">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="col-lg-4">
            <div class="card p-4">
                <h5 class="mb-3">Ringkasan Belanja</h5>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Subtotal ({{ $carts->count() }} item)</span>
                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Ongkos Kirim</span>
                    <span class="text-muted small">Dihitung saat checkout</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between fw-bold mb-4">
                    <span>Total</span>
                    <span style="color:var(--primary)">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <a href="{{ route('orders.checkout') }}" class="btn btn-primary w-100 btn-lg">
                    Checkout <i class="bi bi-arrow-right ms-2"></i>
                </a>
                <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary w-100 mt-2">Lanjut Belanja</a>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection