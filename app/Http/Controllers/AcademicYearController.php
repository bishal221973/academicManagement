<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AcademicYearController extends Controller
{
    public function index(){
         $academicYears = AcademicYear::latest()
            ->get();
        return Inertia::render("Config/AcademyYear",[

            'academicYears'=>$academicYears,
            'sidebar' => 'Settings',
            'menu' => 'AcademicYear',
        ]);
    }

    public function store(Request $request){
        $data=$request->validate(AcademicYear::rules());

        $data['status']=false;
        AcademicYear::create($data);

        return redirect()->back()->with('success',"New academic year have been saved.");
    }

    public function edit(AcademicYear $academicYear){
        $academicYears = AcademicYear::latest()
            ->get();
        return Inertia::render("Config/AcademyYear",[

            'academicYears'=>$academicYears,
            'academicYear'=>$academicYear
        ]);
    }

    public function update(Request $request, AcademicYear $academicYear){
        $data=$request->validate(AcademicYear::rules());
        $academicYear->update($data);

        return redirect()->route('academic.year')->with('success',"Selected academic year have been changed.");
    }

    public function delete(AcademicYear $academicYear){
        
        $academicYear->delete();

        return redirect()->route('academic.year')->with('success',"Selected academic year have been removed.");
    }

    public function status(AcademicYear $academicYear){
        AcademicYear::query()->update([
            'status'=>false
        ]);
        $academicYear->update([
            'status'=>!$academicYear->status
        ]);

        return response()->json([
            'success'=>true
        ]);
    }
}
