<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['orderItems.product', 'payment'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        $order->load(['orderItems.product.brand', 'shipment', 'payment']);
        return view('orders.show', compact('order'));
    }

    public function checkout()
    {
        $carts = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong!');
        }

        $total = $carts->sum(fn($c) => $c->product->price * $c->quantity);

        return view('orders.checkout', compact('carts', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'address'        => 'required|string',
            'courier'        => 'required|string',
            'payment_method' => 'required|in:bank_transfer,e_wallet,cod',
            'notes'          => 'nullable|string|max:500',
        ]);

        $carts = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong!');
        }

        // Validate stock
        foreach ($carts as $cart) {
            if ($cart->product->stock < $cart->quantity) {
                return redirect()->route('cart.index')
                    ->with('error', "Stok {$cart->product->product_name} tidak mencukupi!");
            }
        }

        DB::transaction(function () use ($request, $carts) {
            $total = $carts->sum(fn($c) => $c->product->price * $c->quantity);
            $shippingCost = $this->getShippingCost($request->courier);
            $grandTotal = $total + $shippingCost;

            $order = Order::create([
                'user_id'    => auth()->id(),
                'total_price' => $grandTotal,
                'status'     => 'pending',
                'order_date' => now(),
                'notes'      => $request->notes,
            ]);

            foreach ($carts as $cart) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $cart->product_id,
                    'quantity'   => $cart->quantity,
                    'price'      => $cart->product->price,
                ]);

                // Reduce stock
                $cart->product->decrement('stock', $cart->quantity);
            }

            Shipment::create([
                'order_id'     => $order->id,
                'address'      => $request->address,
                'courier'      => $request->courier,
                'shipping_cost' => $shippingCost,
                'status'       => 'pending',
            ]);

            Payment::create([
                'order_id'       => $order->id,
                'payment_method' => $request->payment_method,
                'payment_status' => 'unpaid',
            ]);

            // Clear cart
            Cart::where('user_id', auth()->id())->delete();
        });

        return redirect()->route('orders.index')
            ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
    }

    public function cancel(Order $order)
    {
        $this->authorize('cancel', $order);

        if (!in_array($order->status, ['pending', 'processing'])) {
            return redirect()->back()->with('error', 'Order tidak dapat dibatalkan!');
        }

        // Restore stock
        foreach ($order->orderItems as $item) {
            $item->product->increment('stock', $item->quantity);
        }

        $order->update(['status' => 'cancelled']);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Pesanan berhasil dibatalkan!');
    }

    private function getShippingCost(string $courier): float
    {
        return match($courier) {
            'JNE'     => 15000,
            'J&T'     => 12000,
            'TIKI'    => 14000,
            'SiCepat' => 10000,
            default   => 10000,
        };
    }
}