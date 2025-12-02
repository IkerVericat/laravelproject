    @extends('layouts.app')

    @section('content')
    <div class="d-flex justify-content-between mb-3">
        <h2>Students List</h2>
            <div class="d-flex gap-2">
                <a class="btn btn-primary" href="{{ route('courses.index') }}">Courses</a>
                <a class="btn btn-primary" href="{{ route('teachers.index') }}">Teachers</a>
                <a class="btn btn-primary" href="{{ route('students.create') }}">Create Student</a>
            </div>
    </div><br><br>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Age</th>
            <th>Course</th>
        </tr>
        @foreach ($students as $student)
        <tr>
            <td>{{ $student->id }}</td>
            <td>{{ $student->name }}</td>
            <td>{{ $student->email }}</td>
            <td>{{ $student->age }}</td>
            <td>{{ $student->course ? $student->course->name : 'no course assigned' }}</td>
            <td>

                <a class="btn btn-info btn-sm" href="{{ route('students.show', $student) }}">Show</a>
                <a class="btn btn-warning btn-sm" href="{{ route('students.edit', $student) }}">Edit</a>
                <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline">
                   @csrf @method('DELETE')
                   <button type="submit" class="btn btn-danger btn-sm">Delete</button> 
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    {{ $students->links() }}
    @endsection