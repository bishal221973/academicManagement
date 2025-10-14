<?php

namespace App\Http\Controllers;

use App\Models\Hostel;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HostelController extends Controller
{
    public function index(){
        $hostels=Hostel::latest()->get();
        return Inertia::render('Hostel/Hostel',[
            'hostels'=>$hostels,
            'hostel'=>new Hostel(),
            'menu' => 'Hostel',
            'sidebar' => 'Hostel',
        ]);
    }

    public function store(Request $request){
        $data=$request->validate(Hostel::rules());

        Hostel::create($data);

        return redirect()->back()->with('success',"New hostel have been saved."); 
    }

    public function updateStatus(Hostel $hostel)
    {
        $hostel->update([
            'status' => !$hostel->status
        ]);
        // event(new CourseEvent());
        return response()->json([
            'message' => 'Status updated successfully'
        ]);
    }

    public function edit(Hostel $hostel){
        $hostels=Hostel::latest()->get();
        return Inertia::render('Hostel/Hostel',[
            'hostels'=>$hostels,
            'hostel'=>$hostel,
            'menu' => 'Hostel',
            'sidebar' => 'Hostel',
        ]);
    }

    public function update(Request $request, Hostel $hostel){
        $data=$request->validate(Hostel::rules());

        $hostel->update($data);

        return redirect()->route('hostel.index')->with('success',"Selected hostel have been updated."); 
    }

    public function destroy($id){
        Hostel::find($id)->delete();

                return redirect()->route('hostel.index')->with('success',"Selected hostel have been removed."); 
    }
}
