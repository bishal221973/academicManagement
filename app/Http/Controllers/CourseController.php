<?php

namespace App\Http\Controllers;

use App\Events\CourseEvent;
use App\Models\Course;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::latest()->get();
        return inertia('Config/Course', [
            'menu' => 'Course',
            'sidebar' => 'Academic',
            'courses' => $courses,
            'course' => new Course(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate(Course::rules());
        try {
            Course::create($data);
            event(new CourseEvent());
            return redirect()->back()->with('success', 'Course created successfully');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateStatus(Course $course)
    {
        $course->update([
            'status' => !$course->status
        ]);
        event(new CourseEvent());
        return response()->json([
            'message' => 'Status updated successfully'
        ]);
    }

    public function edit(Course $course)
    {
        $courses = Course::latest()->get();
        return inertia('Config/Course', [
            'menu' => 'Course',
            'sidebar' => 'Academic',
            'courses' => $courses,
            'course' => $course,
        ]);
    }
    public function update(Request $request, Course $course)
    {
        $data = $request->validate(Course::rules($course->id));
        try {
            $course->update($data);
            event(new CourseEvent());
            return redirect()->route('course.index')->with('success', 'Course updated successfully');
        } catch (\Throwable $th) {
            return redirect()->route('course.index')->with('error', $th->getMessage());
        }
    }
    public function destroy($id)
    {
        Course::find($id)->delete();
        event(new CourseEvent());
        return redirect()->route('course.index')->with('success', 'Course deleted successfully');
    }

    public function getCourse()
    {
        return response()->json([
            'courses' => Course::where('status', 1)->latest()->get()
        ]);
    }
}
