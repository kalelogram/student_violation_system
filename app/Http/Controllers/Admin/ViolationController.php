<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Violation;

class ViolationController extends Controller
{
    // Show all violations
    public function index()
    {
        // Get all violations from violationtbl
        $violations = Violation::orderBy('violation_id', 'desc')->get();

        return view('admin.violationlist', compact('violations'));
    }

    // Store a new violation
    public function store(Request $request)
    {
        $validated = $request->validate([
            'violation' => 'required|string|max:255',
            'description' => 'nullable|string',
            'remarks' => 'nullable|string',
            'photo_path' => 'nullable|string'
        ]);

        Violation::create($validated);

        return redirect()->back()->with('success', 'Violation added successfully.');
    }

    // Export violations to CSV
    public function exportCSV()
    {
        $violations = Violation::all();

        $filename = "violations_" . date('Ymd_His') . ".csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['Violation ID', 'Violation', 'Description', 'Remarks', 'Photo Path']);

        foreach ($violations as $v) {
            fputcsv($handle, [
                $v->violation_id,
                $v->violation,
                $v->description,
                $v->remarks,
                $v->photo_path,
            ]);
        }

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }
}