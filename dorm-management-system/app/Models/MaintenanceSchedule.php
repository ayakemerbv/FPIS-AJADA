<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'scheduled_date',
        'description',
        'status',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function complete()
    {
        $this->status = 'Completed';
        $this->save();
    }
}
