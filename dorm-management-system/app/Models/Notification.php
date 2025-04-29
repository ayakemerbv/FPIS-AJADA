<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    // Константы для статусов
    public const STATUS_UNREAD = 'unread';
    public const STATUS_READ = 'read';

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Уведомление принадлежит студенту (получателю)
     */
    public function recipient()
    {
        return $this->belongsTo(Student::class, 'recipient_id');
    }

    /**
     * Отправить уведомление (по умолчанию непрочитанное)
     */
    public function send()
    {
        $this->status = self::STATUS_UNREAD;
        $this->save();
    }

    /**
     * Отметить уведомление как прочитанное
     */
    public function markAsRead()
    {
        $this->update(['status' => self::STATUS_READ]);
    }
}
