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
    <div class="mb-3">
        <label>Teacher (Optional)</label>
        <select name="teacher_id" class="form-control">
            <option value="">No teacher assigned</option>
            @foreach ($teachers as $teacher)
                <option value="{{ $teacher->id }}" {{ (isset($course) && $course->teacher_id == $teacher->id) ? 'selected' : '' }}>
                    {{ $teacher->name }}
                </option>
            @endforeach
        </select>
        @error('teacher_id') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection