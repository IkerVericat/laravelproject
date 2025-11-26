@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h2>Teachers List</h2>
    <a class="btn btn-primary" href="{{ route('teachers.create') }}">Create Teacher</a>
</div>
@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Subject</th>
        <th>Phone</th>
        <th>Actions</th>
    </tr>
    @foreach ($teachers as $teacher)
    <tr>
        <td>{{ $teacher->id }}</td>
        <td>{{ $teacher->name }}</td>
        <td>{{ $teacher->email }}</td>
        <td>{{ $teacher->subject }}</td>
        <td>{{ $teacher->phone }}</td>
        <td>
            <a class="btn btn-info btn-sm" href="{{ route('teachers.show', $teacher) }}">Show</a>
            <a class="btn btn-warning btn-sm" href="{{ route('teachers.edit', $teacher) }}">Edit</a>
            <form action="{{ route('teachers.destroy', $teacher) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
{{ $teachers->links() }}
@endsection