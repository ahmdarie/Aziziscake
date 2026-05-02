@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- ── Stat Cards ── -->
<div class="row g-4 mb-4">
    @foreach([
        ['total_products','bi-grid','Produk','bg-primary',$totalProducts],
        ['total_orders','bi-bag','Pesanan','bg-warning',$totalOrders],
        ['total_revenue','bi-currency-dollar','Revenue','bg-success',$totalRevenue],
        ['total_customers','bi-people','Pelanggan','bg-info',$totalCustomers],
    ] as [$key,$icon,$label,$color,$value])
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon text-white {{ $color }}" style="opacity:.85">
                    <i class="bi {{ $icon }}"></i>
                </div>
                <div>
                    <div class="text-muted small">{{ $label }}</div>
                    <div class="fs-4 fw-bold">
                        @if($key === 'total_revenue')
                        Rp {{ number_format($value/1000000, 1) }}jt
                        @else
                        {{ number_format($value) }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- ── Recent Orders ── -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold">Pesanan Terbaru</h6>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#ID</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Pembayaran</th>
                        <th>Tanggal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                    <tr>
                        <td><strong>#{{ $order->id }}</strong></td>
                        <td>{{ $order->user->name }}</td>
                        <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td><span class="badge bg-{{ $order->status_badge }}">{{ ucfirst($order->status) }}</span></td>
                        <td>
                            @if($order->payment)
                            <span class="badge bg-{{ $order->payment->payment_status === 'paid' ? 'success' : 'warning' }}">
                                {{ $order->payment->payment_status === 'paid' ? 'Lunas' : 'Unpaid' }}
                            </span>
                            @else <span class="text-muted">-</span> @endif
                        </td>
                        <td class="small text-muted">{{ $order->created_at->format('d M Y') }}</td>
                        <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Detail</a></td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Belum ada pesanan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection