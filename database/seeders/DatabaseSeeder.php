<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\AcademicYear;
use App\Models\Course;
use App\Models\Group;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(UserSeeder::class);
        $this->call(SidebarSeeder::class);
        $this->call(IcardSeeder::class);
        $this->call(MySettingSeeder::class);
        $this->call(AdmissionSectionSeeder::class);
        $this->call(AdmissionFieldSeeder::class);

        AcademicYear::create([
            'name' => '2023-2024',
            'from' => '2023',
            'from_bs' => '2080',
            'to' => '2024',
            'to_bs' => '2081',
            'status' => true,
        ]);

        // Group::factory()->count(2)->create();
        Group::create([
            'name' => "Army",
        ]);
        Group::create([
            'name' => "Police",
        ]);
        Group::create([
            'name' => "Jana Pad",
            'parent_id'=>2,
        ]);
        Group::create([
            'name' => "Prabidhik",
            'parent_id'=>2,
        ]);
        $this->call(CourseSeeder::class);
        Section::factory()->count(25)->create();
        // Student::factory()->count(60)->create();
        $this->call(HostelSeeder::class);
        $this->call(ProductCategorySeeder::class);
        $this->call(UnitSeeder::class);
        $this->call(MailFormatSeeder::class);
    }
}
