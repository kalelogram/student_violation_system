<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Violation;
use Illuminate\Support\Facades\DB;

class GuardController extends Controller
{
    public function fetchStudent(Request $request)
    {
        $studentNo = $request->student_no;
        $student = null;
        $violations = collect();
        $searchPerformed = true;

        // Get student from student_db (mysql_STUDENT)
        $student = Student::where('student_no', $studentNo)->first();

        if ($student) {
            // Get violation history using raw query (cross-database)
            $violations = DB::connection('mysql')
                ->table('studenttbl')
                ->join('violationtbl', 'studenttbl.violation_id', '=', 'violationtbl.violation_id')
                ->where('studenttbl.student_no', $studentNo)
                ->select(
                    'violationtbl.violation_id',
                    'violationtbl.violation',
                    'violationtbl.description',
                    'violationtbl.remarks',
                    'violationtbl.photo_path',
                    'violationtbl.created_at'
                )
                ->orderBy('violationtbl.created_at', 'desc')
                ->get();

            // Convert created_at to Carbon objects
            $violations = $violations->map(function ($violation) {
                $violation->created_at = \Carbon\Carbon::parse($violation->created_at);
                return $violation;
            });
        }

        // Get today's violations using raw query (cross-database)
        $todayViolations = DB::connection('mysql')
            ->table('studenttbl')
            ->join('violationtbl', 'studenttbl.violation_id', '=', 'violationtbl.violation_id')
            ->join('mysql_STUDENT.students', 'studenttbl.student_no', '=', 'students.student_no')
            ->select(
                'studenttbl.student_no',
                'students.first_name as fname',
                'students.last_name as lname',
                'students.program',
                'students.year_lvl',
                'violationtbl.violation',
                'violationtbl.photo_path',
                'violationtbl.created_at'
            )
            ->whereDate('violationtbl.created_at', today())
            ->orderBy('violationtbl.created_at', 'desc')
            ->get();

        // Convert today's violations created_at to Carbon objects
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

    public function addViolation(Request $request)
    {
        $request->validate([
            'student_no' => 'required|string',
            'violation' => 'required|string',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            DB::connection('mysql')->transaction(function () use ($request) {
                $studentNo = $request->student_no;
                
                // Check if student exists in student_db and GET THEIR DATA
                $student = Student::where('student_no', $studentNo)->first();
                
                if (!$student) {
                    throw new \Exception('Student not found in database.');
                }

                // Count existing violations for this student
                $violationCount = DB::connection('mysql')
                    ->table('studenttbl')
                    ->where('student_no', $studentNo)
                    ->count();

                $attemptNumber = $violationCount + 1;

                // Determine remarks based on violation count (3 attempts only)
                $remarks = $this->getRemarks($attemptNumber);

                // Handle photo upload - only allow if it's the first violation
                $photoPath = null;
                $isFirstViolation = ($violationCount === 0);

                if ($isFirstViolation && $request->hasFile('photo')) {
                    if ($request->file('photo')->isValid()) {
                        $photoPath = $request->file('photo')->store('violation_photos', 'public');
                    }
                }

                // 1. Create violation record in violationtbl
                $violationId = DB::connection('mysql')
                    ->table('violationtbl')
                    ->insertGetId([
                        'violation' => $request->violation,
                        'description' => $request->description,
                        'remarks' => $remarks,
                        'photo_path' => $photoPath,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                // 2. Create record in studenttbl WITH STUDENT DATA
                DB::connection('mysql')
                    ->table('studenttbl')
                    ->insert([
                        'student_no' => $student->student_no,
                        'violation_id' => $violationId,
                        'first_name' => $student->first_name,
                        'middle_initial' => $student->middle_initial,
                        'last_name' => $student->last_name,
                        'program' => $student->program,
                        'year_lvl' => $student->year_lvl,
                        'parent_contact_no' => $student->parent_contact_no,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
            });

            return redirect()->route('guard.dashboard')->with('success', 'Violation recorded successfully!');

        } catch (\Exception $e) {
            \Log::error('Error recording violation: ' . $e->getMessage());
            return redirect()->route('guard.dashboard')->with('error', 'Error recording violation: ' . $e->getMessage());
        }
    }

    private function getRemarks($attemptNumber)
    {
        return match($attemptNumber) {
            1 => '1st Offense',
            2 => '2nd Offense', 
            3 => 'SUSPENDED',
            default => 'SUSPENDED'
        };
    }
}