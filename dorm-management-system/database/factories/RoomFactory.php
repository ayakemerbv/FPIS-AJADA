<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\Building;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition(): array
    {
        return [
            'building_id'     => Building::factory(), // Создаёт и привязывает Building
            'floor'           => $this->faker->numberBetween(1, 10),
            'room_number'     => $this->faker->numberBetween(100, 999),
            'capacity'        => $this->faker->numberBetween(2, 6),
            'occupied_places' => $this->faker->numberBetween(0, 6),
        ];
    }
}
