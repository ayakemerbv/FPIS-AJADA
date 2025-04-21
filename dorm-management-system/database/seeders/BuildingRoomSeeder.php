<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Building;
use App\Models\Room;

class BuildingRoomSeeder extends Seeder
{
    /**
     * Запуск сидера.
     */
    public function run()
    {
        $buildingA = Building::create([
            'name'         => 'Корпус A',
            'address'      => 'ул. Абая, 10',
            'floors_count' => 5,
        ]);

        for ($floor = 1; $floor <= 5; $floor++) {
            for ($roomNum = 1; $roomNum <= 4; $roomNum++) {
                $roomNumber = $floor * 100 + $roomNum;
                $buildingA->rooms()->create([
                    'floor'            => $floor,
                    'room_number'      => $roomNumber,
                    'capacity'         => 4,
                    'occupied_places'  => 0,
                ]);
            }
        }
        $buildingB = Building::create([
            'name'         => 'Корпус B',
            'address'      => 'пр. Назарбаева, 25',
            'floors_count' => 3,
        ]);

        for ($floor = 1; $floor <= 3; $floor++) {
            for ($roomNum = 1; $roomNum <= 5; $roomNum++) {
                $roomNumber = $floor * 100 + $roomNum;

                $buildingB->rooms()->create([
                    'floor'            => $floor,
                    'room_number'      => $roomNumber,
                    'capacity'         => 3,
                    'occupied_places'  => 0,
                ]);
            }
        }
    }
}
