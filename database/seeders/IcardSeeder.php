<?php

namespace Database\Seeders;

use App\Models\Icard;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IcardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas=[
            'Theme1','Theme2'
        ];

        foreach($datas as $data){
            Icard::create([
                'name'=>$data
            ]);
        }
    }
}
