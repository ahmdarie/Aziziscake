<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with('brand')
            ->where('stock', '>', 0)
            ->inRandomOrder()
            ->take(8)
            ->get();

        $brands = Brand::withCount('products')->take(5)->get();

        return view('home', compact('featuredProducts', 'brands'));
    }
}