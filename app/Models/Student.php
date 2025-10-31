<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    
    protected $connection = 'mysql_STUDENT';
    protected $table = "students";
    protected $primaryKey = 'student_no';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'student_no',
        'first_name',
        'middle_initial',
        'last_name',
        'sex',
        'age',
        'program',
        'year_lvl',
        'parent_contact_no',
    ];

    // REMOVE the violations relationship - it doesn't work across databases
    // public function violations()
    // {
    //     return $this->hasMany(Violation::class, 'student_no', 'student_no');
    // }
}