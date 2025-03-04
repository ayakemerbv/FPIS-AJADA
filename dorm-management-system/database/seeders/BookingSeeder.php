<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Booking;

class BookingSeeder extends Seeder
{
    public function run()
    {
        Booking::create(['student_id' => 1, 'room_id' => 1, 'status' => 'confirmed']);
        Booking::create(['student_id' => 2, 'room_id' => 3, 'status' => 'pending']);
    }
}

