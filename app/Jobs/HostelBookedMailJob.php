<?php

namespace App\Jobs;

use App\Mail\HostelBookedMail;
use App\Models\HostelStudent;
use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class HostelBookedMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $hostelStudentId;
    protected $mailTemplate;
    protected $billId;
    protected $subject;

    public function __construct($hostelStudentId, $billId, $mailTemplate, $subject)
    {
        $this->hostelStudentId = $hostelStudentId;
        $this->billId = $billId;
        $this->mailTemplate = $mailTemplate;
        $this->subject = $subject;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
    Log::info('hostelStudentId at step-2 is:'.$this->hostelStudentId);
    Log::info('billId at step-2 is:'.$this->billId);
    Log::info('mailTemplate at step-2 is:'.$this->mailTemplate);
    Log::info('subject at step-2 is:'.$this->subject);

        $hostelStudent=HostelStudent::find($this->hostelStudentId);
        $student=Student::find($hostelStudent->student_id);
        applyMailSettings();
        Mail::to($student->email)->send(new HostelBookedMail($student->id,$hostelStudent->hostel_id,$hostelStudent->id, $this->billId, $this->mailTemplate, $this->subject));
    }
}
