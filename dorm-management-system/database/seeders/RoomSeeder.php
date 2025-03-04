<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    public function run()
    {
        Room::create(['dormitory_id' => 1, 'room_number' => '101', 'capacity' => 2]);
        Room::create(['dormitory_id' => 1, 'room_number' => '102', 'capacity' => 3]);
        Room::create(['dormitory_id' => 2, 'room_number' => '201', 'capacity' => 1]);
    }
}

