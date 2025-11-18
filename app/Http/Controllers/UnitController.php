<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UnitController extends Controller
{
    public function index(){
        $units=Unit::latest()->get();
        return Inertia::render("Inventory/Unit",[
            'menu'=>'Unit',
            'sidebar' => 'Inventory',
            'units'=>$units,
            'unit'=>new Unit(),
        ]);
    }

    public function store(Request $request){
        $data=$request->validate(Unit::rules());
        Unit::create($data);
        return redirect()->back()->with('success',"New unit have been saved.");
    }

    public function updateStatus($id){
        $unit=Unit::find($id);
        $unit->update([
            'status'=>!$unit->status,
        ]);

        return response()->json([
            'success'=>true,
        ]);
    }

    public function edit(Unit $unit){
        $units=Unit::latest()->get();
        return Inertia::render("Inventory/Unit",[
            'menu'=>'Unit',
            'sidebar' => 'Inventory',
            'units'=>$units,
            'unit'=>$unit,
        ]);
    }

    public function update(Request $request,Unit $unit){
        $data=$request->validate(Unit::rules($unit->id));
        $unit->update($data);
        return redirect()->route('unit.index')->with('success',"New unit have been saved.");
    }
    
    public function destroy($id){
        Unit::find($id)->delete();
        return redirect()->route('unit.index')->with('success',"New unit have been saved.");
    }
}
