<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',      // вместо student_id
        'category',
        'description',
        'price',
        'title',        // если есть заголовок
        'image_path',   // если храните путь к картинке
        'contact'
    ];

    /**
     * Владелец объявления — пользователь
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
