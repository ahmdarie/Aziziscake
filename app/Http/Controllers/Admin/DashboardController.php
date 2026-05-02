<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts  = Product::count();
        $totalOrders    = Order::count();
        $totalRevenue   = Order::where('status', 'completed')->sum('total_price');
        $totalCustomers = User::where('role', 'customer')->count();

        $recentOrders = Order::with(['user', 'payment'])
            ->latest()
            ->take(10)
            ->get();

        $monthlyRevenue = Order::where('status', 'completed')
            ->selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts', 'totalOrders', 'totalRevenue',
            'totalCustomers', 'recentOrders', 'monthlyRevenue'
        ));
    }
}