<?php

namespace Tests\Unit;

use App\Models\Room;
use App\Models\Building;
use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class RoomTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function room_has_expected_fillable_fields()
    {
        $room = new Room();

        $this->assertEquals(
            ['building_id', 'floor', 'room_number', 'capacity', 'occupied_places'],
            $room->getFillable()
        );
    }

    #[Test]
    public function room_belongs_to_building()
    {
        $room = new Room();

        $this->assertInstanceOf(BelongsTo::class, $room->building());
    }

    #[Test]
    public function room_has_many_bookings()
    {
        $room = new Room();

        $this->assertInstanceOf(HasMany::class, $room->bookings());
    }

    #[Test]
    public function room_can_check_available_space_correctly()
    {
        $room = new Room([
            'capacity' => 4,
            'occupied_places' => 2,
        ]);

        $this->assertTrue($room->hasAvailableSpace());

        $room->occupied_places = 4;
        $this->assertFalse($room->hasAvailableSpace());
    }
}
