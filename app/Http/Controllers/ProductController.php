<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index(){
        $products=Product::with('category','unit')->latest()->get();
        return Inertia::render("Inventory/Product",[
            'menu'=>'Product',
            'sidebar' => 'Inventory',
            'products'=>$products,
            'product'=>new Product(),
        ]);
    }

    public function store(Request $request){
        $data=$request->validate(Product::rules());
        Product::create($data);
        return redirect()->back()->with('success',"New product have been saved.");
    }

    public function updateStatus($id){
        $product=Product::find($id);
        $product->update([
            'status'=>!$product->status,
        ]);

        return response()->json([
            'success'=>true,
        ]);
    }

    public function edit(Product $product){
        // return $product;
        $products=Product::with('category','unit')->latest()->get();
        return Inertia::render("Inventory/Product",[
            'menu'=>'Product',
            'sidebar' => 'Inventory',
            'products'=>$products,
            'product'=>$product,
        ]);
    }

    public function update(Request $request,Product $product){
        // return "Hello";
        $data=$request->validate(Product::rules($product->id));
        $product->update($data);
        return redirect()->route('product.index')->with('success',"New product have been saved.");
    }
    
    public function destroy($id){
        Product::find($id)->delete();
        return redirect()->route('product.index')->with('success',"New product have been saved.");
    }
}
