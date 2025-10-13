<?php

namespace App\Http\Controllers;

use App\Models\Icard;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IcardController extends Controller
{
    public function index()
    {
        $icards=Icard::latest()->get();
        return Inertia::render('Config/Icard', [
            'sidebar' => 'Settings',
            'menu' => 'Icard',
            'icards'=>$icards,
        ]);
    }
    public function default(){
        $icard=Icard::where('is_active',1)->first();

        return response()->json([
            'icard'=>$icard
        ]);
    }
    public function update($id){
        Icard::query()->update([
            'is_active'=>false,
        ]);

        Icard::find($id)->update([
            'is_active'=>true
        ]);

        return redirect()->route('icard.index')->with('success','ID Card theme have been selected');
    }
}
