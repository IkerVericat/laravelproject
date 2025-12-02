<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\TeachersController;
use App\Http\Controllers\CoursesController;

# Route::get('/', function () {
#     return view('students/index');
# });

Route::get('/', [StudentsController::class, 'index']);

Route::resource('students', StudentsController::class);
Route::resource('teachers', TeachersController::class);
Route::resource('courses', CoursesController::class);