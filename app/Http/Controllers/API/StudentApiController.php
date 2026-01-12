<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;

class StudentApiController extends Controller
{
    public function index() {
        $students = Student::with('course')->get();
        return response()->json($students);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students',
            'age' => 'required|integer',
            'course_id' => 'nullable|exists:courses,id'
        ]);

        $student = Student::create($validated);
        return response()->json($student, 201);
    }

    public function show($id) {
        $student = Student::with('course')->findOrFail($id);
        return response()->json($student);
    }

    public function update(Request $request, $id) {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'name' => 'string|max:255',
            'email' => 'email|unique:students,email,' . $id,
            'age' => 'integer',
            'course_id' => 'nullable|exists:courses,id',
        ]);

        $student->update($validated);
        return response()->json($student);
    }

    public function destroy($id) {
        $student = Student::findOrFail($id);
        $student->delete();
        return response()->json(['message' => 'Student deleted Successfully'], 200);
    }

    public function assignCourse(Request $request, $id) {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id'
        ]);

        $student->update(['course_id' => $validated['course_id']]);
        return response()->json($student->load('course'));
    }

    public function removeCourse($id) {
        $student = Student::findOrFail($id);
        $student->update(['course_id' => null]);
        return response()->json($student);
    }
}
