<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StoreController extends Controller
{
    public function index(){
        $stores=Store::latest()->get();
        return Inertia::render("Inventory/Store",[
            'menu'=>'Store',
            'sidebar' => 'Inventory',
            'stores'=>$stores,
            'store'=>new Store(),
        ]);
    }

    public function store(Request $request){
        $data=$request->validate(Store::rules());
        Store::create($data);
        return redirect()->back()->with('success',"New store have been saved.");
    }

    public function updateStatus($id){
        $store=Store::find($id);
        $store->update([
            'status'=>!$store->status,
        ]);

        return response()->json([
            'success'=>true,
        ]);
    }

    public function edit(Store $store){
        $stores=Store::latest()->get();
        return Inertia::render("Inventory/Store",[
            'menu'=>'Store',
            'sidebar' => 'Inventory',
            'stores'=>$stores,
            'store'=>$store,
        ]);
    }

    public function update(Request $request,Store $store){
        $data=$request->validate(Store::rules());
        $store->update($data);
        return redirect()->route('store.index')->with('success',"New store have been saved.");
    }
    
    public function destroy($id){
        Store::find($id)->delete();
        return redirect()->route('store.index')->with('success',"New store have been saved.");
    }
}
