@extends('layouts.app')

@section('content')
<h2>Create Course</h2>
<form action="{{ route('courses.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>
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
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection