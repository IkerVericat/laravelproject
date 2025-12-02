@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h2>Show Course</h2>
    <div class="d-flex gap-2">
        <a class="btn btn-primary" href="{{ route('courses.index') }}">Course list</a>
    </div>
</div>

<div class="mb-3">
    <label>ID</label>
    <p class="form-control">{{ $course->id }}</p>
</div>
<div class="mb-3">
    <label>Name</label>
    <p class="form-control">{{ $course->name }}</p>
</div>
<div class="mb-3">
    <label>Teacher</label>
    <p class="form-control">{{ $course->teacher ? $course->teacher->name : 'No teacher assigned' }}</p>
</div>
<div class="mb-3">
    <label>Students Enrolled</label>
    @if($course->students->count() > 0)
        <ul class="list-group">
            @foreach ($course->students as $student)
                <li class="list-group-item">{{ $student->name }}</li>
            @endforeach
        </ul>
    @else
        <p class="form-control">No students enrolled</p>
    @endif
</div>
@endsection