@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h2>Show Student</h2>
    <div class="d-flex gap-2">
        <a class="btn btn-primary" href="{{ route('students.index') }}">Student list</a>
    </div>
</div>

<form action="{{ route('students.update', $student) }}" method="POST">
    <div class="mb-3">
        <label>Name</label>
        <p class="form-control">{{ $student->name }}</p>
    </div>
    <div class="mb-3">
        <label>Email</label>
        <p class="form-control">{{ $student->email }}</p>
    </div>
    <div class="mb-3">
        <label>Name</label>
        <p class="form-control">{{ $student->age }}</p>
    </div>
    <div class="mb-3">
        <label>Name</label>
        <p class="form-control">{{ $student->course }}</p>
    </div>
   </form>
@endsection