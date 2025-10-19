<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FormatExport;
use App\Imports\StudentImport;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('course')
            ->latest()
            ->get()
            ->map(function ($student) {
                $student->registration_date = $student->registration_date ? formatDate($student->registration_date) : null;
                $student->birth_date = $student->birth_date ? formatDate($student->birth_date) : null;

                return $student;
            });

        return inertia('Student/List', [
            'menu' => 'Student',
            'sidebar' => 'Students',
            'students' => $students,
            'student' => new Student(),
        ]);
    }

    public function all(Request $request)
    {
        $students = Student::query()
            ->latest()
            ->where('status', 1)
            ->where('is_transfered', 0);

        if ($request->filled('section_id')) {
            $students->where('section_id', $request->section_id);
            $students = $students->get();
        } else {
            // If no section_id, return null directly
            $students = null;
        }

        return response()->json([
            'students' => $students,
        ]);
    }


    public function store(Request $request)
    {
        // return $request;
        $data = $request->validate(Student::rules());
        if ($request->hasFile('transfer_certificate')) {
            // $file=$request->file('transfer_certificate');
            // $fileName=time().'_'.$file->getClientOriginalName();
            // $filePath=$file->storeAs('students',$fileName,'public');
            $data['transfer_certificate'] = $request->file('transfer_certificate')->store('students', 'public');
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
        $students = Student::with('course')->latest()->get()->map(function ($item) {
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

    public function icard()
    {
        $students = Student::with('course')->latest();

        if (request('course_id')) {
            $students = $students->where('course_id', request('course_id'));
        }
        if (request('section_id')) {
            $students = $students->where('section_id', request('section_id'));
        }
        $students = $students->get();

        return inertia('Student/IDCard', [
            'menu' => 'ICard',
            'sidebar' => 'Students',
            'students' => $students,
        ]);
    }

    public function import(Request $request)
    {
        $students = Student::with('course')
            ->latest()
            ->get()
            ->map(function ($student) {
                $student->registration_date = $student->registration_date ? formatDate($student->registration_date) : null;
                $student->birth_date = $student->birth_date ? formatDate($student->birth_date) : null;

                return $student;
            });

        return inertia('Student/Import', [
            'menu' => 'Import',
            'sidebar' => 'Students',
            'students' => $students,
            'student' => new Student(),
        ]);
    }

    public function importFormat()
    {
        // return "Hello";
        return Excel::download(
            new FormatExport,       // 👈 Your Export class
            'format.xlsx',          // 👈 Filename
        );
    }

    public function importStudent(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
            'course_id' => 'required',
            'section_id' => 'nullable',
        ]);

        Excel::import(new StudentImport($request->course_id, $request->section_id), $request->file('file'));

        return back()->with('success', 'Students imported successfully.');
    }
}
