<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recovery extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sport',
        'scheduled_time',
    ];

    // Если хочешь, добавь связь с пользователем
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
