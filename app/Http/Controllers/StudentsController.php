<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Exports\StudentsExport;
use Maatwebsite\Excel\Facades\Excel;

class StudentsController extends Controller
{

    public function index()
    {
        $students = Student::oldest()->paginate(5);
        return view('students.index', compact('students'));
    }

    public function create()
    {
        $courses = Course::all();
        return view('students.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'age' => 'required|integer',
            'course_id' => 'nullable|exists:courses,id',
        ]);

        Student::create($request->all());
        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $courses = Course::all();
        return view('students.edit', compact('student', 'courses'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'age' => 'required|integer',
            'course_id' => 'nullable|exists:courses,id',
        ]);

        $student->update($request->all());
        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }

    public function export() {
        return Excel::download(new StudentsExport, 'students.xlsx');
    }

    public function assignCourse(Request $request, Student $student)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id'
        ]);

        $student->update(['course_id' => $request->course_id]);

        return redirect()->back()->with('success', 'Estudiante asignado al curso correctamente');
    }

    public function removeCourse(Student $student)
    {
        $student->update(['course_id' => null]);

        return redirect()->back()->with('success', 'Estudiante removido del curso');
    }
}
