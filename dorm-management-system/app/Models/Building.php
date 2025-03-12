<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

    // Если у вас в миграции столбцы называются "name", "address", "floors_count"
    protected $fillable = [
        'name',
        'address',
        'floors_count',
    ];

    /**
     * Один корпус (Building) содержит много комнат (Room).
     */
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
