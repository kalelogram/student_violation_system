<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;
use App\Models\Violation;
use App\Models\UserRole;

class Dashboard extends Model
{
    use HasFactory;

    // This model will not use a table (for now)
    protected $table = null;

    // These static functions will be used by the DashboardController
    public static function getDashboardStats()
    {
        return [
            'studenttbl' => Student::count(),
            'violationtbl' => Violation::count(),
            'users' => UserRole::count(),
        ];
    }
}