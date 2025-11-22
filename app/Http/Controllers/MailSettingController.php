<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use App\Models\MailSetting;
use App\Models\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class MailSettingController extends Controller
{
    public function index()
    {
        $mailSetup = MailSetting::first();
        return Inertia::render('Config/MailSetup', [
            'sidebar' => 'Settings',
            'menu' => 'MailSetup',
            'mailSetup' => $mailSetup,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate(MailSetting::rules());

        MailSetting::updateOrCreate(
            ['id' => 1],
            $data
        );

        return redirect()->route('mail.setup.index')->with('success', "Mail setup have been changed.");
    }

    public function sendTestMail(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'message' => 'required',
            'email' => 'required',
        ]);
        
       Mail::to($request->email)
        ->queue(new TestMail($request->subject, $request->message));

        return back()->with('success', 'Test mail is queued to be sent.');
    }
}
