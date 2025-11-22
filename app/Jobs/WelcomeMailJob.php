<?php

namespace App\Jobs;

use App\Mail\WelcomeMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class WelcomeMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $to;
    protected $studentId;
    protected $mailTemplate;
    protected $billId;
    protected $subject;

    public function __construct($to,$studentId, $billId, $mailTemplate, $subject)
    {
        $this->to=$to;
        $this->studentId=$studentId;
        $this->mailTemplate=$mailTemplate;
        $this->billId=$billId;
        $this->subject=$subject;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        applyMailSettings();
        Mail::to($this->to)->send(new WelcomeMail($this->studentId,$this->billId,$this->mailTemplate,$this->subject));
    }
}
