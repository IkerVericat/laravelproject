@extends('layouts.app')

@section('content')
<h2>Edit Student</h2>
<form action="{{ route('students.update', $student) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" value="{{ $student->name }}" class="form-control" required>
        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" value="{{ $student->email }}" class="form-control" required>
        @error('email') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
        <label>Age</label>
        <input type="number" name="age" value="{{ $student->age }}" class="form-control" required>
        @error('age') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
        <label>Course</label>
        <select name="course_id" class="form-control" required>
            <option value="">Select a course</option>
            @foreach ($courses as $course)
                <option value="{{ $course->id }}" {{ (isset($student) && $student->course_id == $course->id) ? 'selected' : '' }}>
                    {{ $course->name }}
                </option>
            @endforeach
        </select>
        @error('course_id') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection