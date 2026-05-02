@extends('layouts.admin')
@section('title','Edit Brand')
@section('page-title','Edit Brand: ' . $brand->name)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card p-4">
            <form action="{{ route('admin.brands.update', $brand) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Brand <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $brand->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description', $brand->description) }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Logo Brand</label>
                    @if($brand->logo)
                    <div class="mb-2"><img src="{{ asset('storage/'.$brand->logo) }}" height="80" class="rounded-2"></div>
                    @endif
                    <input type="file" name="logo" class="form-control" accept="image/*">
                    <div class="form-text">Kosongkan jika tidak ingin mengganti logo.</div>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check2 me-2"></i>Perbarui</button>
                    <a href="{{ route('admin.brands.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection