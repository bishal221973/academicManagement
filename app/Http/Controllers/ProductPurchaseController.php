<?php

namespace App\Http\Controllers;

use App\Models\ProductPurchase;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductPurchaseController extends Controller
{
    public function index()
    {
        $purchases = ProductPurchase::with('product','supplier')->latest()->get();
        return Inertia::render("Inventory/Purchase", [
            'menu' => 'Purchase',
            'sidebar' => 'Inventory',
            'purchases' => $purchases,
            'purchase' => new ProductPurchase(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate(ProductPurchase::rules());
        ProductPurchase::create($data);
        return redirect()->back()->with('success', "New purchase have been saved.");
    }
}
