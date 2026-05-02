# Perbaikan Website Toko Bakery

## Langkah-langkah:

- [x] 1. Edit `routes/web.php` — tambah semua route toko, admin, cart, orders, payments
- [x] 2. Edit `app/Providers/AppServiceProvider.php` — enable Bootstrap 5 pagination
- [x] 3. Buat `resources/views/layouts/store.blade.php` — layout Bootstrap 5 khusus frontend
- [x] 4. Edit view frontend — ubah `@extends('layouts.app')` → `@extends('layouts.store')`:
  - `home.blade.php`
  - `shop/index.blade.php`
  - `shop/show.blade.php`
  - `cart/index.blade.php`
  - `orders/checkout.blade.php`
  - `orders/index.blade.php`
  - `orders/show.blade.php`
- [x] 5. Buat `resources/views/payments/show.blade.php` — view yang dipanggil PaymentController@show
- [x] 6. Update `resources/views/payments/cart.blade.php` — ubah extend ke layouts.store
- [x] 7. Hapus file duplikat di `app/Http/Admin/`
- [x] 8. Jalankan `php artisan route:clear` dan `php artisan view:clear`

