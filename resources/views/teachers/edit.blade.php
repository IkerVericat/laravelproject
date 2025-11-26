@extends('layouts.app')

@section('content')
<h2>Edit Teacher</h2>
<form action="{{ route('teachers.update', $teacher) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" value="{{ $teacher->name }}" class="form-control" required>
        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" value="{{ $teacher->email }}" class="form-control" required>
        @error('email') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
        <label>Subject</label>
        <input type="text" name="subject" value="{{ $teacher->subject }}" class="form-control" required>
        @error('subject') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
        <label>Phone</label>
        <input type="tel" name="phone" value="{{ $teacher->phone }}" class="form-control" required>
        @error('phone') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection