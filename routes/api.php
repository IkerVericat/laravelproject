<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\StudentApiController;
use App\Http\Controllers\API\CourseApiController;
use App\Http\Controllers\API\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->name('api.')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('students', StudentApiController::class);
    Route::post('students/{id}/assign-course', [StudentApiController::class,  'assignCourse']);
    Route::delete('students/{id}/remove-course', [StudentApiController::class, 'removeCourse']);
    Route::apiResource('courses', CourseApiController::class);
});
