@extends('layouts.store')
@section('title', 'Checkout')

@section('content')
<div class="container py-5">
    <h2 class="section-title mb-4">Checkout</h2>

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <div class="row g-4">
            <!-- Detail Pengiriman -->
            <div class="col-lg-7">
                <div class="card p-4 mb-4">
                    <h5 class="mb-3"><i class="bi bi-truck me-2"></i>Detail Pengiriman</h5>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3" placeholder="Masukkan alamat lengkap...">{{ old('address', auth()->user()->address) }}</textarea>
                        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kurir <span class="text-danger">*</span></label>
                        <select name="courier" class="form-select @error('courier') is-invalid @enderror">
                            <option value="">Pilih Kurir</option>
                            @foreach(['JNE' => 'JNE - Rp 15.000', 'J&T' => 'J&T Express - Rp 12.000', 'SiCepat' => 'SiCepat - Rp 10.000', 'TIKI' => 'TIKI - Rp 14.000'] as $val => $label)
                            <option value="{{ $val }}" {{ old('courier') == $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('courier')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Catatan (Opsional)</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="Contoh: Jangan dibunyikan bel...">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <div class="card p-4">
                    <h5 class="mb-3"><i class="bi bi-credit-card me-2"></i>Metode Pembayaran</h5>
                    @foreach(['bank_transfer' => ['Bank Transfer','bi-bank','Transfer ke rekening bank'], 'e_wallet' => ['E-Wallet','bi-phone','GoPay, OVO, DANA, dll'], 'cod' => ['COD','bi-cash-coin','Bayar saat barang sampai']] as $val => [$label, $icon, $desc])
                    <div class="form-check mb-3 p-3 border rounded-3 {{ old('payment_method') == $val ? 'border-primary bg-light' : '' }}">
                        <input class="form-check-input" type="radio" name="payment_method" id="pm_{{ $val }}" value="{{ $val }}" {{ old('payment_method') == $val ? 'checked' : '' }} required>
                        <label class="form-check-label d-flex align-items-center gap-2" for="pm_{{ $val }}">
                            <i class="bi {{ $icon }} fs-4" style="color:var(--primary)"></i>
                            <div>
                                <div class="fw-semibold">{{ $label }}</div>
                                <small class="text-muted">{{ $desc }}</small>
                            </div>
                        </label>
                    </div>
                    @endforeach
                    @error('payment_method')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
            </div>

            <!-- Ringkasan -->
            <div class="col-lg-5">
                <div class="card p-4 sticky-top" style="top:80px">
                    <h5 class="mb-3">Ringkasan Pesanan</h5>
                    @foreach($carts as $cart)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <small class="fw-semibold">{{ $cart->product->product_name }}</small>
                            <div class="text-muted" style="font-size:.75rem">x{{ $cart->quantity }}</div>
                        </div>
                        <small>Rp {{ number_format($cart->product->price * $cart->quantity, 0, ',', '.') }}</small>
                    </div>
                    @endforeach
                    <hr>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted small">Subtotal</span>
                        <span class="small">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted small">Ongkir</span>
                        <span class="small text-muted">Sesuai kurir</span>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 btn-lg">
                        <i class="bi bi-bag-check me-2"></i>Buat Pesanan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection