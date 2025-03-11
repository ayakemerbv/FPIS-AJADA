<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'floors'];

    // Связь с комнатами (Один корпус содержит много комнат)
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
