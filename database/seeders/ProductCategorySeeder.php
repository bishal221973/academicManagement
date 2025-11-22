<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductCategory::create([
            'name'=>'Sports',
            'category_id'=>'SPRT123',
        ]);
        ProductCategory::create([
            'name'=>'Dress',
            'category_id'=>'DRS123',
        ]);
    }
}
