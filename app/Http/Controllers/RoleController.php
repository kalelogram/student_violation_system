<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function guardLogin()
    {
        return view('guard_login');
    }

    public function guardDashboard()
    {
        return view('guard_dashboard');
    }
    public function selectRole(Request $request)
{
    $role = $request->input('role');

    if ($role === 'guard') {
        return redirect()->route('guard.login');
    } elseif ($role === 'admin') {
        return redirect()->route('admin.login');
        // later: add admin login route
        //return back()->with('error', 'Admin login not yet available.');
    } else {
        return back()->with('error', 'Invalid role selection.');
    }
}
}
