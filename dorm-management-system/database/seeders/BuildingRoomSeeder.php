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
        // Пример: создадим "Корпус A" с 5 этажами.
        $buildingA = Building::create([
            'name'         => 'Корпус A',
            'address'      => 'ул. Абая, 10',
            'floors_count' => 5,
        ]);

        // Для каждого этажа создадим несколько комнат
        // Допустим, по 4 комнаты на этаже
        for ($floor = 1; $floor <= 5; $floor++) {
            for ($roomNum = 1; $roomNum <= 4; $roomNum++) {
                // Формируем номер комнаты, например: 101, 102, ...
                // floor * 100 + roomNum => 1*100+1 = 101
                $roomNumber = $floor * 100 + $roomNum;

                // Создаём комнату через связь "rooms"
                $buildingA->rooms()->create([
                    'floor'            => $floor,
                    'room_number'      => $roomNumber,
                    'capacity'         => 4,   // например, 4-местная
                    'occupied_places'  => 0,   // по умолчанию свободна
                ]);
            }
        }

        // Создадим ещё один корпус — "Корпус B" на 3 этажа
        $buildingB = Building::create([
            'name'         => 'Корпус B',
            'address'      => 'пр. Назарбаева, 25',
            'floors_count' => 3,
        ]);

        // Для корпуса B — по 5 комнат на этаже
        for ($floor = 1; $floor <= 3; $floor++) {
            for ($roomNum = 1; $roomNum <= 5; $roomNum++) {
                $roomNumber = $floor * 100 + $roomNum;

                $buildingB->rooms()->create([
                    'floor'            => $floor,
                    'room_number'      => $roomNumber,
                    'capacity'         => 3,  // трёхместная
                    'occupied_places'  => 0,
                ]);
            }
        }
    }
}
