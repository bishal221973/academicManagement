<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(){
        return saveDate("2082/02/02");
        $students=Student::latest()->get();
        return inertia('Student/List',[
            'menu'=>'Student',
            'sidebar' => 'Students',
            'students'=>$students,
            'student'=>new Student(),
        ]);
    }

    public function store(Request $request){
        $data=$request->validate(Student::rules());

        try {
            Student::create($data);
            return redirect()->back()->with('success','New student saved successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error',$th->getMessage());
        }
    }
}
