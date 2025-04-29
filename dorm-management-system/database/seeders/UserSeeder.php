<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Student;
use App\Models\Manager;
use App\Models\Employee;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Student
        $studentUser = User::create([
            'user_id' => Str::upper(Str::random(8)),
            'name' => 'Student User',
            'email' => 'student@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        // Create student record
        Student::create([
            'user_id' => $studentUser->id,
            'student_id' => $studentUser->id, // student_id равен user_id
            'room_id' => null, // Пока нет комнаты, обновится позже
            // другие поля для студента
        ]);

        // Manager
        $managerUser = User::create([
            'user_id' => Str::upper(Str::random(8)),
            'name' => 'Manager User',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
        ]);

        // Create manager record
        Manager::create([
            'user_id' => $managerUser->id,
            'manager_id' => $managerUser->id, // manager_id равен user_id
            // другие поля для менеджера
        ]);
        // Employee
        $employeeUser = User::create([
            'user_id' => Str::upper(Str::random(8)),
            'name' => 'Employee User',
            'email' => 'employee@example.com',
            'password' => Hash::make('password'),
            'role' => 'employee',
        ]);
        // Create employee record
        Employee::create([
            'user_id' =>   $employeeUser->id,
            'employee_id' => $employeeUser->id, // Уникальное значение для employee_id
            'job_type' => 'Не указано', // Или другое значение, если необходимо
            // другие поля для работника
        ]);
    }
}
