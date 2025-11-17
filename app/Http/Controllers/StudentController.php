<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FormatExport;
use App\Imports\StudentImport;
use App\Models\AcademicYear;
use App\Models\Bill;
use App\Models\Course;
use App\Models\StudentTutionFee;
use Carbon\Carbon;

class StudentController extends Controller
{
    public function index()
    {
        $academyYear = AcademicYear::where('status', true)->first();
        if (!$academyYear) {
            return redirect()->back()->with('error', "Please active an academy year");
        }
        $students = Student::with('course')
            ->latest()
            ->get()
            ->where('academic_year_id', $academyYear->id)
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
        $academyYear = AcademicYear::where('status', true)->first();
        if (!$academyYear) {
            return redirect()->back()->with('error', "Please active an academy year");
        }
        $students = Student::query()
            ->latest()
            ->where('academic_year_id', $academyYear->id)
            ->where('status', 1)
            ->where('is_transfered', 0);

        if ($request->filled('section_id')) {
            $students = $students->where('section_id', $request->section_id);
            // $students = $students->get();
        } elseif ($request->filled('course_id')) {
            $students = $students->where('course_id', $request->course_id);
            // $students = $students->get();
        } elseif ($request->is_for_hostel_room) {
            $students = $students->whereDoesntHave('hostelStudent');
        } else {
            // If no section_id, return null directly
            $students = null;
            return response()->json([
                'students' => $students,
            ]);
        }

        $students = $students->get();
        return response()->json([
            'students' => $students,
        ]);
    }
    public function hostelAll(Request $request)
    {
        $academyYear = AcademicYear::where('status', true)->first();
        if (!$academyYear) {
            return redirect()->back()->with('error', "Please active an academy year");
        }
        $students = Student::query()
    ->latest()
    ->where(function ($query) use ($academyYear) {
        $query->where('academic_year_id', $academyYear->id)
              ->where('status', 1)
              ->where('is_transfered', 0);
    })
    ->where(function ($query) {
        $query->whereDoesntHave('hostelStudents') // no hostel record
              ->orWhereHas('hostelStudents', function ($subQuery) {
                  $subQuery->whereDate('check_out_date', '<', Carbon::today());
              }); // or checkout before today
    });
        // $students =$students->whereDoesntHave('hostelStudent');
        if ($request->filled('section_id')) {
            $students = $students->where('section_id', $request->section_id);
            // $students = $students->get();
        } elseif ($request->filled('course_id')) {
            $students = $students->where('course_id', $request->course_id);
            // $students = $students->get();
        } else {
            // If no section_id, return null directly
            $students = null;
            return response()->json([
                'students' => $students,
            ]);
        }

        $students = $students->get();
        return response()->json([
            'students' => $students,
        ]);
    }


    public function store(Request $request)
    {
        // return $request;
        $academyYear = AcademicYear::where('status', true)->first();
        if (!$academyYear) {
            return redirect()->back()->with('error', "Please active an academy year");
        }
        $data = $request->validate(Student::rules());
        $data['academic_year_id'] = $academyYear->id;
        if ($request->hasFile('transfer_certificate')) {
            $data['transfer_certificate'] = $request->file('transfer_certificate')->store('students', 'public');
        }
        if($request->hasFile('profile')){
            $data['profile']=$request->file('profile')->store('studentProfile','public');
        }
        $data['admission_fee']=$request->admition_fees ?? 0;
        try {
            $student=Student::create($data);

            if($request->months){
                $course=Course::find($request->course_id);
                foreach($request->months as $month){
                    StudentTutionFee::create([
                        'student_id'=>$student->id,
                        'academic_year_id'=>$student->academic_year_id,
                        'month'=>$month,
                        'amount'=>$course->fees,
                    ]);
                }
            }
            return redirect()->back()->with('success', 'New student saved successfully');
        } catch (\Throwable $th) {
            return $th->getMessage();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function show($studentId)
    {
        $academyYear = AcademicYear::where('status', true)->first();
        if (!$academyYear) {
            return redirect()->back()->with('error', "Please active an academy year");
        }
        $student = Student::with('course')->where('id', $studentId)
            ->where('academic_year_id', $academyYear->id)
            ->first();

        if ($student) {
            $student->registration_date = $student->registration_date ? formatDate($student->registration_date) : null;
            $student->birth_date = $student->birth_date ? formatDate($student->birth_date) : null;
        }

        return inertia('Student/Show', [
            'menu' => 'Student',
            'sidebar' => 'Students',
            'student' => $student->load('section','group','bills.items','hostels.hostel','hostels.room'),
        ]);
    }

    public function edit(Student $student)
    {
        
        $academyYear = AcademicYear::where('status', true)->first();
        if (!$academyYear) {
            return redirect()->back()->with('error', "Please active an academy year");
        }
        $students = Student::with('course')->latest()->get()->map(function ($item) {
            $item->registration_date = formatDate($item->registration_date);
            $item->birth_date = formatDate($item->birth_date);

            return $item;
        });
        $student->registration_date = formatDate($student->registration_date);
        $student->birth_date = formatDate($student->birth_date);
        $bill=Bill::orderBy('id','asc')->where('student_id',$student->id)->first();
        return inertia('Student/List', [
            'menu' => 'Student',
            'sidebar' => 'Students',
            'students' => $students,
            'student' => $student->load('studentTuitionFees'),
            'bill'=>$bill,
        ]);
    }

    public function update(Request $request, Student $student)
    {
        $academyYear = AcademicYear::where('status', true)->first();
        if (!$academyYear) {
            return redirect()->back()->with('error', "Please active an academy year");
        }
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
        $academyYear = AcademicYear::where('status', true)->first();
        if (!$academyYear) {
            return redirect()->back()->with('error', "Please active an academy year");
        }
        Student::find($id)->delete();
        return redirect()->route('student.index')->with('success', 'Student deleted successfully');
    }

    public function icard()
    {
        $academyYear = AcademicYear::where('status', true)->first();
        if (!$academyYear) {
            return redirect()->back()->with('error', "Please active an academy year");
        }
        $students = Student::where('academic_year_id', $academyYear->id)->with('course')->latest();

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

    public function uploadCitizenship(Request $request, $id){
        $student=Student::find($id);

        if($request->hasFile('front')){
            $data['nationality_card_front']=$request->file('front')->store('citizenship','public');
        }
        if($request->hasFile('back')){
            $data['nationality_card_back']=$request->file('back')->store('citizenship','public');
        }

        // return $data;

        $student->update($data);

        return redirect()->back()->with('success',"File Uploaded");
    }

    public function updateStatus(Student $student){
        $student->update([
            'status'=>!$student->status
        ]);

        return redirect()->back()->with('success',"Student status have been changed");
    }
}
