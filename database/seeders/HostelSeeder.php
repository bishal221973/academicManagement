<?php

namespace Database\Seeders;

use App\Models\Hostel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HostelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Hostel::create([
            'name'=>'Nepalgunj Boys Hostel',
            'address'=>'Nepalgunj, Banke',
            'type'=>'Boys'
        ]);

        Hostel::create([
            'name'=>'Nepalgunj Girls Hostel',
            'address'=>'Nepalgunj, Banke',
            'type'=>'Girls'
        ]);
    }
}
