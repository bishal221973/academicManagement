<?php

namespace Database\Seeders;

use App\Models\Sidebar;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SidebarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sidebars = [
            ['title' => 'Dashboard', 'icon' => 'Home','position'=>1, 'url' => null],
            ['title' => 'Students', 'icon' => 'Users', 'position' => 2, 'url' => 'student.index'],
            ['title' => 'Academic', 'icon' => 'BookOpen', 'position' => 3, 'url' => 'course.index'],
            // ['title' => 'Exam', 'icon' => 'FileCheck', 'position' => 5, 'url' => null],
            // ['title' => 'HR', 'icon' => 'UserCog', 'position' => 6, 'url' => null],
            ['title' => 'Hostel', 'icon' => 'Bed', 'position' => 7, 'url' => null],
            // ['title' => 'Shop', 'icon' => 'ShoppingCart', 'position' => 8, 'url' => null],
            // ['title' => 'Library', 'icon' => 'Library', 'position' => 9, 'url' => null],
            // ['title' => 'Account', 'icon' => 'Wallet', 'position' => 10, 'url' => null],
            // ['title' => 'Vehicle', 'icon' => 'Bus', 'position' => 11, 'url' => null],
            // ['title' => 'Reports', 'icon' => 'BarChart3', 'position' => 11,'url'=>null],
            ['title' => 'Settings', 'icon' => 'Settings', 'position' => 12,'url'=>'configuration'],
            
            
            // ['title' => 'Students', 'icon' => 'GraduationCap', 'position' => 4, 'url' => null],
        ];
        Sidebar::query()->delete();
        DB::table('sidebars')->insert($sidebars);
    }
}
