<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
     public function index()
    {
        $subjects = Subject::with('course')->latest()->get();
        return inertia('Config/Subject', [
            'menu' => 'Subject',
            'sidebar' => 'Academic',
            'subjects' => $subjects,
            'subject' => new Subject(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate(Subject::rules());
        try {
            Subject::create($data);
            // event(new CourseEvent());
            return redirect()->back()->with('success', 'Subject created successfully');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateStatus(Subject $subject)
    {
        $subject->update([
            'status' => !$subject->status
        ]);
        // event(new CourseEvent());
        return response()->json([
            'message' => 'Status updated successfully'
        ]);
    }

    public function edit(Subject $subject)
    {
        $subjects = Subject::with('course')->latest()->get();
        return inertia('Config/Subject', [
            'menu' => 'Subject',
            'sidebar' => 'Academic',
            'subjects' => $subjects,
            'subject' => $subject,
        ]);
    }
    public function update(Request $request, Subject $subject)
    {
        $data = $request->validate(Subject::rules($subject->id));
        try {
            $subject->update($data);
            // event(new CourseEvent());
            return redirect()->route('subject.index')->with('success', 'Subject updated successfully');
        } catch (\Throwable $th) {
            return redirect()->route('subject.index')->with('error', $th->getMessage());
        }
    }
    public function destroy($id)
    {
        Subject::find($id)->delete();
        // event(new CourseEvent());
        return redirect()->route('subject.index')->with('success', 'Subject deleted successfully');
    }

    public function getSubject()
    {
        return response()->json([
            'groups' => Subject::where('status', 1)->latest()->get()
        ]);
    }
}
