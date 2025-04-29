<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Student;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@kbtu.kz'],
            [
                'user_id'=>'111',
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );
        Admin::create([
            'user_id' => $adminUser->id,
            'admin_id' => $adminUser->id, // student_id равен user_id

        ]);
    }
}
