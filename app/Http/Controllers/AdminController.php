<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Violation;

class AdminController extends Controller
{
    public function showLogin()
    {
        return view('adminlogin');
    }

    public function login(Request $request)
    {
        $password = $request->input('password');

        if ($password === 'admin123') {
            session(['admin_logged_in' => true]);
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Incorrect password');
    }

    public function dashboard()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        // Get ALL violations (full history)
        $violations = Violation::orderByDesc('created_at')->get();

        return view('admindashboard', compact('violations'));
    }

    public function logout()
    {
        session()->forget('admin_logged_in');
        return redirect()->route('admin.login');
    }

    
}