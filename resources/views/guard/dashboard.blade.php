<!DOCTYPE html>
<html lang="en">
<head>
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
            background: #ff8c00;
        }

        .btn-success {
            background: #28a745;
            border: none;
            font-weight: 600;
            border-radius: 10px;
        }

        .btn-success:hover {
            background: #218838;
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

        .violation-history {
            max-height: 300px;
            overflow-y: auto;
        }

        .form-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .violation-photo {
            max-width: 100px;
            max-height: 100px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .photo-placeholder {
            width: 100px;
            height: 100px;
            background: #f8f9fa;
            border: 1px dashed #ddd;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            font-size: 0.8rem;
        }

        .form-control:disabled {
            background-color: #e9ecef;
            opacity: 1;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2>Guard Dashboard</h2>
        
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4">
            <!-- LEFT: Search and Input Form -->
            <div class="col-md-6">
                <div class="card p-4 shadow-sm">
                    <h5 class="fw-semibold mb-3 text-center">Student Search & Violation Entry</h5>

                    <!-- Search Form -->
                    <form method="POST" action="{{ route('guard.searchStudent') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="student_no" class="form-label">Student Number</label>
                            <input type="text" class="form-control" id="student_no" name="student_no" 
                                   value="{{ old('student_no', $student->student_no ?? '') }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mb-3">Search Student</button>
                    </form>

                    <!-- Clear Search Button -->
                    @if(isset($searchPerformed) && $searchPerformed)
                        <a href="{{ route('guard.dashboard') }}" class="btn btn-outline-secondary w-100 mb-4">
                            Clear Search
                        </a>
                    @endif

                    <!-- Student Info Display -->
                    @if(isset($student) && $student)
                    <div class="form-section">
                        <h6 class="fw-semibold">Student Information</h6>
                        <p><strong>Name:</strong> {{ $student->first_name }} {{ $student->middle_initial }} {{ $student->last_name }}</p>
                        <p><strong>Program:</strong> {{ $student->program }}</p>
                        <p><strong>Year Level:</strong> {{ $student->year_lvl }}</p>

                        <!-- Violation Entry Form -->
                        <form method="POST" action="{{ route('guard.addViolation') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="student_no" value="{{ $student->student_no }}">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Violation Type:</label>
                                <select name="violation" class="form-select" required>
                                    <option value="">Select Violation</option>
                                    <option value="No ID">No ID</option>
                                    <option value="Improper Uniform">Improper Uniform</option>
                                    <option value="Dyed Hair">Dyed Hair</option>
                                    <option value="Earrings and others">Earrings and Others</option>
                                    <option value="Inappropriate Hairstyle">Inappropriate Hairstyle</option>
                                    <option value="Illegal Substance">Illegal Substance</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3" placeholder="Enter violation details..."></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Upload Photo 
                                    <!--@if(isset($violations) && $violations->count() > 0)
                                        <span class="text-muted">(Disabled - Student has violation history)</span>
                                    @endif-->
                                </label>
                                <input type="file" name="photo" class="form-control" accept="image/*" 
                                    @if(isset($violations) && $violations->count() > 0) disabled @endif>
                                <!--@if(isset($violations) && $violations->count() > 0)
                                    <small class="text-muted"></small>HAHAHA bawal na!.</small>
                                @endif-->
                            </div>

                            <button type="submit" class="btn btn-success w-100">Record Violation</button>
                        </form>
                    </div>
                    @elseif(isset($searchPerformed) && $searchPerformed)
                        <div class="alert alert-warning text-center">
                            Student not found! Please check the student number.
                        </div>
                    @endif
                </div>
            </div>

            <!-- RIGHT: History/Logs -->
            <div class="col-md-6">
                <div class="card p-4 shadow-sm">
                    <h5 class="fw-semibold mb-3 text-center">History / Logs</h5>
                    <p class="text-center fw-semibold">{{ now()->format('F d, Y') }}</p>
                    
                    <!-- Violation History for Searched Student -->
                    @if(isset($violations) && $violations->count() > 0)
                    <div class="violation-history mb-4">
                        <h6 class="fw-semibold">Violation History for {{ $student->first_name }} {{ $student->last_name }}</h6>
                        @foreach($violations as $violation)
                            <div class="log-item">
                                <p class="mb-1"><strong>Violation:</strong> {{ $violation->violation }}</p>
                                <p class="mb-1"><strong>Description:</strong> {{ $violation->description ?? 'N/A' }}</p>
                                
                                <!-- Photo Display -->
                                <div class="mb-2">
                                    <strong>Photo Evidence:</strong>
                                     @if(isset($violation->photo_path) && $violation->photo_path)
                                        <div class="mt-1">
                                            <img src="{{ asset('storage/' . $violation->photo_path) }}" 
                                                 alt="Violation Photo" 
                                                 class="violation-photo"
                                                 onclick="openModal('{{ asset('storage/' . $violation->photo_path) }}')"
                                                 style="cursor: pointer;">
                                        </div>
                                    @else
                                        <div class="photo-placeholder mt-1">
                                            No Photo
                                        </div>
                                    @endif
                                </div>
                                
                                <p class="log-time mb-0">{{ \Carbon\Carbon::parse($violation->created_at)->format('M d, Y h:i A') }}</p>
                            </div>
                        @endforeach
                    </div>
                    @elseif(isset($searchPerformed) && $searchPerformed && isset($student))
                    <div class="alert alert-info text-center">
                        No record of violation yet!
                    </div>
                    @endif

                    <!-- Today's Logs -->
                    <div class="logs">
                        <h6 class="fw-semibold">Today's Violations</h6>
                        @if($todayViolations->count() > 0)
                            @foreach($todayViolations as $log)
                                <div class="log-item">
                                    <p class="mb-1">{{ $log->student_no }} — {{ $log->fname ?? '' }} {{ $log->lname ?? '' }}</p>
                                    <p class="log-violation mb-1">Violation: {{ $log->violation }}</p>
                                    
                                    <!-- Photo in Today's Logs -->
                                     @if(isset($log->photo_path) && $log->photo_path)
                                        <div class="mb-1">
                                            <img src="{{ asset('storage/' . $log->photo_path) }}" 
                                                 alt="Violation Photo" 
                                                 class="violation-photo"
                                                 onclick="openModal('{{ asset('storage/' . $log->photo_path) }}')"
                                                 style="cursor: pointer;">
                                        </div>
                                    @endif
                                    
                                    <p class="log-time mb-0">{{ \Carbon\Carbon::parse($log->created_at)->format('h:i A') }}</p>
                                </div>
                            @endforeach
                        @else
                            <p class="text-center text-muted">No violations recorded today.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Photo Modal -->
    <div class="modal fade" id="photoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Violation Photo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="Violation Photo" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Photo modal function
        function openModal(imageSrc) {
            document.getElementById('modalImage').src = imageSrc;
            const modal = new bootstrap.Modal(document.getElementById('photoModal'));
            modal.show();
        }

        // Disable photo upload if student has violation history
        document.addEventListener('DOMContentLoaded', function() {
            const violations = @json(isset($violations) && $violations->count() > 0 ? true : false);
            const photoInput = document.querySelector('input[name="photo"]');
            
            if (violations && photoInput) {
                photoInput.disabled = true;
            }
        });
    </script>
</body>
</html>