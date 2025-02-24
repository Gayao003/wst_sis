@extends('layouts.studentLayout')
@section('title', 'Student Dashboard')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Student Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    
    <div class="row">
        <!-- Student Information Card -->
        <div class="col-xl-4 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <h5>Welcome, {{ Auth::user()->first_name }}!</h5>
                    <div class="mt-3">
                        <p class="mb-1"><i class="fas fa-id-card me-2"></i>{{ Auth::user()->student->student_id }}</p>
                        <p class="mb-1"><i class="fas fa-graduation-cap me-2"></i>{{ Auth::user()->student->course }}</p>
                        <p class="mb-1"><i class="fas fa-users me-2"></i>{{ Auth::user()->student->year_level }}-{{ Auth::user()->student->section }}</p>
                        <p class="mb-1"><i class="fas fa-envelope me-2"></i>{{ Auth::user()->email }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Enrollment Card -->
        <div class="col-xl-4 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <h5><i class="fas fa-calendar-alt me-2"></i>Current Enrollment</h5>
                    <div class="mt-3">
                        <p class="mb-1">School Year: {{ date('Y') }}-{{ date('Y')+1 }}</p>
                        <p class="mb-1">Semester: {{ $currentSemester }}</p>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('student.enrollment.show') }}">View Enrollment</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

    </div>

    <!-- Recent Grades Table -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Recent Grades
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Midterm</th>
                        <th>Final</th>
                        <th>Grade</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentGrades ?? [] as $grade)
                    <tr>
                        <td>{{ $grade->enrollment->subject->name }}</td>
                        <td>{{ $grade->midterm ?? 'N/A' }}</td>
                        <td>{{ $grade->final ?? 'N/A' }}</td>
                        <td>{{ $grade->total_grade ?? 'N/A' }}</td>
                        <td>
                            @if($grade->total_grade <= 3.0)
                                <span class="badge bg-success">PASSED</span>
                            @else
                                <span class="badge bg-danger">FAILED</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No grades available</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection