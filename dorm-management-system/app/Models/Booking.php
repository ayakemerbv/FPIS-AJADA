<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'building_id',
        'floor',
        'room_id',
        'status',
    ];

    // Если нужно, связь с пользователем
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

