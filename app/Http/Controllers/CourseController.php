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

    public function getCourse(Request $request)
    {
        $courses = [];
        if ($request->group_id) {
            $groupIds = $this->getGroupWithChildrenIds($request->group_id);

            $courses = Course::whereIn('group_id', $groupIds)
                ->latest()
                ->get();
        }
        return response()->json([
            'courses' => $courses
        ]);
    }
    private function getGroupWithChildrenIds($groupId)
    {
        $ids = [$groupId];

        $children = \App\Models\Group::where('parent_id', $groupId)->pluck('id');

        foreach ($children as $childId) {
            $ids = array_merge($ids, $this->getGroupWithChildrenIds($childId));
        }

        return $ids;
    }
    public function findCourse($id)
    {
        $course = Course::find($id);
        return response()->json([
            'course' => $course
        ]);
    }
}
