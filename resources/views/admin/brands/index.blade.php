@extends('layouts.admin')
@section('title','Kelola Brand')
@section('page-title','Kelola Brand')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <form action="{{ route('admin.brands.index') }}" method="GET" class="d-flex gap-2">
        <input type="text" name="search" class="form-control" placeholder="Cari brand..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-outline-primary"><i class="bi bi-search"></i></button>
    </form>
    <a href="{{ route('admin.brands.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Tambah Brand
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr><th>#</th><th>Logo</th><th>Nama</th><th>Deskripsi</th><th>Produk</th><th>Tanggal</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($brands as $brand)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($brand->logo)
                            <img src="{{ asset('storage/'.$brand->logo) }}" class="rounded-circle" width="40" height="40" style="object-fit:cover">
                            @else <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center text-white" style="width:40px;height:40px">🏷️</div> @endif
                        </td>
                        <td class="fw-semibold">{{ $brand->name }}</td>
                        <td class="text-muted small">{{ Str::limit($brand->description, 60) }}</td>
                        <td><span class="badge bg-secondary">{{ $brand->products_count }}</span></td>
                        <td class="small text-muted">{{ $brand->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.brands.edit', $brand) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" onsubmit="return confirm('Hapus brand ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Tidak ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $brands->withQueryString()->links() }}</div>
    </div>
</div>
@endsection