<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BillingController extends Controller
{
    public function totalReceivable()
    {
        $totalAmounts=0;
        $students = Student::with('bills')->latest()->get();
        foreach ($students as $student) {
            foreach ($student->bills as $bill) {
                $totalAmounts+= $bill->total_amount;
            }
        }
        return response()->json($totalAmounts);
    }

    public function index()
    {
        $students = Student::with('bills')->latest()->get();

        return Inertia::render('Billing', [
            'students' => $students
        ]);
    }
}
