<?php

namespace Database\Seeders;

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
        User::updateOrCreate(
            ['email' => 'admin@kbtu.kz'], // Проверяем, есть ли уже такой админ
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'), // Хешируем пароль
                'role' => 'admin',
            ]
        );
    }
}
