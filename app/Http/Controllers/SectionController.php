<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index(){
        $sections=Section::with('course')->latest()->get();
        return inertia('Config/Section',[
            'menu'=>'Section',
            'sidebar' => 'Academic',
            'sections'=>$sections,
            'section'=>new Section(),
        ]);
    }

    public function store(Request $request){
        $data = $request->validate(Section::rules());
        try {
            Section::create($data);
            return redirect()->back()->with('success', 'Section created successfully');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
     public function updateStatus(Section $section)
    {
        $section->update([
            'status' => !$section->status
        ]);
        // event(new CourseEvent());
        return response()->json([
            'message' => 'Status updated successfully'
        ]);
    }

    public function edit(Section $section){
        $sections=Section::with('course')->latest()->get();
        return inertia('Config/Section',[
            'menu'=>'Section',
            'sidebar' => 'Academic',
            'sections'=>$sections,
            'section'=>$section,
        ]);
    }
    public function update(Request $request, Section $section){
        $data = $request->validate(Section::rules($section->id));
        try {
            $section->update($data);
            return redirect()->route('section.index')->with('success', 'Section updated successfully');
        } catch (\Throwable $e) {
            return redirect()->route('section.index')->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        Section::find($id)->delete();
        // event(new CourseEvent());
        return redirect()->route('section.index')->with('success', 'Section deleted successfully');
    }
}
