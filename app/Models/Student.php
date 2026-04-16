<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'location',
        'gender',
        'specialization',
        'score',
        'grade',
        'cv_path',
        'programming_languages',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // تعريف العلاقة مع جدول student_programming_languages
    public function programmingLanguages()
    {
        return $this->hasMany(StudentProgrammingLanguage::class, 'student_id');
    }
}