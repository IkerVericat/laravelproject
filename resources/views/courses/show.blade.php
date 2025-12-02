@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h2>Show Course</h2>
    <div class="d-flex gap-2">
        <a class="btn btn-primary" href="{{ route('courses.index') }}">Course list</a>
    </div>
</div>

    <div class="mb-3">
        <label>id</label>
        <p class="form-control">{{ $course->id }}</p>
    </div>
    <div class="mb-3">
        <label>Name</label>
        <p class="form-control">{{ $course->name }}</p>
    </div>
@endsection