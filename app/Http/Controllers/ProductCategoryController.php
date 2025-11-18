<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductCategoryController extends Controller
{
    public function index(){
        $productCategories=ProductCategory::latest()->get();
        return Inertia::render("Inventory/ProductCategory",[
            'menu'=>'ProductCategory',
            'sidebar' => 'Inventory',
            'productCategories'=>$productCategories,
            'productCategory'=>new ProductCategory(),
        ]);
    }

    public function store(Request $request){
        $data=$request->validate(ProductCategory::rules());
        ProductCategory::create($data);
        return redirect()->back()->with('success',"New category have been saved.");
    }

    public function updateStatus($id){
        $productCategory=ProductCategory::find($id);
        $productCategory->update([
            'status'=>!$productCategory->status,
        ]);

        return response()->json([
            'success'=>true,
        ]);
    }

    public function edit(ProductCategory $productCategory){
        $productCategories=ProductCategory::latest()->get();
        return Inertia::render("Inventory/ProductCategory",[
            'menu'=>'ProductCategory',
            'sidebar' => 'Inventory',
            'productCategories'=>$productCategories,
            'productCategory'=>$productCategory,
        ]);
    }

    public function update(Request $request,ProductCategory $productCategory){
        $data=$request->validate(ProductCategory::rules());
        $productCategory->update($data);
        return redirect()->route('productCategory.index')->with('success',"New category have been saved.");
    }
    
    public function destroy($id){
        ProductCategory::find($id)->delete();
        return redirect()->route('productCategory.index')->with('success',"New category have been saved.");
    }
}
