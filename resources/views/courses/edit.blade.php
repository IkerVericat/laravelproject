@extends('layouts.app')
@section('content')

<h2>Edit Course</h2>
<form action="{{ route('courses.update', $course) }}" method="POST">
    @csrf @method('PUT')
    <div clas="mb-3">
        <label>Name</label>
        <input type="text" name="name" value="{{ $course->name }}" class="form-control" required>
        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection