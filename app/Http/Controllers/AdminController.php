<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Violation;

class AdminController extends Controller
{
    public function showLogin()
    {
        return view('auth.admin_login'); // ← adjust view name if your file is "admin_login.blade.php"
    }

    // You can add your other admin functions below (e.g. dashboard, logout, etc.)

    public function login(Request $request)
    {
        $password = $request->input('password');

        if ($password === 'admin123') {
            session(['admin_logged_in' => true]);
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Incorrect password');
    }

    public function dashboard(Request $request)
{
    if (!session('admin_logged_in')) {
        return redirect()->route('admin.login');
    }

    // Get paginated violations
    $violations = \App\Models\Violation::orderByDesc('created_at')->paginate(10);

    // Get stats for summary cards
    $totalViolations = \App\Models\Violation::count();
    $todayViolations = \App\Models\Violation::whereDate('created_at', today())->count();

    return view('admindashboard', compact('violations', 'totalViolations', 'todayViolations'));
}

    public function logout()
    {
        session()->forget('admin_logged_in');
        return redirect()->route('admin.login');
    }
public function exportCSV()
{
    $violations = \App\Models\Violation::all();
    $filename = "violations_" . now()->format('Y-m-d_His') . ".csv";

    $headers = [
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=$filename",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    ];

    $columns = [
        'Student No', 'Full Name', 'Program', 'Year Level', 'Violation', 
        'Description', 'Remarks', 'Date & Time'
    ];

    $callback = function() use ($violations, $columns) {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);

        foreach ($violations as $v) {
            fputcsv($file, [
                $v->student_no,
                $v->first_name . ' ' . $v->last_name,
                $v->program,
                $v->year_lvl,
                $v->violation,
                $v->description,
                $v->remarks,
                $v->created_at
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}

    
}