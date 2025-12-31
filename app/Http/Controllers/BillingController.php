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
       $bills=Bill::with('student','items')->latest()->get();
       $students = Student::with('bills')->latest()->get();

        return Inertia::render('Billing', [
            'students' => $students,
            'bills' => $bills
        ]);
    }

    public function allApi()
    {
        $bills=Bill::latest()->get();
        return response()->json($bills);
    }

    public function find($id){
        $bill=Bill::find($id);
        return response()->json($bill);
    }

    public function findBillingID($billing_id){
        $bill=Bill::where('bill_no', $billing_id)->with('student','items','months','taxes.tax')->first();

        return response()->json($bill);
    }
}
