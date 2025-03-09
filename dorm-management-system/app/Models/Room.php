<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'building_id',
        'floor',
        'room_number',
        'capacity',
        'occupied_beds',
    ];

    /**
     * Связь с моделью Student (одна комната - много студентов)
     */
    public function students()
    {
        return $this->hasMany(Student::class, 'room_id');
    }

    /**
     * Назначить студента в комнату
     */
    public function assignStudent(Student $student)
    {
        if ($this->occupied_beds >= $this->capacity) {
            throw new \Exception("Комната {$this->id} уже заполнена.");
        }

        DB::transaction(function () use ($student) {
            $student->room_id = $this->id;
            $student->save();

            $this->increment('occupied_beds'); // Увеличиваем занятые места
        });
    }

    /**
     * Освободить студента из комнаты
     */
    public function releaseStudent(Student $student)
    {
        if ($student->room_id !== $this->id) {
            throw new \Exception("Студент не находится в этой комнате.");
        }

        DB::transaction(function () use ($student) {
            $student->room_id = null;
            $student->save();

            $this->decrement('occupied_beds'); // Уменьшаем занятые места
        });
    }
}
