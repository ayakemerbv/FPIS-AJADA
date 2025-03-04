<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    public function run()
    {
        Student::create(['user_id' => 1, 'dormitory_id' => 1, 'room_id' => 1, 'status' => 'active']);
        Student::create(['user_id' => 2, 'dormitory_id' => 2, 'room_id' => 3, 'status' => 'pending']);
    }
}
