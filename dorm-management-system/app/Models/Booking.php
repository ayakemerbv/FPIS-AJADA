<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    // Константы для статусов бронирования
    public const STATUS_PENDING = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'student_id',
        'room_id',
        'booking_date',
        'status',
    ];

    /**
     * Связь с моделью Student (бронирование принадлежит студенту)
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    /**
     * Связь с моделью Room (бронирование относится к комнате)
     */
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    /**
     * Подтвердить бронирование
     */
    public function confirm()
    {
        $this->update(['status' => self::STATUS_CONFIRMED]);
    }

    /**
     * Отменить бронирование
     */
    public function cancel()
    {
        $this->update(['status' => self::STATUS_CANCELLED]);
    }
}
