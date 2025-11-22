<?php

use App\Jobs\HostelBookedMailJob;
use App\Jobs\WelcomeMailJob;
use App\Models\MailFormat;
use App\Models\MailSetting;
use Illuminate\Support\Facades\Log;

function applyMailSettings()
{
    $m = MailSetting::first();

    if ($m) {
        config([
            'mail.default' => $m->mailer,

            "mail.mailers.smtp.host" => $m->host,
            "mail.mailers.smtp.port" => $m->port,
            "mail.mailers.smtp.username" => $m->username,
            "mail.mailers.smtp.password" => $m->password,
            "mail.mailers.smtp.encryption" => $m->encryption,

            "mail.from.address" => $m->from_address,
            "mail.from.name" => $m->from_name,
        ]);
    }
}

function notifyMail($mail, $studentId,$billId, $title)
{
    if (auth()?->id()) {
        $mailTemplate = MailFormat::where('title', $title)->first();

        if ($mail && $mailTemplate?->format) {
            WelcomeMailJob::dispatch($mail, $studentId, $billId, $mailTemplate->format,$mailTemplate->subject);
        }

       
    }
}

function hostelBookedMail($hostelStudent,$billId)
{
    Log::info('HostelStudentID at step-1 is:'.$hostelStudent);
    Log::info('bill at step-1 is:'.$billId);
    if (auth()?->id()) {
        $mailTemplate = MailFormat::where('title', 'Hostel Booked Mail')->first();

        if ($mailTemplate?->format) {
            HostelBookedMailJob::dispatch($hostelStudent, $billId, $mailTemplate->format,$mailTemplate->subject);
        }

       
    }
}


