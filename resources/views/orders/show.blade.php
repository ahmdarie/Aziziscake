@extends('layouts.store')
@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
<div class="container py-5">
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
        <h2 class="mb-0">Pesanan #{{ $order->id }}</h2>
        <span class="badge bg-{{ $order->status_badge }} fs-6">{{ ucfirst($order->status) }}</span>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <!-- Items -->
            <div class="card p-4 mb-4">
                <h5 class="mb-3">Item Pesanan</h5>
                @foreach($order->orderItems as $item)
                <div class="d-flex align-items-center gap-3 py-2 border-bottom">
                    @if($item->product->image)
                    <img src="{{ asset('storage/'.$item->product->image) }}" class="rounded-2" style="width:60px;height:60px;object-fit:cover">
                    @else
                    <div class="bg-light rounded-2 d-flex align-items-center justify-content-center" style="width:60px;height:60px;font-size:1.8rem;">🍞</div>
                    @endif
                    <div class="flex-grow-1">
                        <div class="fw-semibold">{{ $item->product->product_name }}</div>
                        <small class="text-muted">{{ $item->product->brand->name }}</small>
                    </div>
                    <div class="text-end">
                        <div class="small text-muted">x{{ $item->quantity }}</div>
                        <div class="fw-semibold">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</div>
                    </div>
                </div>
                @endforeach
                <div class="d-flex justify-content-between fw-bold pt-3">
                    <span>Total</span>
                    <span style="color:var(--primary)">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Shipment -->
            @if($order->shipment)
            <div class="card p-4 mb-4">
                <h5 class="mb-3"><i class="bi bi-truck me-2"></i>Info Pengiriman</h5>
                <table class="table table-borderless mb-0">
                    <tr><td class="text-muted" width="35%">Alamat</td><td>{{ $order->shipment->address }}</td></tr>
                    <tr><td class="text-muted">Kurir</td><td>{{ $order->shipment->courier }}</td></tr>
                    <tr><td class="text-muted">No. Resi</td><td>{{ $order->shipment->tracking_number ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Ongkir</td><td>Rp {{ number_format($order->shipment->shipping_cost, 0, ',', '.') }}</td></tr>
                    <tr><td class="text-muted">Status</td><td><span class="badge bg-info">{{ ucfirst($order->shipment->status) }}</span></td></tr>
                </table>
            </div>
            @endif
        </div>

        <div class="col-lg-4">
            <!-- Payment -->
            @if($order->payment)
            <div class="card p-4 mb-3">
                <h5 class="mb-3"><i class="bi bi-credit-card me-2"></i>Pembayaran</h5>
                <div class="mb-2"><span class="text-muted">Metode:</span> <span class="fw-semibold ms-2">{{ $order->payment->method_label }}</span></div>
                <div class="mb-3">
                    <span class="text-muted">Status:</span>
                    <span class="badge bg-{{ $order->payment->payment_status === 'paid' ? 'success' : 'warning' }} ms-2">
                        {{ $order->payment->payment_status === 'paid' ? 'Lunas' : 'Belum Bayar' }}
                    </span>
                </div>
                @if($order->payment->payment_status === 'unpaid' && $order->status !== 'cancelled')
                <a href="{{ route('payment.show', $order) }}" class="btn btn-warning w-100">Upload Bukti Bayar</a>
                @endif
            </div>
            @endif

            <!-- Actions -->
            @if(in_array($order->status, ['pending', 'processing']))
            <div class="card p-4">
                <h6 class="mb-3">Aksi</h6>
                <form action="{{ route('orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan?')">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-outline-danger w-100">Batalkan Pesanan</button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection