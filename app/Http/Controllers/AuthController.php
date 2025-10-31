<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\Violation;

class AuthController extends Controller
{
    // === ADMIN LOGIN ===
    public function showAdminLogin()
    {
        return view('auth.admin_login');
    }

    public function loginAdmin(Request $request)
    {
        $password = $request->input('password');

        // Fetch password from user_role_db
        $dbPassword = DB::connection('mysql_ROLE')
                        ->table('user_roletbl')
                        ->where('role_id', '1')
                        ->value('password');

        if ($password === $dbPassword) {
            return redirect('/admin/dashboard');
        } else {
            return back()->with('error', 'Incorrect password.');
        }
    }

    public function adminDashboard()
    {
       $violations = DB::connection('mysql')
        ->table('violationtbl')
        ->get();

        return view('admin.dashboard', compact('violations'));
    }

    // === GUARD LOGIN ===
    public function showGuardLogin()
    {
        return view('auth.guard_login');
    }

    public function loginGuard(Request $request)
    {
        $password = $request->input('password');

        $dbPassword = DB::connection('mysql_ROLE')
                        ->table('user_roletbl')
                        ->where('role_id', '2')
                        ->value('password');

        if ($password === $dbPassword) {
            return redirect('/guard/dashboard');
        } else {
            return back()->with('error', 'Incorrect password.');
        }
    }

    public function guardDashboard()
    {

        // Initialize all required variables
        $student = null;
        $violations = collect();
        $searchPerformed = false;

        // Get today's violations for the logs section using raw query
        $todayViolations = DB::connection('mysql')
            ->table('violationtbl')
            ->join('students', 'violationtbl.student_no', '=', 'students.student_no')
            ->select(
                'violationtbl.student_no',
                'students.first_name as first_name',
                'students.last_name as last_name',
                'students.program',
                'students.year_lvl',
                'violationtbl.violation',
                'violationtbl.photo_path',
                'violationtbl.created_at'
            )
            ->whereDate('violationtbl.created_at', today())
            ->orderBy('violationtbl.created_at', 'desc')
            ->get();

        // Convert created_at to Carbon objects for proper formatting
        $todayViolations = $todayViolations->map(function ($log) {
        $log->created_at = \Carbon\Carbon::parse($log->created_at);
        return $log;

    });
    
        return view('guard.dashboard', [
            'student' => $student,
            'violations' => $violations,
            'todayViolations' => $todayViolations,
            'searchPerformed' => $searchPerformed
    ]);
    }

    public function logoutAdmin()
    {
    return redirect('/admin/login');
    }

}
