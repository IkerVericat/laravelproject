@extends('layouts.app')

@section('content')
<h2>Create Student</h2>
<form action="{{ route('students.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Email</label>
        <textarea name="email" class="form-control" required></textarea>
    </div>
    <div class="mb-3">
        <label>Age</label>
        <input type="text" name="age" class="form-control" required>
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

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection