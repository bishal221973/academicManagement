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
            ['key' => 'academy_name', 'value' => 'Academy Management'],
            ['key' => 'academy_email', 'value' => 'academy@example.com'],
            ['key' => 'reg_date_ad', 'value' => '2025/01/01'],
            ['key' => 'reg_date_bs', 'value' => '2082/01/01'],
            ['key' => 'logo', 'value' => ''],
            ['key' => 'vat_pan', 'value' => '998877'],
            ['key' => 'date_type', 'value' => 'bs'],
        ]);
    }
}
