<?php

namespace App\Http\Controllers;

use App\Models\BillItem;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductPurchase;
use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SellController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::latest()->get();
        $products = Product::with('category', 'unit')->latest()->get();
        return Inertia::render("Inventory/Sell", [
            'menu' => 'Sell',
            'sidebar' => 'Inventory',
            'categories' => $categories,
            'products' => $products,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sub_total' => 'required',
            'discountAmt' => 'nullable',
            'grandTotal' => 'required',
            'orderList' => 'required',
            'student_id' => 'required',
        ]);

        $student = Student::find($request->student_id);

        $billing = $student->billings()->create([
            'student_id' => $student->id,
            'academic_year_id' => $student->academic_year_id,
            'bill_no' => rand(0000000, 999999) . $student->id,
            'sub_total' => $request->sub_total ?? 0,
            'net_total' => $request->sub_total ?? 0,
            'total_tax' => 0,
            'total_amount' => $request->grandTotal,
            'discount' => $request->discountAmt,
        ]);

        foreach($request->orderList as $orderList){
            // return $orderList;
            $bill = BillItem::create([
                'student_id' => $student->id,
                'academic_year_id' => $student->academic_year_id,
                'bill_id' => $billing->id,
                'title' => "Null",
                'product_id'=>$orderList['id'],
                'amount' => $orderList['rate'] ?? 0,
                'qty' => $orderList['qty'] ?? 0,
            ]);

             $product=Product::find($orderList['id']);

            $product->update([
                'qty'=>$product->qty-(int)$orderList['qty']
            ]);
        }

        return redirect()->route('sell.index')->with('success',"Purchase successfull");
    }
}
