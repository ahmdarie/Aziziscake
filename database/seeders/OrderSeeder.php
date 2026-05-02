<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Shipment;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $customers = User::where('role', 'customer')->get();
        $products  = Product::all();
        $statuses  = ['pending', 'processing', 'shipped', 'completed', 'completed', 'completed'];
        $couriers  = ['JNE', 'J&T', 'SiCepat', 'TIKI'];
        $methods   = ['bank_transfer', 'e_wallet', 'cod'];

        foreach ($customers as $customer) {
            $numOrders = rand(1, 3);
            for ($i = 0; $i < $numOrders; $i++) {
                $status   = $statuses[array_rand($statuses)];
                $courier  = $couriers[array_rand($couriers)];
                $method   = $methods[array_rand($methods)];
                $shipping = match($courier) {
                    'JNE' => 15000, 'J&T' => 12000, 'SiCepat' => 10000, default => 14000,
                };

                // Pick 1–3 random products
                $picked = $products->random(rand(1, 3));
                $itemsTotal = 0;
                $itemsData  = [];
                foreach ($picked as $product) {
                    $qty = rand(1, 3);
                    $itemsTotal += $product->price * $qty;
                    $itemsData[] = ['product' => $product, 'qty' => $qty];
                }
                $grandTotal = $itemsTotal + $shipping;

                $order = Order::create([
                    'user_id'    => $customer->id,
                    'total_price' => $grandTotal,
                    'status'     => $status,
                    'order_date' => now()->subDays(rand(1, 60)),
                    'notes'      => null,
                ]);

                foreach ($itemsData as $data) {
                    OrderItem::create([
                        'order_id'   => $order->id,
                        'product_id' => $data['product']->id,
                        'quantity'   => $data['qty'],
                        'price'      => $data['product']->price,
                    ]);
                }

                Shipment::create([
                    'order_id'       => $order->id,
                    'address'        => $customer->address,
                    'courier'        => $courier,
                    'tracking_number' => strtoupper($courier) . rand(100000, 999999),
                    'shipping_cost'  => $shipping,
                    'status'         => in_array($status, ['shipped', 'completed']) ? 'delivered' : 'pending',
                ]);

                Payment::create([
                    'order_id'       => $order->id,
                    'payment_method' => $method,
                    'payment_status' => $status === 'completed' ? 'paid' : ($status === 'cancelled' ? 'failed' : 'unpaid'),
                    'payment_date'   => $status === 'completed' ? now()->subDays(rand(1, 30)) : null,
                ]);
            }
        }
    }
}