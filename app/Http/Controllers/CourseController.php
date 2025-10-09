<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(){
        $courses=Course::latest()->get();
        return inertia('Config/Course',[
            'sidebar'=>'Course',
            'courses'=>$courses,
            'course'=>new Course(),
        ]);
    }

    public function store(Request $request){
        $data=$request->validate(Course::rules());
        Course::create($data);
        return redirect()->back();
    }

    public function updateStatus(Course $course){
        $course->update([
            'status'=>!$course->status
        ]);
        return response()->json([
            'message'=>'Status updated successfully'
        ]);
    }

    public function edit(Course $course){
        $courses=Course::latest()->get();
        return inertia('Config/Course',[
            'sidebar'=>'Course',
            'courses'=>$courses,
            'course'=>$course,
        ]);
    }
    public function update(Request $request, Course $course){
        $data=$request->validate(Course::rules($course->id));
        $course->update($data);
        return redirect()->route('course.index');
    }
}
