<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentViolation extends Model
{
    use HasFactory;
    
    protected $connection = 'mysql';
    protected $table = 'studenttbl';
    protected $primaryKey = 'id'; // The new auto-increment primary key
    
    protected $fillable = [
        'student_no',
        'violation_id',
        'first_name',
        'middle_initial', 
        'last_name',
        'program',
        'year_lvl',
        'parent_contact_no'
    ];

    // A student violation record belongs to a violation
    public function violation()
    {
        return $this->belongsTo(Violation::class, 'violation_id', 'violation_id');
    }
}