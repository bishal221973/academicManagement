<?php

namespace Database\Seeders;

use App\Models\MailFormat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MailFormatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MailFormat::query()->delete();
        MailFormat::create([
            'title'=>'Admission Mail',
            'subject'=>'Admission Confirmed – Welcome to Our Academy!',
            'format'=>'<p>Dear {{student_name}},<br><br>Congratulations! Your admission to <strong>{{course_name}}</strong> has been successfully completed. We’re excited to have you as part of our academy and can’t wait to support your learning journey. Your registration number is <strong>{{registration_number}}</strong>, and your registration date is <strong>{{registration_date}}</strong>.<br><br>Regarding your billing information, the admission fee is <strong>Rs. {{admission_fee}}</strong>, the monthly fee is <strong>Rs. {{monthly_fee}}</strong>, a discount of <strong>Rs. {{discount_amount}}</strong> has been applied, the total tax is <strong>Rs. {{tax_amount}}</strong>, and the total payable amount is <strong>Rs. {{total_amount}}</strong>.</p><p></p><p>Welcome once again to the academy! We wish you great success ahead, and if you have any questions, feel free to contact us at <strong>9814668499</strong>.</p><p></p><p>Warm regards,<br><strong>Anubhav Academy</strong><br>Nepalgunj, Banke</p>'
        ]);
        MailFormat::create([
            'title'=>'Hostel Booked Mail',
            'subject'=>'Hostel Booking Confirmation',
            'format'=>'<p>Dear {{student_name}},<br><br>Congratulations! Your admission to <strong>{{course_name}}</strong> has been successfully completed. We’re excited to have you as part of our academy and can’t wait to support your learning journey. Your registration number is <strong>{{registration_number}}</strong>, and your registration date is <strong>{{registration_date}}</strong>.<br><br>Regarding your billing information, the admission fee is <strong>Rs. {{admission_fee}}</strong>, the monthly fee is <strong>Rs. {{monthly_fee}}</strong>, a discount of <strong>Rs. {{discount_amount}}</strong> has been applied, the total tax is <strong>Rs. {{tax_amount}}</strong>, and the total payable amount is <strong>Rs. {{total_amount}}</strong>.</p><p></p><p>Welcome once again to the academy! We wish you great success ahead, and if you have any questions, feel free to contact us at <strong>9814668499</strong>.</p><p></p><p>Warm regards,<br><strong>Anubhav Academy</strong><br>Nepalgunj, Banke</p>'
        ]);
        // MailFormat::create([
        //     'title'=>'Bill Payment Mail'
        // ]);
    }
}
