<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::latest()->get()->map(function ($student) {
            $student->registration_date = formatDate($student->registration_date);
            $student->birth_date = formatDate($student->birth_date);

            return $student;
        });
        return inertia('Student/List', [
            'menu' => 'Student',
            'sidebar' => 'Students',
            'students' => $students,
            'student' => new Student(),
        ]);
    }

    public function store(Request $request)
    {
        // return $request;
        $data = $request->validate(Student::rules());
        if($request->hasFile('transfer_certificate')){
            // $file=$request->file('transfer_certificate');
            // $fileName=time().'_'.$file->getClientOriginalName();
            // $filePath=$file->storeAs('students',$fileName,'public');
            $data['transfer_certificate']=$request->file('transfer_certificate')->store('students','public');
        }
        try {
            Student::create($data);
            return redirect()->back()->with('success', 'New student saved successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

     public function edit(Student $student)
    {
        $students = Student::latest()->get()->map(function ($item) {
            $item->registration_date = formatDate($item->registration_date);
            $item->birth_date = formatDate($item->birth_date);

            return $item;
        });
        $student->registration_date = formatDate($student->registration_date);
        $student->birth_date = formatDate($student->birth_date);
        return inertia('Student/List', [
            'menu' => 'Student',
            'sidebar' => 'Students',
            'students' => $students,
            'student' => $student,
        ]);
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->validate(Student::rules());

        try {
            $student->update($data);
            return redirect()->route('student.index')->with('success', 'Student update successfully');
        } catch (\Throwable $th) {
            return redirect()->route('student.index')->with('error', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        Student::find($id)->delete();
        return redirect()->route('student.index')->with('success', 'Student deleted successfully');
    }

}
