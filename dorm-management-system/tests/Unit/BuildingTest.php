<?php

namespace Tests\Unit;

use App\Models\Building;
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Relations\HasMany;
use PHPUnit\Framework\Attributes\Test;

class BuildingTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function building_has_expected_fillable_fields()
    {
        $building = new Building();

        $this->assertEquals(
            ['name', 'address', 'floors_count'],
            $building->getFillable()
        );
    }

    #[Test]
    public function building_has_many_rooms()
    {
        $building = new Building();

        $this->assertInstanceOf(HasMany::class, $building->rooms());
    }

    #[Test]
    public function it_can_create_building_via_factory()
    {
        $building = Building::factory()->create([
            'name' => 'Tech Tower',
            'address' => '123 Future Ave',
            'floors_count' => 12,
        ]);

        $this->assertDatabaseHas('buildings', [
            'name' => 'Tech Tower',
            'address' => '123 Future Ave',
            'floors_count' => 12,
        ]);
    }
}
