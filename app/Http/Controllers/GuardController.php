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

        // Get student from student_db
        $student = Student::on('mysql_STUDENT')->where('student_no', $studentNo)->first();

        if ($student) {
            // Get violation history directly from violationtbl
            $violations = DB::connection('mysql')
                ->table('violationtbl')
                ->where('student_no', $studentNo)
                ->select(
                    'violation_id',
                    'violation',
                    'description',
                    'remarks',
                    'photo_path',
                    'created_at'
                )
                ->orderBy('created_at', 'desc')
                ->get();

            $violations = $violations->map(function ($violation) {
                $violation->created_at = \Carbon\Carbon::parse($violation->created_at);
                return $violation;
            });
        }

        $studentDB = DB::connection('mysql_STUDENT')->getDatabaseName();

        // Get today's violations
        $todayViolations = DB::connection('mysql')
            ->table('violationtbl')
            ->join("$studentDB.students as students", 'violationtbl.student_no', '=', 'students.student_no')
            ->select(
                'violationtbl.student_no',
                'students.first_name',
                'students.last_name',
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
                
                // Check if student exists in student_db (mysql_STUDENT)
                $student = Student::on('mysql_STUDENT')->where('student_no', $studentNo)->first();
                
                if (!$student) {
                    throw new \Exception('Student not found in database.');
                }


                // Count existing violations for this student from violationtbl
                $violationCount = DB::connection('mysql')
                    ->table('violationtbl')
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

                // Create violation record in violationtbl
                DB::connection('mysql')
                    ->table('violationtbl')
                    ->insert([
                        'student_no' => $studentNo,
                        'violation' => $request->violation,
                        'description' => $request->description,
                        'remarks' => $remarks,
                        'photo_path' => $photoPath,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                // Check if student already exists in studenttbl
                $studentExistsInTbl = DB::connection('mysql')
                    ->table('studenttbl')
                    ->where('student_no', $studentNo)
                    ->exists();

                if (!$studentExistsInTbl) {
                    // Insert student data without violation_id
                    DB::connection('mysql')
                        ->table('studenttbl')
                        ->insert([
                            'student_no' => $student->student_no,
                            'first_name' => $student->first_name,
                            'middle_initial' => $student->middle_initial,
                            'last_name' => $student->last_name,
                            'program' => $student->program,
                            'year_lvl' => $student->year_lvl,
                            'parent_contact_no' => $student->parent_contact_no,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                }
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