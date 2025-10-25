<?php

namespace App\Http\Controllers;

use App\Models\UserRole;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Violation;


class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = UserRole::count();
        $totalStudents = Student::count();
        $totalViolations = Violation::count();
        $recentLogs = Violation::orderByDesc('created_at')->take(5)->get();


        return view('dashboard', compact('totalUsers', 'totalStudents', 'totalViolations', 'recentLogs'));
    }
}