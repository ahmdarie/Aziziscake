@extends('layouts.admin')
@section('title','Kelola Pesanan')
@section('page-title','Kelola Pesanan')

@section('content')
<div class="d-flex flex-wrap gap-2 mb-4">
    <form action="{{ route('admin.orders.index') }}" method="GET" class="d-flex gap-2">
        <input type="text" name="search" class="form-control" placeholder="Cari nama pelanggan..." value="{{ request('search') }}">
        <select name="status" class="form-select">
            <option value="">Semua Status</option>
            @foreach(['pending','processing','shipped','completed','cancelled'] as $s)
            <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-outline-primary"><i class="bi bi-search"></i></button>
    </form>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr><th>#ID</th><th>Pelanggan</th><th>Total</th><th>Status</th><th>Pembayaran</th><th>Tanggal</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td><strong>#{{ $order->id }}</strong></td>
                        <td>
                            <div>{{ $order->user->name }}</div>
                            <small class="text-muted">{{ $order->user->email }}</small>
                        </td>
                        <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td><span class="badge bg-{{ $order->status_badge }}">{{ ucfirst($order->status) }}</span></td>
                        <td>
                            @if($order->payment)
                            <span class="badge bg-{{ $order->payment->payment_status === 'paid' ? 'success' : 'warning' }}">
                                {{ $order->payment->payment_status }}
                            </span>
                            @endif
                        </td>
                        <td class="small">{{ $order->created_at->format('d M Y') }}</td>
                        <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Detail</a></td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">Tidak ada pesanan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $orders->withQueryString()->links() }}</div>
    </div>
</div>
@endsection