<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    // Предположим, что в миграции поля: building_id, floor, room_number, capacity, occupied_places
    protected $fillable = [
        'building_id',
        'floor',
        'room_number',
        'capacity',
        'occupied_places',
    ];

    /**
     * Связь: одна комната (Room) принадлежит одному корпусу (Building).
     */
    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    /**
     * Если есть таблица bookings и модель Booking,
     * и каждая заявка (Booking) связана с конкретной комнатой:
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Проверить, есть ли ещё свободные места.
     */
    public function hasAvailableSpace()
    {
        return $this->occupied_places < $this->capacity;
    }
}
