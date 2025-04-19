<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\User;
use App\Models\Building;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        $building = Building::factory()->create();
        $room = Room::factory()->create(['building_id' => $building->id]);

        return [
            'user_id' => User::factory(),
            'building_id' => $building->id,
            'room_id' => $room->id,
            'floor' => $room->floor,
            'status' => $this->faker->randomElement(['pending', 'accepted', 'rejected', 'checked_in', 'checked_out']),
        ];
    }
}
