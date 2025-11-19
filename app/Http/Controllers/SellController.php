<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductPurchase;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SellController extends Controller
{
     public function index()
    {
        $categories = ProductCategory::latest()->get();
        $products = Product::latest()->get();
        return Inertia::render("Inventory/Sell", [
            'menu' => 'Sell',
            'sidebar' => 'Inventory',
            'categories' => $categories,
            'products'=>$products,
        ]);
    }
}
