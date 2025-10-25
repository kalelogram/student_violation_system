<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $violations = DB::connection('mysql')
        ->table('violationtbl')
        ->join('studenttbl', 'violationtbl.student_no', '=', 'studenttbl.student_no')
        ->select(
            'violationtbl.*',
            'studenttbl.first_name as fname',
            'studenttbl.last_name as lname',
            'studenttbl.program',
            'studenttbl.year_lvl'
        )
        ->whereDate('violationtbl.created_at', now()->toDateString())
        ->orderBy('violationtbl.created_at', 'desc')
        ->get();

    return view('guard.dashboard', [
        'todayViolations' => $violations
    ]);
    }

    public function logoutAdmin()
{
    return redirect('/admin/login');
}

}
