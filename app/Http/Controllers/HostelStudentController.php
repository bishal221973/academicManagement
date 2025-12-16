<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\HostelFeature;
use App\Models\HostelStudent;
use App\Models\HostelStudentFeature;
use App\Models\Room;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class HostelStudentController extends Controller
{
    public function index()
    {
        $rooms = Room::latest()->with('hostel')->get();
        $cources = Course::latest()->get();
        $hostelStudents = HostelStudent::with('student', 'hostel', 'room')->latest()->get();
        $features=HostelFeature::latest()->get();
        return Inertia::render('Hostel/AddStudent', [
            'menu' => 'AddStudent',
            'sidebar' => 'Hostel',
            'rooms' => $rooms,
            'room' => new Room(),
            'cources' => $cources,
            'hostelStudents' => $hostelStudents,
            'hostelStudent' => new HostelStudent(),
            'features'=>$features,
        ]);
    }

    public function store(Request $request)
    {
        // return $request;
        $data = $request->validate(HostelStudent::rules());
        $number = preg_replace('/Bed No\. /', '', $request->bed_no);
        $data['bed_no'] = $number;

        $data['check_out_date'] = Carbon::parse($request->check_in_date)->addMonths($request->stay_month)->format('Y-m-d');
        // DB::beginTransaction();

        // try {
        $hostelStudent=HostelStudent::create($data);
        $course = Course::find($request->course_id);
        $student = Student::find($request->student_id);

        foreach($request->features as $feature){
            HostelStudentFeature::create([
                'hostel_feature_id'=>$feature['feature_id'],
                'hostel_student_id'=>$hostelStudent->id,
                'price'=>$feature['price'],
            ]);
        }


        if (!$student->hostel_id_number) {
            $student->update([
                'hostel_id_number' => $course->code . '-' . str_pad($student->id, 4, '0', STR_PAD_LEFT),
            ]);
        }
        // return $request;
        $billingId=createBill($request->student_id, $request->price, $request->discount, $request->net_total, $request->total_amount, $request->taxes, "Hostel Fees");
        // } catch (\Exception $e) {
        //     DB::rollBack(); // undo all changes
        //     return $e->getMessage();
        //     return redirect()->back()->with('error', "Failed: " . $e->getMessage());
        // }
        hostelBookedMail($hostelStudent->id,$billingId);
        return redirect()->back()->with('success', "New Student have been added in hostel");
    }

    public function edit(HostelStudent $hostelStudent)
    {
        $rooms = Room::latest()->with('hostel')->get();
        $cources = Course::latest()->get();
        $hostelStudents = HostelStudent::with('student.course', 'hostel', 'room')->latest()->get();
        return Inertia::render('Hostel/AddStudent', [
            'menu' => 'AddStudent',
            'sidebar' => 'Hostel',
            'rooms' => $rooms,
            'room' => new Room(),
            'cources' => $cources,
            'hostelStudents' => $hostelStudents,
            'hostelStudent' => $hostelStudent->load('student.course', 'hostel', 'room'),
        ]);
    }

    public function show(HostelStudent $hostelStudent)
    {
        $hostelStudent->load('student.course', 'hostel', 'room');
        return Inertia::render('Hostel/Show', [
            'menu' => 'AddStudent',
            'sidebar' => 'Hostel',
            'hostelStudent' => $hostelStudent,
        ]);
    }

    public function update(Request $request, HostelStudent $hostelStudent)
    {
        $data = $request->validate(HostelStudent::rules());

        $hostelStudent->update($data);

        return redirect()->route('hostelStudent.index')->with('success', "Selected Student have been changed");
    }

    public function destroy($id)
    {

        $student=HostelStudent::find($id);
        HostelStudentFeature::where('hostel_student_id',$student->id)->delete();
        $student->delete();

        return redirect()->route('hostelStudent.index')->with('success', "Selected Student have been removed from hostel");
    }
}
