<?php

namespace Tests\Unit;

use App\Models\Booking;
use App\Models\User;
use App\Models\Building;
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function booking_has_expected_fillable_fields()
    {
        $booking = new Booking();

        $this->assertEquals(
            ['user_id', 'building_id', 'room_id', 'floor', 'status'],
            $booking->getFillable()
        );
    }

    /** @test */
    public function booking_belongs_to_user()
    {
        $booking = Booking::factory()->create();

        $this->assertInstanceOf(User::class, $booking->user);
    }

    /** @test */
    public function booking_belongs_to_building()
    {
        $booking = Booking::factory()->create();

        $this->assertInstanceOf(Building::class, $booking->building);
    }

    /** @test */
    public function booking_belongs_to_room()
    {
        $booking = Booking::factory()->create();

        $this->assertInstanceOf(Room::class, $booking->room);
    }

    /** @test */
    public function it_can_create_booking_with_factory()
    {
        $booking = Booking::factory()->create();

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
        ]);
    }
}
