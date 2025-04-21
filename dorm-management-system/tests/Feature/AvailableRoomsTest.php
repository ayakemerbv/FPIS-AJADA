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

        $availableRoom = Room::factory()->create([
            'capacity' => 4,
            'occupied_places' => 2,
        ]);

        $fullRoom = Room::factory()->create([
            'capacity' => 4,
            'occupied_places' => 4,
        ]);

        $response = $this->get('/rooms/available');

        $response->assertStatus(200);
        $response->assertSee((string) $availableRoom->room_number);
        $response->assertDontSee((string) $fullRoom->room_number);
    }
}
