<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'building_id', 'room_id', 'floor', 'status'];

    // Связь с пользователем (Один студент может сделать несколько бронирований)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Связь с корпусом
    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    // Связь с комнатой
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}

