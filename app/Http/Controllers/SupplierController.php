<?php

namespace App\Http\Controllers;

use App\Events\SupplierEvent;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->get();
        return Inertia::render("Inventory/Supplier", [
            'menu' => 'Supplier',
            'sidebar' => 'Inventory',
            'suppliers' => $suppliers,
            'supplier' => new Supplier(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate(Supplier::rules());
        Supplier::create($data);
        event(new SupplierEvent);
        return redirect()->back()->with('success', "New supplier have been saved.");
    }

    public function updateStatus($id)
    {
        $Supplier = Supplier::find($id);
        $Supplier->update([
            'status' => !$Supplier->status,
        ]);
        event(new SupplierEvent);

        return response()->json([
            'success' => true,
        ]);
    }

    public function edit(Supplier $supplier)
    {
        $suppliers = Supplier::latest()->get();
        return Inertia::render("Inventory/Supplier", [
            'menu' => 'Supplier',
            'sidebar' => 'Inventory',
            'suppliers' => $suppliers,
            'supplier' => $supplier,
        ]);
    }

    public function update(Request $request, Supplier $supplier)
    {
        $data = $request->validate(Supplier::rules($supplier->id));
        $supplier->update($data);
        event(new SupplierEvent);

        return redirect()->route('supplier.index')->with('success', "New supplier have been saved.");
    }

    public function destroy($id)
    {
        Supplier::find($id)->delete();
        event(new SupplierEvent);

        return redirect()->route('supplier.index')->with('success', "New supplier have been saved.");
    }

    public function getSupplier()
    {
        return response()->json([
            'suppliers' => Supplier::where('status', 1)->latest()->get()
        ]);
    }
}
