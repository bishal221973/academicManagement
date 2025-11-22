<?php

namespace App\Http\Controllers;

use App\Models\MailFormat;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MailFormatController extends Controller
{
     public function index()
    {
        $mailFormats = MailFormat::latest()->get();
        
        notifyMail('bishalcodeslaravel@gmail.com',402,402,'Admission Mail');
        // notifyMail('bishalcodeslaravel@gmail.com','Bishal Chaudhary','Bill Generated Mail');
        return Inertia::render('Config/MailFormat', [
            'sidebar' => 'Settings',
            'menu' => 'mailFormats',
            'mailFormats' => $mailFormats,
        ]);
    }

    public function store(Request $request){
        $data=$request->validate([
            'title'=>'required',
            'format'=>'required',
        ]);

        MailFormat::where('title',$request->title)->first()->update([
            'format'=>$data['format']
        ]);

        return redirect()->route('mail.format.index')->with('success',"Mail format have been changed.");
    }
}
