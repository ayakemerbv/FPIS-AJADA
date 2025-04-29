<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // Константы для статусов платежа
    public const STATUS_PENDING = 'pending';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_FAILED = 'failed';
    public const STATUS_REFUNDED = 'refunded';

    protected $fillable = [
        'user_id', // Изменено с student_id на user_id
        'amount',
        'status',
        'payment_method',
        'external_id',
        'description',
        'date'
    ];


    protected $casts = [
        'date' => 'datetime',
    ];

    /**
     * Платёж принадлежит студенту
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Обработать платёж
     */
    public function processPayment()
    {
        if ($this->status === self::STATUS_PENDING) {
            // Здесь можно добавить логику интеграции с платежной системой
            $this->status = self::STATUS_COMPLETED;
            $this->save();
        }
    }

    /**
     * Отметить платёж как завершённый
     */
    public function markAsCompleted()
    {
        $this->update(['status' => self::STATUS_COMPLETED]);
    }

    /**
     * Отметить платёж как неудавшийся
     */
    public function markAsFailed()
    {
        $this->update(['status' => self::STATUS_FAILED]);
    }

    /**
     * Отметить платёж как возвращённый (рефанд)
     */
    public function markAsRefunded()
    {
        $this->update(['status' => self::STATUS_REFUNDED]);
    }
}
