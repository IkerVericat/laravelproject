@extends('layouts.app')

@section('content')
<h2>Create Course</h2>
<form action="{{ route('courses.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection