<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <style>
    body { font-family: Poppins, sans-serif; padding: 40px; background: #f8fafc; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { padding: 8px 12px; border: 1px solid #ccc; }
    th { background: #004aad; color: white; }
    .offense3 { background-color: #ffcccc; } /* highlight 3rd offense */
  </style>
</head>
<body>
  <h2>Admin Dashboard - Violation Records</h2>
  <a href="{{ route('admin.logout') }}">Logout</a>
  <div class="dashboard-summary" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div style="display: flex; gap: 20px;">
        <div style="background-color: #f5f5f5; padding: 15px 25px; border-radius: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <h4 style="margin: 0; font-size: 16px;">Total Students</h4>
            <p style="font-size: 22px; font-weight: bold; margin: 5px 0 0 0;">{{ $totalStudents ?? 0 }}</p>
        </div>
        <div style="background-color: #f5f5f5; padding: 15px 25px; border-radius: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <h4 style="margin: 0; font-size: 16px;">Total Violations</h4>
            <p style="font-size: 22px; font-weight: bold; margin: 5px 0 0 0;">{{ $totalViolations ?? 0 }}</p>
        </div>
    </div>
    <form action="{{ route('admin.export.csv') }}" method="GET">
        <button type="submit" style="background-color: #007bff; color: white; padding: 10px 18px; border: none; border-radius: 6px; cursor: pointer;">
            📤 Export to CSV
        </button>
    </form>
</div>  
  <table>
    <thead>
        <tr>
            <th>Photo</th>
            <th>Student No</th>
            <th>Full Name</th>
            <th>Program</th>
            <th>Year Level</th>
            <th>Parent Contact</th>
            <th>Violation</th>
            <th>Description</th>
            <th>Remarks</th>
            <th>Date & Time</th>
        </tr>
    </thead>
    <tbody>
        @foreach($violations as $v)
        <tr>
            <td>
                @if($v->photo_path)
                    <img src="{{ asset('storage/' . $v->photo_path) }}" alt="Photo" width="50" height="50" style="border-radius: 6px; object-fit: cover;">
                @else
                    <span>No Photo</span>
                @endif
            </td>
            <td>{{ $v->student_no }}</td>
            <td>{{ $v->first_name }} {{ $v->last_name }}</td>
            <td>{{ $v->program }}</td>
            <td>{{ $v->year_lvl }}</td>
            <td>{{ $v->parent_contact_no }}</td>
            <td>{{ $v->violation }}</td>
            <td>{{ $v->description }}</td>
            <td>{{ $v->remarks }}</td>
            <td>{{ $v->created_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>