<?php

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
Route::get('/guard/login', [GuardController::class, 'showLogin'])->name('guard.login');
Route::post('/guard/login', [GuardController::class, 'login'])->name('guard.login.post');
Route::get('/guard/dashboard', [GuardController::class, 'dashboard'])->name('guard.dashboard');

// Admin routes
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.post');
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

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
Route::post('/guard/search', [GuardController::class, 'searchStudent'])->name('guard.searchStudent');