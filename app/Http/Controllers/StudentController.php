<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(){
        return inertia('Student/List',[
            'menu'=>'Student',
            'sidebar' => 'Students',
        ]);
    }
}
