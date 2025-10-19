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
  <table>
    <thead>
      <tr>
        <th>Student ID</th>
        <th>Violations</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      @foreach($violations as $v)
      <tr @if($loop->iteration % 3 == 0) class="offense3" @endif>
        <td>{{ $v->student_id }}</td>
        <td>{{ $v->violations }}</td>
        <td>{{ $v->created_at }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>