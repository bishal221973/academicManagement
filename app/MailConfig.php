<?php

use App\Models\MailSetting;

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
