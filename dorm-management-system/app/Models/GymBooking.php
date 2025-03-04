<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GymBooking extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'student_id',
        'scheduled_time',
        'status',
    ];

    protected $casts = [
        'scheduled_time' => 'datetime',
    ];

    /**
     * Связь с пользователем (студентом)
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    /**
     * Подтвердить бронирование спортзала
     */
    public function confirm()
    {
        $this->update(['status' => self::STATUS_CONFIRMED]);
    }

    /**
     * Отменить бронирование спортзала
     */
    public function cancel()
    {
        $this->update(['status' => self::STATUS_CANCELLED]);
    }
}
