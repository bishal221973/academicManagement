<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user=User::create([
            'name'=>'Bishal Chaudhary',
            'email'=>'bishal@gmail.com',
            'password'=>Hash::make('password'),
            'email_verified_at'=>now(),
        ]);

        $role = Role::create(['name' => 'Super-Admin']);

        $user->assignRole($role);
    }
}
