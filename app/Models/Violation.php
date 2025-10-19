<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;

class Violation extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'violations',
    ];

    // Relation to Student (assumes students.student_id is the student number)
    public function student()
    {
        // If your violations.student_id stores the student's student_id string (not the students.id),
        // adjust the foreignKey/localKey accordingly. This uses student's `student_id` column:
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }
}