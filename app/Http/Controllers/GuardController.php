<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Violation;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class GuardController extends Controller
{
    public function index()
    {
        return view('guard.dashboard');
    }

    // Fetch student info from student_db
    public function fetchStudent(Request $request)
    {
        $student = Student::on('mysql_STUDENT')
            ->where('student_no', $request->student_no)
            ->first();

        if ($student) {
            return response()->json($student);
        } else {
            return response()->json(['error' => 'Student not found'], 404);
        }
    }

    // Mag re-register ng bagong violation
    public function storeViolation(Request $request)
    {
        $request->validate([
            'student_no' => 'required',
            'violation' => 'required',
            'description' => 'nullable',
            'remarks' => 'nullable',
        ]);

        // Save violation record
        Violation::on('mysql')->create([
            'student_no' => $request->student_no,
            'violation' => $request->violation,
            'description' => $request->description,
            'remarks' => $request->remarks,
        ]);

        return back()->with('success', 'Violation recorded successfully!');
    }
}
