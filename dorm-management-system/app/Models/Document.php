<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'file_name',
        'file_path',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function upload($file)
    {
        $path = $file->store('documents');
        $this->file_path = $path;
        $this->save();
    }
}
