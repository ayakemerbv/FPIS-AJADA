<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'employee_id',  'job_type'];


    public function requests()
    {
        return $this->hasMany(Request::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
