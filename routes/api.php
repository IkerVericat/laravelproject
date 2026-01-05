<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\StudentApiController;
use App\Http\Controllers\API\TeacherApiController;
use App\Http\Controllers\API\CourseApiController;
use App\Http\Controllers\API\AuthController;

// Rutas Públicas
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rutas Protegidas
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('students', StudentApiController::class);
    Route::post('students/{id}/assign-course', [StudentApiController::class,  'assignCourse']);
    Route::delete('students/{id}/remove-course', [StudentApiController::class, 'removeCourse']);
    Route::apiResource('courses', CourseApiController::class);
});
