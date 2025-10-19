<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'name',
        'course',
        'year_level',
        'section',
    ];

    // One student can have many violations
    public function violations()
    {
        return $this->hasMany(Violation::class);
    }

    // Optionally: logs related to this student
    public function logs()
    {
        return $this->hasMany(Log::class);
    }
}