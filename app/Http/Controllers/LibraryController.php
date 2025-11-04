<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Library;
use App\Models\Subject;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LibraryController extends Controller
{
    public function index(){
        $books=Subject::with('course')->latest()->get();
        $cources=Course::latest()->get();
        $libraries=Library::latest()->get();
        return Inertia()->render("Library/Index",[
            'books'=>$books,
            'cources'=>$cources,
            'libraries'=>$libraries,
            'menu' => 'Library',
            'sidebar' => 'Library',
        ]);
    }
}
