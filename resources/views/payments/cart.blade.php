@extends('layouts.store')
@section('title', 'Upload Bukti Pembayaran')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card p-4">
                <h4 class="mb-1">Upload Bukti Pembayaran</h4>
                <p class="text-muted small mb-4">Pesanan #{{ $order->id }} &bull; Total: <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong></p>

                @if($order->payment->payment_method === 'bank_transfer')
                <div class="alert alert-info">
                    <strong>Rekening Tujuan Transfer:</strong><br>
                    BCA - <strong>1234 5678 90</strong> a/n BreadHouse Indonesia<br>
                    BRI - <strong>9876 5432 10</strong> a/n BreadHouse Indonesia
                </div>
                @elseif($order->payment->payment_method === 'e_wallet')
                <div class="alert alert-info">
                    <strong>Nomor E-Wallet:</strong><br>
                    GoPay / OVO / DANA: <strong>0812-3456-7890</strong> (Admin BreadHouse)
                </div>
                @endif

                <form action="{{ route('payment.upload', $order) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Upload Bukti Pembayaran <span class="text-danger">*</span></label>
                        <input type="file" name="proof" class="form-control @error('proof') is-invalid @enderror" accept="image/*" required>
                        <div class="form-text">Format: JPG, PNG. Maks: 2MB</div>
                        @error('proof')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-upload me-2"></i>Upload & Konfirmasi
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection