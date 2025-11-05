<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\HostelStudent;
use App\Models\Room;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HostelStudentController extends Controller
{
    public function index()
    {
        $rooms = Room::latest()->with('hostel')->get();
        $cources = Course::latest()->get();
        $hostelStudents = HostelStudent::with('student', 'hostel', 'room')->latest()->get();
        return Inertia::render('Hostel/AddStudent', [
            'menu' => 'AddStudent',
            'sidebar' => 'Hostel',
            'rooms' => $rooms,
            'room' => new Room(),
            'cources' => $cources,
            'hostelStudents' => $hostelStudents,
            'hostelStudent' => new HostelStudent(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate(HostelStudent::rules());
        $number = preg_replace('/Bed No\. /', '', $request->bed_no);
        $data['bed_no'] = $number;
        HostelStudent::create($data);

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

    public function update(Request $request, HostelStudent $hostelStudent)
    {
        $data = $request->validate(HostelStudent::rules());

        $hostelStudent->update($data);

        return redirect()->route('hostelStudent.index')->with('success', "Selected Student have been changed");
    }

    public function destroy($id)
    {

        HostelStudent::find($id)->delete();

        return redirect()->route('hostelStudent.index')->with('success', "Selected Student have been removed from hostel");
    }
}
