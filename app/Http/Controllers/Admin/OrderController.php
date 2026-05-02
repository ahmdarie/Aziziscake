<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with(['user', 'payment'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->search, function ($q) use ($request) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%{$request->search}%"));
            })
            ->latest()
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product', 'shipment', 'payment']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status order berhasil diperbarui!');
    }

    public function updateShipment(Request $request, Order $order)
    {
        $request->validate([
            'courier'         => 'required|string',
            'tracking_number' => 'nullable|string',
            'shipping_cost'   => 'required|numeric|min:0',
        ]);

        $order->shipment()->updateOrCreate(
            ['order_id' => $order->id],
            [
                'address'         => $order->shipment->address ?? $order->user->address,
                'courier'         => $request->courier,
                'tracking_number' => $request->tracking_number,
                'shipping_cost'   => $request->shipping_cost,
                'status'          => 'shipped',
            ]
        );

        $order->update(['status' => 'shipped']);

        return redirect()->back()->with('success', 'Data pengiriman berhasil diperbarui!');
    }
}