<?php

use Illuminate\Support\Facades\Route;
use App\http\Controllers\StudentsController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('students', PostController::class);