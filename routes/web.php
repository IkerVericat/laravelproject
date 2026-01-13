<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\TeachersController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\AuthController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes (require authentication)
Route::middleware('auth')->group(function () {
    Route::get('/', [StudentsController::class, 'index']);

    Route::get('/teachers/export', [TeachersController::class, 'export'])->name('teachers.export');
    Route::get('/students/export', [StudentsController::class, 'export'])->name('students.export');
    Route::get('/courses/export', [CoursesController::class, 'export'])->name('courses.export');

    Route::post('/students/{student}/assign-course', [StudentsController::class, 'assignCourse'])->name('students.assignCourse');
    Route::delete('/students/{student}/remove-course', [StudentsController::class, 'removeCourse'])->name('students.removeCourse');

    Route::resource('students', StudentsController::class);
    Route::resource('teachers', TeachersController::class);
    Route::resource('courses', CoursesController::class);
});
