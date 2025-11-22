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
        MailFormat::create([
            'title'=>'Welcome Mail'
        ]);
        MailFormat::create([
            'title'=>'Bill Generated Mail'
        ]);
        MailFormat::create([
            'title'=>'Bill Payment Mail'
        ]);
    }
}
