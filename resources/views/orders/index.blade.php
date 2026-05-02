@extends('layouts.store')
@section('title', 'Pesanan Saya')

@section('content')
<div class="container py-5">
    <h2 class="section-title mb-4">Pesanan Saya</h2>

    @if($orders->isEmpty())
    <div class="text-center py-5">
        <div style="font-size:5rem">📦</div>
        <h5 class="mt-3">Belum ada pesanan</h5>
        <a href="{{ route('shop.index') }}" class="btn btn-primary mt-2">Mulai Belanja</a>
    </div>
    @else
    @foreach($orders as $order)
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2 py-3">
            <div>
                <span class="fw-semibold">Pesanan #{{ $order->id }}</span>
                <span class="text-muted ms-3 small">{{ $order->order_date->format('d M Y H:i') }}</span>
            </div>
            <span class="badge bg-{{ $order->status_badge }} fs-6">{{ ucfirst($order->status) }}</span>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-8">
                    @foreach($order->orderItems->take(2) as $item)
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="bg-light rounded-2 d-flex align-items-center justify-content-center" style="width:50px;height:50px;font-size:1.5rem;">🍞</div>
                        <div>
                            <div class="small fw-semibold">{{ $item->product->product_name }}</div>
                            <div class="text-muted" style="font-size:.78rem">x{{ $item->quantity }} &times; Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                        </div>
                    </div>
                    @endforeach
                    @if($order->orderItems->count() > 2)
                    <small class="text-muted">+ {{ $order->orderItems->count() - 2 }} produk lainnya</small>
                    @endif
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="fw-bold mb-1" style="color:var(--primary)">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                    <div class="mb-2">
                        @if($order->payment)
                        <span class="badge bg-{{ $order->payment->payment_status === 'paid' ? 'success' : 'warning' }}">
                            {{ $order->payment->payment_status === 'paid' ? 'Lunas' : 'Belum Bayar' }}
                        </span>
                        @endif
                    </div>
                    <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                    @if($order->payment && $order->payment->payment_status === 'unpaid' && $order->status !== 'cancelled')
                    <a href="{{ route('payment.show', $order) }}" class="btn btn-sm btn-warning ms-1">Bayar</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <div class="d-flex justify-content-center mt-3">
        {{ $orders->links() }}
    </div>
    @endif
</div>
@endsection