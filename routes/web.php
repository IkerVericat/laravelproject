<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentsController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('students', StudentsController::class);