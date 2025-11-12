@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Student Violations</h2>

    {{-- Add New Violation Button --}}
    <a href="{{ route('violations.create') }}" class="btn btn-primary mb-3">Add New Violation</a>

    {{-- Violations Table --}}
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Student No.</th>
                <th>Violation</th>
                <th>Date</th>
                <th>Action Taken</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($violations as $violation)
            <tr>
                <td>{{ $violation->id }}</td>
                <td>{{ $violation->student_no }}</td>
                <td>{{ $violation->violation_name }}</td>
                <td>{{ $violation->created_at->format('Y-m-d') }}</td>
                <td>{{ $violation->action_taken }}</td>
                <td>
                    <a href="{{ route('violations.edit', $violation->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('violations.destroy', $violation->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this violation?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection