<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function show(Order $order)
    {
        if (!Gate::allows('view', $order)) {
            abort(403);
        }
        $order->load(['payment', 'shipment']);
        return view('payments.show', compact('order'));
    }

    public function upload(Request $request, Order $order)
    {
        if (!Gate::allows('view', $order)) {
            abort(403);
        }

        $request->validate([
            'proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('proof')->store('payments', 'public');

        $order->payment()->update([
            'proof'          => $path,
            'payment_status' => 'paid',
            'payment_date'   => now(),
        ]);

        $order->update(['status' => 'processing']);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Bukti pembayaran berhasil diunggah!');
    }
}