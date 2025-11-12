@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow p-4" style="border-radius: 15px;">
        <h4 class="text-center mb-4 fw-bold">Student Violation Records</h4>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <form action="{{ route('admin.dashboard') }}" method="GET" class="d-flex align-items-center" style="width: 300px;">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    class="form-control me-2" 
                    placeholder="Search record..."
                >
                <button type="submit" class="btn btn-dark">Search</button>
            </form>

            <div class="text-end">
                <span><strong>Total Students:</strong> {{ $totalStudents }}</span> |
                <span><strong>Total Violations:</strong> {{ $totalViolations }}</span>
            </div>
        </div>

        <div class="mb-3 text-end">
            <button class="btn btn-dark me-2">Add</button>
            <button class="btn btn-dark me-2">Save</button>
            <button class="btn btn-dark me-2">Edit</button>
            <button class="btn btn-dark me-2">Update</button>
            <button class="btn btn-dark me-2">Delete</button>
            <button class="btn btn-dark">Cancel</button>
        </div>

        <div style="overflow-x: auto; max-height: 500px; overflow-y: auto;">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>Student No</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Program</th>
                        <th>Year Level</th>
                        <th>Parent Contact</th>
                        <th>Violation</th>
                        <th>Description</th>
                        <th>Remarks</th>
                        <th>Photo</th>
                        <th>Date & Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($violations as $v)
                        <tr>
                            <td>{{ $v->student_no }}</td>
                            <td>{{ $v->first_name }}</td>
                            <td>{{ $v->last_name }}</td>
                            <td>{{ $v->program }}</td>
                            <td>{{ $v->year_lvl }}</td>
                            <td>{{ $v->parent_contact_no }}</td>
                            <td>{{ $v->violation }}</td>
                            <td>{{ $v->description }}</td>
                            <td>{{ $v->remarks }}</td>
                            <td>
                                @if($v->photo_path)
                                    <img src="{{ asset('storage/' . $v->photo_path) }}" alt="Photo" width="60" height="60" style="object-fit: cover; border-radius: 8px;">
                                @else
                                    <span class="text-muted">No photo</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($v->created_at)->format('Y-m-d | h:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-muted">No records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $violations->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<style>
.btn-dark {
    background-color: #000;
    border: none;
    transition: 0.2s;
}
.btn-dark:hover {
    background-color: #ffb700;
    color: #000;
}
</style>
@endsection