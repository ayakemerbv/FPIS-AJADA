<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'user_id',
        'email',
        'password',
        'role', // Добавлено поле роли

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Проверяет, является ли пользователь администратором.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'user_id');
    }
    // app/Models/User.php

    public function acceptedBooking()
    {
        // Предположим, что поле 'status' в таблице 'bookings' может быть:
        // 'pending', 'accepted', 'rejected' и т.п.
        return $this->hasOne(\App\Models\Booking::class, 'user_id')
            ->where('status', 'accepted');
    }


}
