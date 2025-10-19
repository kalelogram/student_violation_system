<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Violation;
use App\Models\Log;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalStudents = Student::count();
        $totalViolations = Violation::count();
        $recentLogs = Log::latest()->take(5)->get();

        return view('dashboard', compact('totalUsers', 'totalStudents', 'totalViolations', 'recentLogs'));
    }
}