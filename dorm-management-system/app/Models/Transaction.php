<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'amount',
        'transaction_type',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function process()
    {
        $this->status = 'Completed';
        $this->save();
    }
}
