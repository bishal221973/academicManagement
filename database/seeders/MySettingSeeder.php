<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MySettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('my_settings')->insert([
            ['key' => 'academy_name', 'value' => 'National Academy of Science and Technology'],
            ['key' => 'academy_email', 'value' => 'nast@example.com'],
            ['key' => 'address', 'value' => 'Dhangadhi-5, Taranagar, kailali'],
            ['key' => 'reg_date_ad', 'value' => '2025/01/01'],
            ['key' => 'reg_date_bs', 'value' => '2082/01/01'],
            ['key' => 'academy_contact_no', 'value' => '9814668499'],
            ['key' => 'logo', 'value' => ''],
            ['key' => 'vat_pan', 'value' => '998877'],
            ['key' => 'date_type', 'value' => 'bs'],
        ]);
    }
}
