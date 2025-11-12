<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Violation;
use App\Models\Student;
use Illuminate\Support\Facades\Response;

class AdminController extends Controller
{
    // Show the admin login
    public function showAdminLogin()
    {
        return view('auth.admin_login');
    }

    // Admin dashboard
    public function adminDashboard(Request $request)
    {
        // ✅ Optional search filter (ready for use later)
        $search = $request->input('search');

        $query = DB::table('violationtbl')
            ->join('students', 'violationtbl.student_no', '=', 'students.student_no')
            ->select(
                'violationtbl.id',
                'students.student_no',
                'students.first_name',
                'students.last_name',
                'students.program',
                'students.year_lvl',
                'students.parent_contact_no',
                'violationtbl.violation',
                'violationtbl.description',
                'violationtbl.remarks',
                'violationtbl.photo_path',
                'violationtbl.created_at'
            );

        // ✅ Filter by search (optional)
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('students.first_name', 'like', "%{$search}%")
                  ->orWhere('students.last_name', 'like', "%{$search}%")
                  ->orWhere('students.student_no', 'like', "%{$search}%")
                  ->orWhere('violationtbl.violation', 'like', "%{$search}%")
                  ->orWhere('violationtbl.description', 'like', "%{$search}%");
            });
        }

        // ✅ Pagination ready
        $violations = $query->orderBy('violationtbl.created_at', 'desc')->paginate(10);

        // ✅ Summary counts
        $totalStudents = Student::count();
        $totalViolations = Violation::count();

        return view('admin.dashboard', compact('violations', 'totalStudents', 'totalViolations', 'search'));
    }

    // CSV Export
    public function exportCSV()
    {
        $violations = Violation::all();

        $filename = "violation_records_" . date('Y-m-d_H-i-s') . ".csv";
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['Violation', 'Description', 'Remarks', 'Date Created'];

        $callback = function() use ($violations, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($violations as $v) {
                fputcsv($file, [
                    $v->violation,
                    $v->description,
                    $v->remarks,
                    $v->created_at,
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    // Separate page for violations (optional)
    public function violations()
    {
        $violations = Violation::all();
        return view('admin.violations', compact('violations'));
    }
}