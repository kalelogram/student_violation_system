<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Violation;
use App\Models\Student;
use Carbon\Carbon;

class GuardController extends Controller
{
    public function showLogin()
    {
        return view('guardlogin');
    }

    public function login(Request $request)
    {
        $password = $request->input('password');

        if ($password === '12345') {
            session(['guard_logged_in' => true]);
            return redirect()->route('guard.dashboard');
        }

        return back()->with('error', 'Incorrect password');
    }

    public function dashboard()
    {
        if (!session('guard_logged_in')) {
            return redirect()->route('guard.login');
        }

        // Always provide this variable to the view (even if empty)
        $today = Carbon::today();
        $todayViolations = Violation::whereDate('created_at', $today)
            ->orderByDesc('created_at')
            ->get();

        return view('guarddashboard', compact('todayViolations'));
    }

    // Search (POST) — shows student info + still shows today's logs
    public function searchStudent(Request $request)
    {
        if (!session('guard_logged_in')) {
            return redirect()->route('guard.login');
        }

        $request->validate(['student_id' => 'required|string']);

        $student = Student::where('student_id', $request->student_id)->first();

        $today = Carbon::today();
        $todayViolations = Violation::whereDate('created_at', $today)
            ->orderByDesc('created_at')
            ->get();

        return view('guarddashboard', compact('student', 'todayViolations'));
    }

    // Add violation (from the form)
    public function addViolation(Request $request)
    {
        if (!session('guard_logged_in')) {
            return redirect()->route('guard.login');
        }

        $request->validate([
            'student_id' => 'required|string',
            // if you use 'violation' as a single radio
            'violation' => 'required|string',
        ]);

        Violation::create([
            'student_id' => $request->student_id,
            // column name "violations" OR "violation" — match your DB column
            'violation' => $request->violation,
        ]);

        return back()->with('success', 'Violation recorded.');
    }

    public function logout()
    {
        session()->forget('guard_logged_in');
        return redirect()->route('guard.login');
    }
}