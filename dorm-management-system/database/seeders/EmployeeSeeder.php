<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employees')->insert([
            [
                'employee_id' => 1, // <-- добавь сюда уникальные ID
                'name' => 'Козыбаев А. Б.',
                'job_type' => 'Электрик',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_id' => 2,
                'name' => 'Иванов И. И.',
                'job_type' => 'Плотник',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_id' => 4,
                'name' => 'Петров П. П.',
                'job_type' => 'Сантехник',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
