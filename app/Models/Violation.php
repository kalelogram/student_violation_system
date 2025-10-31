<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Violation extends Model
{
    use HasFactory;
    
    protected $connection = 'mysql';
    protected $table = 'violationtbl';
    protected $primaryKey = 'violation_id';
    protected $fillable = [ 
        'violation', 
        'description', 
        'remarks',
        'photo_path'
    ];  

    // REMOVE the student relationship - it doesn't work across databases
    // public function student()
    // {
    //     return $this->belongsTo(Student::class, 'student_no', 'student_no');
    // }
}