@extends('layouts.app')

@section('content')
<h2>Create Teacher</h2>
<form action="{{ route('teachers.store') }}" method="POST">
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
        <label>Subject</label>
        <input type="text" name="subject" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Phone</label>
        <input type="text" name="phone" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection