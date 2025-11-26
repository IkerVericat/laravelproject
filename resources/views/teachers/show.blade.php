@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h2>Show Teacher</h2>
    <div class="d-flex gap-2">
        <a class="btn btn-primary" href="{{ route('teachers.index') }}">Teacher list</a>
    </div>
</div>

<form action="{{ route('teachers.update', $teacher) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-3">
        <label>Name</label>
        <p class="form-control">{{ $teacher->name }}</p>
    </div>
    <div class="mb-3">
        <label>Email</label>
        <p class="form-control">{{ $teacher->email }}</p>
    </div>
    <div class="mb-3">
        <label>Name</label>
        <p class="form-control">{{ $teacher->subject }}</p>
    </div>
    <div class="mb-3">
        <label>Name</label>
        <p class="form-control">{{ $teacher->phone }}</p>
    </div>
   </form>
@endsection