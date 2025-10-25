<!DOCTYPE html>
<html lang="en">
<head>
    
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

  <meta charset="UTF-8">
  <title>Guard Dashboard | PRMSU Gate System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #007bff, #004aad);
      min-height: 100vh;
      padding: 30px;
      font-family: "Poppins", sans-serif;
      color: #333;
    }

    .dashboard-container {
      background: #ffffff;
      border-radius: 15px;
      padding: 30px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
      max-width: 1200px;
      margin: auto;
    }

    h2 {
      text-align: center;
      color: #004aad;
      font-weight: 700;
      margin-bottom: 30px;
    }

    .card {
      border: none;
      background: #f8f9fa;
      border-radius: 12px;
    }

    label {
      font-weight: 600;
    }

    .btn-primary {
      background: #004aad;
      border: none;
      font-weight: 600;
      border-radius: 10px;
    }

    .btn-primary:hover {
      background: #007bff;
    }

    .logs {
      background: #fff;
      border-radius: 10px;
      padding: 15px;
      height: 420px;
      overflow-y: auto;
    }

    .log-item {
      border-bottom: 1px solid #ddd;
      padding: 10px 0;
    }

    .log-item:last-child {
      border-bottom: none;
    }

    .log-time {
      font-weight: bold;
      color: #004aad;
      font-size: 0.9rem;
    }

    .log-violation {
      color: #cc0000;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>
  <div class="dashboard-container">
    <h2>Guard Dashboard</h2>
    <div class="row g-4">

      <!-- LEFT: Student Info Form -->
      <div class="col-md-6">
        <div class="card p-4 shadow-sm">
          <h5 class="fw-semibold mb-3 text-center">Student Information</h5>

          <form method="POST" action="{{ route('guard.fetchStudent') }}">
            @csrf
            <div class="mb-3">
              <label for="student_no" class="form-label">Student Number</label>
              <input type="text" class="form-control" id="student_no" name="student_no" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 mb-3">Search</button>
          </form>

          @if(isset($student))
          <div class="border-top pt-3 mt-3">
            <p><strong>First Name:</strong> {{ $student->fname }}</p>
            <p><strong>Middle Name:</strong> {{ $student->mname }}</p>
            <p><strong>Last Name:</strong> {{ $student->lname }}</p>
            <p><strong>Course:</strong> {{ $student->program }}</p>
            <p><strong>Year:</strong> {{ $student->year_lvl }}</p>

            <form method="POST" action="{{ route('guard.addViolation') }}">
              @csrf
              <label class="fw-semibold mb-2">Violations:</label>
              <div class="d-flex flex-wrap gap-3 mb-3">
                <div><input type="radio" name="violation" value="Haircut"> Haircut</div>
                <div><input type="radio" name="violation" value="Shoes"> Shoes</div>
                <div><input type="radio" name="violation" value="Earrings and others"> Earrings & Others</div>
                <div><input type="radio" name="violation" value="Dyed hair"> Dyed Hair</div>
                <div><input type="radio" name="violation" value="Illegal substance"> Illegal Substance</div>
                <div><input type="radio" name="violation" value="No ID"> No ID</div>
              </div>

              <button type="submit" class="btn btn-success w-100">Add</button>
            </form>
          </div>
          @endif
        </div>
      </div>

      <!-- RIGHT: Logs -->
      <div class="col-md-6">
        <div class="card p-4 shadow-sm">
          <h5 class="fw-semibold mb-3 text-center">History / Logs</h5>
          <p class="text-center fw-semibold">{{ now()->format('F d, Y') }}</p>
          <div class="logs">
            @foreach($todayViolations as $log)
              <div class="log-item">
                <p>{{ $loop->iteration }}. {{ $log->student_no }} — {{ $log->fname }} {{ $log->lname }}, {{ $log->program }} {{ $log->year_lvl }}</p>
                <p class="log-violation">Violation: {{ $log->violation }}</p>
                <p class="log-time">{{ $log->created_at->format('h:i A') }}</p>
              </div>
            @endforeach
          </div>
        </div>
      </div>

    </div>
  </div>
</body>
</html>
