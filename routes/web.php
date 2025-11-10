<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\GuardController;
use App\Http\Controllers\AdminController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Homepage (index.blade.php)
Route::get('/', [RoleController::class, 'index'])->name('home');
Route::post('/select-role', [RoleController::class, 'selectRole'])->name('select-role');

// Guard routes
Route::get('/guard/login', [AuthController::class, 'showGuardLogin'])->name('guard.login');
Route::post('/guard/login', [AuthController::class, 'loginGuard'])->name('guard.login.submit');
Route::get('/guard/dashboard', [AuthController::class, 'guardDashboard'])->name('guard.dashboard');
Route::post('/guard/search', [GuardController::class, 'fetchStudent'])->name('guard.searchStudent');
Route::post('/guard/add-violation', [GuardController::class, 'addViolation'])->name('guard.addViolation');

// Admin routes
Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'loginAdmin'])->name('admin.login.submit');
Route::get('/admin/dashboard', [AuthController::class, 'adminDashboard'])->name('admin.dashboard');

// Manage students
Route::get('/admin/students', [AdminController::class, 'students'])->name('admin.students');
Route::post('/admin/students/add', [AdminController::class, 'addStudent'])->name('admin.students.add');

// Manage violations
Route::get('/admin/violations', [AdminController::class, 'violations'])->name('admin.violations');
Route::post('/admin/violations/add', [AdminController::class, 'addViolation'])->name('admin.violations.add');

// Add violation record
Route::post('/guard/add', [GuardController::class, 'addViolation'])->name('guard.add');

// Fetch student info (for AJAX)
Route::post('/guard/fetch-student', [GuardController::class, 'fetchStudent'])->name('guard.fetchStudent');

// Search student (form POST)
//Route::post('/guard/search', [GuardController::class, 'searchStudent'])->name('guard.searchStudent');
Route::post('/guard/search', [App\Http\Controllers\GuardController::class, 'fetchStudent'])->name('guard.searchStudent');

// Logout to index route
Route::get('/admin/logout', [AuthController::class, 'logoutForm'])->name('form.logout');






Route::get('/verify-fix', function() {
    echo "=== studenttbl structure ===<br>";
    $columns = DB::connection('mysql')->select('SHOW COLUMNS FROM studenttbl');
    foreach ($columns as $column) {
        echo "{$column->Field} ({$column->Type})<br>";
    }
    
    echo "<br>=== Testing duplicate prevention ===<br>";
    try {
        // Try to insert a duplicate
        DB::connection('mysql')->table('studenttbl')->insert([
            'student_no' => 'TEST-001',
            'violation_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        echo "First insert: SUCCESS<br>";
        
        // Try to insert the same combination again
        DB::connection('mysql')->table('studenttbl')->insert([
            'student_no' => 'TEST-001', 
            'violation_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        echo "Second insert: FAILED (this is good - duplicates are prevented)<br>";
    } catch (\Exception $e) {
        echo "Second insert: " . $e->getMessage() . "<br>";
    }
    
    // Clean up test data
    DB::connection('mysql')->table('studenttbl')->where('student_no', 'TEST-001')->delete();
});