<?php

namespace Tests\Feature;

use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class AvailableRoomsTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_shows_only_available_rooms()
    {
        // Свободная комната (2/4 занято)
        $availableRoom = Room::factory()->create([
            'capacity' => 4,
            'occupied_places' => 2,
        ]);

        // Полная комната (4/4 занято)
        $fullRoom = Room::factory()->create([
            'capacity' => 4,
            'occupied_places' => 4,
        ]);

        // Заглушка роута (предположим, он выводит только доступные комнаты)
        $response = $this->get('/rooms/available');

        $response->assertStatus(200);
        $response->assertSee((string) $availableRoom->room_number);
        $response->assertDontSee((string) $fullRoom->room_number);
    }
}
