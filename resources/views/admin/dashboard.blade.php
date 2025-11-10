<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <style>
    body {
      font-family: "Poppins", sans-serif;
      padding: 40px;
      background: #f8fafc;
    }

    h2 {
      color: #004aad;
      font-weight: 700;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      padding: 10px 14px;
      border: 1px solid #ccc;
      text-align: left;
    }

    th {
      background: #004aad;
      color: white;
    }

    .offense3 {
      background-color: #ffcccc; /* highlight 3rd offense */
    }

    .logout-container {
      display: flex;
      align-items: center;
      justify-content: flex-start;
      margin-top: 25px;
    }

    .logout-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: #004aad;
      color: white;
      border: none;
      border-radius: 10px;
      padding: 10px 18px;
      font-size: 1rem;
      font-weight: 600;
      text-decoration: none;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .logout-btn:hover {
      background: #ff8c00;
      transform: scale(1.05);
    }

    .logout-btn img {
      width: 20px;
      height: 20px;
      vertical-align: middle;
      filter: brightness(0) invert(1);
      transition: transform 0.3s ease;
    }

    .logout-btn:hover img {
      transform: translateX(-2px);
    }

  </style>
</head>
<body>
  <h2>Admin Dashboard - Violation Records</h2>
  <table>
    <thead>
      <tr>
        <th>Student No</th>
        <th>Violation</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      @foreach($violations as $v)
      <tr @if($loop->iteration % 3 == 0) class="offense3" @endif>
        <td>{{ $v->student_no }}</td>
        <td>{{ $v->violation }}</td>
        <td>{{ $v->created_at }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <div class="logout-container">
    <a href="{{ route('form.logout') }}" class="logout-btn">Logout
      <img src="{{ asset('logout.png') }}" alt="Logout-icon">
    </a>
  </div>
</body>
</html>