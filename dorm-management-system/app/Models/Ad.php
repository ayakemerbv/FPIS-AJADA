<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'category',
        'description',
        'price',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function post()
    {
        $this->save();
    }
}
