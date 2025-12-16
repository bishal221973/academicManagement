<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\HostelFeature;
use App\Models\HostelStudent;
use App\Models\Room;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HostelFeatureController extends Controller
{
    public function index()
    {
        $features = HostelFeature::latest()->get();
        return Inertia::render('Hostel/HostelFeature', [
            'menu' => 'AddStudent',
            'sidebar' => 'Hostel',
            'features' => $features,
            'hostelFeature' => new HostelFeature(),
        ]);
    }

    public function store(Request $request){
        $data=$request->validate(HostelFeature::rules());
        HostelFeature::create($data);

        return redirect()->back()->with('success',"New facility have been saved.");
    }

    public function edit(HostelFeature $hostelFeature)
    {
        $features = HostelFeature::latest()->get();
        return Inertia::render('Hostel/HostelFeature', [
            'menu' => 'AddStudent',
            'sidebar' => 'Hostel',
            'features' => $features,
            'hostelFeature' => $hostelFeature,
        ]);
    }

    public function update(Request $request, HostelFeature $hostelFeature){
        $data=$request->validate(HostelFeature::rules());
        $hostelFeature->update($data);

        return redirect()->route('hostelFeature.index')->with('success',"Selected facility have been updated.");
    }
    
    public function destroy($id){
        HostelFeature::find($id)->delete();
        return redirect()->route('hostelFeature.index')->with('success',"Selected facility have been removed.");
    }

    public function updateStatus(HostelFeature $hostelFeature)
    {
        $hostelFeature->update([
            'status' => !$hostelFeature->status
        ]);
        // event(new CourseEvent());
        return response()->json([
            'message' => 'Status updated successfully'
        ]);
    }
}
