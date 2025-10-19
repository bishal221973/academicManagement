<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Transfer;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function index()
    {

$students = Student::query()
            ->latest()
            ->where('status', 1)
            ->where('is_transfered', 1)
            ->get();

        
        return inertia('Student/Transfer', [
            'menu' => 'Transfer',
            'sidebar' => 'Students',
            'students'=>$students,
        ]);
    }


    public function transfer(Request $request)
    {
        $data = $request->validate(Transfer::rules());

        $student = Student::query();

        if (!empty($data['course_id'])) {
            $student->where('course_id', $data['course_id']);
        }

        if (!empty($data['section_id'])) {
            $student->where('section_id', $data['section_id']);
        }

        if (!empty($data['student_id']) || $data['student_id'] !=null) {
            $student->where('id', $data['student_id']);
        }

        // Create transfer record
        Transfer::create($data);

        // Update matching students
        $student->update([
            'is_transfered' => true,
        ]);

        return redirect()->back()->with('success', 'Student Transferred Successfully.');
    }
}
