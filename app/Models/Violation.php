<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Violation extends Model
{
    use HasFactory;
    //
    protected $connection = 'mysql';
    protected $table = 'violationtbl';
    protected $primaryKey = 'violation_id';
    protected $fillable = [ 'student_no', 
                            'violation', 
                            'description', 
                            'remarks'
                          ];  
                             

    // A violation belongs to a student
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_no', 'student_no');
    }
}
 
