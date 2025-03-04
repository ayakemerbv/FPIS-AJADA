<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;

    // Константы для статусов заявки
    public const STATUS_PENDING = 'pending';
    public const STATUS_SUBMITTED = 'submitted';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'student_id',
        'service_type',
        'scheduled_time',
        'status',
        'description',
    ];

    /**
     * Связь с моделью Student (заявка принадлежит студенту)
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    /**
     * Отправить заявку
     */
    public function submit()
    {
        $this->update(['status' => self::STATUS_SUBMITTED]);
    }

    /**
     * Отменить заявку
     */
    public function cancel()
    {
        $this->update(['status' => self::STATUS_CANCELLED]);
    }

    /**
     * Завершить заявку
     */
    public function complete()
    {
        $this->update(['status' => self::STATUS_COMPLETED]);
    }
}
