<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProgrammingLanguage extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'programming_language',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}