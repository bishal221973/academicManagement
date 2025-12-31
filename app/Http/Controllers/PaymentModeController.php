<?php

namespace App\Http\Controllers;

use App\Models\PaymentMode;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentModeController extends Controller
{
     public function index()
    {
        $paymentModes = PaymentMode::latest()->get();
        return Inertia::render('Config/PaymentMode', [
            'sidebar' => 'Settings',
            'menu' => 'PaymentMode',
            'paymentModes' => $paymentModes,
            'paymentMode'=>new PaymentMode(),
        ]);
    }

    public function all()
    {
        $paymentModes = PaymentMode::where('status',true)->get();
        return response()->json([
            'paymentModes'=>$paymentModes
        ]);
    }

    public function store(Request $request){
        $data=$request->validate(PaymentMode::rules());
        PaymentMode::create($data);

        return redirect()->back()->with('success',"New payment mode have been created");
    }

    public function status($id){
        $tax=PaymentMode::find($id);

        $tax->update([
            'status'=>!$tax->status,
        ]);

        return response()->json([
            'message' => 'Status updated successfully'
        ]);
    }

    public function edit(PaymentMode $paymentMode)
    {
        $paymentModes = PaymentMode::latest()->get();
        return Inertia::render('Config/PaymentMode', [
            'sidebar' => 'Settings',
            'menu' => 'PaymentMode',
            'paymentModes' => $paymentModes,
            'paymentMode'=>$paymentMode,
        ]);
    }

    public function update(Request $request,PaymentMode $paymentMode){
        $data=$request->validate(PaymentMode::rules($paymentMode->id));
        $paymentMode->update($data);

        return redirect()->route('paymentMode.index')->with('success',"New payment mode have been created");
    }


    public function delete($id){
        PaymentMode::find($id)->delete();

        return redirect()->route('paymentMode.index')->with('success','Selected payment mode have been removed');
    }

    public function allApi(){
        $paymentModes=PaymentMode::latest()->get();
        return response()->json($paymentModes);
    }
}
