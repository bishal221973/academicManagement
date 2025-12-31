<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentController extends Controller
{

    public function index(){
        $payments=Payment::with('bill.student','paymentMode')->latest()->get();
        return Inertia::render('payment/index',compact('payments'));
    }
    public function store(Request $request){
        $data=$request->validate([
            'bill_id'=>'required',
            'payment_mode_id'=>'required',
            'payment_date'=>'required',
            'amount' => 'required',
            'remarks' => 'nullable',
            'student_id'=>'required'
        ]);
        $academyYear = AcademicYear::where('status', true)->first();
        if (!$academyYear) {
            return redirect()->back()->with('error', "Please active an academy year");
        }
        // $data['']
        $data['academic_year_id']=$academyYear->id;

        Payment::create($data);

        return redirect()->back()->with('success',"New payment have been saved.");
    }

    public function status($id){
        $payment=Payment::find($id);
        $payment->update([
            'status' => 'canceled'
        ]);
        return redirect()->back()->with('success',"Payment status have been changed.");
    }
}
