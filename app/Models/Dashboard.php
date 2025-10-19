<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;
use App\Models\Violation;
use App\Models\User;
use App\Models\Log;

class Dashboard extends Model
{
    use HasFactory;

    // This model will not use a table (for now)
    protected $table = null;

    // These static functions will be used by the DashboardController
    public static function getDashboardStats()
    {
        return [
            'students' => Student::count(),
            'violations' => Violation::count(),
            'users' => User::count(),
            'logs' => Log::count(),
        ];
    }
}