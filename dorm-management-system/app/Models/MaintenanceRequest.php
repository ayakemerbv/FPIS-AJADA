<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class MaintenanceRequest extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'description', 'status'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
