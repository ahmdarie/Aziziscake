@extends('layouts.admin')
@section('title','Detail Produk')
@section('page-title','Detail Produk')

@section('content')
<div class="row">
    <div class="col-lg-5">
        <div class="card">
            <div class="card-body text-center">
                @if($product->image)
                <img src="{{ asset('storage/'.$product->image) }}" class="img-fluid rounded-2" style="max-height:300px">
                @else
                <div class="bg-light rounded-2 d-flex align-items-center justify-content-center" style="height:300px;font-size:5rem">🍞</div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3">{{ $product->product_name }}</h4>
                <span class="badge bg-secondary mb-3">{{ $product->brand->name }}</span>
                <p class="text-muted">{{ $product->description ?: 'Tidak ada deskripsi' }}</p>
                <hr>
                <div class="row">
                    <div class="col-6">
                        <p class="text-muted mb-1">Harga</p>
                        <p class="fw-bold fs-5">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                    <div class="col-6">
                        <p class="text-muted mb-1">Stok</p>
                        <span class="badge {{ $product->stock > 10 ? 'bg-success' : ($product->stock > 0 ? 'bg-warning' : 'bg-danger') }} fs-6">
                            {{ $product->stock }} unit
                        </span>
                    </div>
                </div>
                <hr>
                <p class="text-muted small mb-1">Dibuat: {{ $product->created_at->format('d M Y H:i') }}</p>
                <p class="text-muted small">Diupdate: {{ $product->updated_at->format('d M Y H:i') }}</p>
                <div class="d-flex gap-2 mt-4">
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary"><i class="bi bi-pencil me-2"></i>Edit</a>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger"><i class="bi bi-trash me-2"></i>Hapus</button>
                    </form>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
