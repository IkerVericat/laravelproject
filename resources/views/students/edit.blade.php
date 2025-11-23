@extends('layouts.app')

@section('content')
<h2>Edit Student</h2>
<form action="{{ route('students.update' , $student) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" value="{{ $student->name }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Email</label>
        <textarea name="content" class="form-control" required>{{ $student->email }}</textarea>
    </div>
    <div class="mb-3">
        <label>Age</label>
        <textarea name="age" class="form-control" required>{{ $student->age }}</textarea>
    </div>
    <div class="mb-3">
        <label>Course</label>
        <textarea name="course" class="form-control" required>{{ $student->course }}</textarea>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection