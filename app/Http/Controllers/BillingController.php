<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BillingController extends Controller
{
    public function index(){
        $students=Student::with('bills')->latest()->get();
        return Inertia::render('Billing',[
            'students'=>$students
        ]);
    }
}
