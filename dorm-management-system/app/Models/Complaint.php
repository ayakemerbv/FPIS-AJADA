<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Complaint extends Model
{
    use HasFactory;

    // Константы для статусов
    public const STATUS_PENDING = 'pending';
    public const STATUS_SUBMITTED = 'submitted';
    public const STATUS_RESOLVED = 'resolved';
    public const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'student_id',
        'content',
        'status',
        'response',
        'resolved_at',
    ];

    /**
     * Жалоба принадлежит студенту
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    /**
     * Отправить жалобу
     */
    public function submit()
    {
        $this->update(['status' => self::STATUS_SUBMITTED]);
    }

    /**
     * Разрешить жалобу с ответом
     */
    public function resolve(string $response)
    {
        $this->update([
            'status' => self::STATUS_RESOLVED,
            'response' => $response,
            'resolved_at' => Carbon::now(),
        ]);
    }

    /**
     * Отклонить жалобу
     */
    public function reject(string $response)
    {
        $this->update([
            'status' => self::STATUS_REJECTED,
            'response' => $response,
            'resolved_at' => Carbon::now(),
        ]);
    }
}
