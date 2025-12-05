<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;
    protected $fillable = ['name', 'teacher_id'];

    public function students() {
        return $this->hasMany(Student::class);
    }

    public function teacher() {
        return $this->belongsTo(Teacher::class);
    }
}
