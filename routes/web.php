<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\TeachersController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('students', StudentsController::class);
Route::resource('teachers', TeachersController::class);