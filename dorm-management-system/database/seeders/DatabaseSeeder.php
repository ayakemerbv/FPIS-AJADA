<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            DormitorySeeder::class,
            RoomSeeder::class,
            UserSeeder::class,
            StudentSeeder::class,
            BookingSeeder::class,
            PaymentSeeder::class,
            MaintenanceSeeder::class,
        ]);
    }
}
