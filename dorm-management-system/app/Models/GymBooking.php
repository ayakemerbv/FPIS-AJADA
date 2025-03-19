<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GymBooking extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = ['user_id', 'sport', 'day', 'scheduled_time', 'status'];


    protected $casts = [
        'scheduled_time' => 'datetime',
    ];

    /**
     * Связь с пользователем (студентом)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Подтвердить бронирование спортзала
     */
    public function confirm(): void
    {
        if ($this->status !== self::STATUS_CONFIRMED) {
            $this->update(['status' => self::STATUS_CONFIRMED]);
        }
    }

    /**
     * Отменить бронирование спортзала
     */
    public function cancel(): void
    {
        if ($this->status !== self::STATUS_CANCELLED) {
            $this->update(['status' => self::STATUS_CANCELLED]);
        }
    }

    /**
     * Проверка, является ли текущее бронирование подтвержденным
     */
    public function isConfirmed(): bool
    {
        return $this->status === self::STATUS_CONFIRMED;
    }

    /**
     * Проверка, является ли текущее бронирование отмененным
     */
    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    /**
     * Проверка, может ли пользователь редактировать бронирование
     */
    public function canBeModifiedBy($user): bool
    {
        return $user->id === $this->user_id || ($user->role ?? '') === 'admin';
    }
}
