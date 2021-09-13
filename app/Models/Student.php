<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'name', 'dob', 'address', 'class_name', 'email', 'phone', 'e_phone', 'is_active'
    ];

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }
}
