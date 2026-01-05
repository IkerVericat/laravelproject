<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\StudentApiController;
use App\Http\Controllers\API\TeacherApiController;
use App\Http\Controllers\API\CourseApiController;

Route::apiResource('students', StudentApiController::class);
Route::post('students/{id}/assign-course', [StudentApiController::class,  'assignCourse']);
Route::delete('students/{id}/remove-course', [StudentApiController::class, 'removeCourse']);
Route::apiResource('courses', CourseApiController::class);
