<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate([
            'email' => 'admin@kbtu.kz'
        ], [
            'name' => 'Admin',
            'user_id' => 'A0001',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
        ]);
    }
}
