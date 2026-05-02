@extends('layouts.admin')
@section('title','Kelola Produk')
@section('page-title','Kelola Produk')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <form action="{{ route('admin.products.index') }}" method="GET" class="d-flex gap-2">
        <input type="text" name="search" class="form-control" placeholder="Cari produk..." value="{{ request('search') }}">
        <select name="brand_id" class="form-select" style="min-width:140px">
            <option value="">Semua Brand</option>
            @foreach($brands as $b)<option value="{{ $b->id }}" {{ request('brand_id') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>@endforeach
        </select>
        <button type="submit" class="btn btn-outline-primary"><i class="bi bi-search"></i></button>
    </form>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Tambah Produk
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr><th>#</th><th>Gambar</th><th>Nama Produk</th><th>Brand</th><th>Harga</th><th>Stok</th><th>Tanggal</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($product->image)
                            <img src="{{ asset('storage/'.$product->image) }}" width="50" height="50" class="rounded-2" style="object-fit:cover">
                            @else <div class="bg-light rounded-2 d-inline-flex align-items-center justify-content-center" style="width:50px;height:50px;font-size:1.5rem">🍞</div> @endif
                        </td>
                        <td class="fw-semibold">{{ $product->product_name }}</td>
                        <td><span class="badge bg-secondary">{{ $product->brand->name }}</span></td>
                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $product->stock > 10 ? 'bg-success' : ($product->stock > 0 ? 'bg-warning' : 'bg-danger') }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td class="small text-muted">{{ $product->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">Tidak ada produk</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $products->withQueryString()->links() }}</div>
    </div>
</div>
@endsection