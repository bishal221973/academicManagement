<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaxController extends Controller
{
    public function index()
    {
        $taxes = Tax::get();
        return Inertia::render('Config/Tax', [
            'sidebar' => 'Settings',
            'menu' => 'Tax',
            'taxes' => $taxes,
            'tax'=>new Tax(),
        ]);
    }

    public function all()
    {
        $taxes = Tax::where('status',true)->get();
        return response()->json([
            'taxes'=>$taxes
        ]);
    }

    public function store(Request $request){
        $data=$request->validate(Tax::rules());
        Tax::create($data);

        return redirect()->back()->with('success',"New tax have been created");
    }

    public function status($id){
        $tax=Tax::find($id);

        $tax->update([
            'status'=>!$tax->status,
        ]);

        return response()->json([
            'message' => 'Status updated successfully'
        ]);
    }

    public function edit(Tax $tax)
    {
        $taxes = Tax::get();
        return Inertia::render('Config/Tax', [
            'sidebar' => 'Settings',
            'menu' => 'Tax',
            'taxes' => $taxes,
            'tax'=>$tax,
        ]);
    }

    public function update(Request $request,Tax $tax){
        $data=$request->validate(Tax::rules($tax->id));
        $tax->update($data);

        return redirect()->route('tax.index')->with('success',"New tax have been created");
    }


    public function delete($id){
        Tax::find($id)->delete();

        return redirect()->route('tax.index')->with('success','Selected tax have been removed');
    }
}
