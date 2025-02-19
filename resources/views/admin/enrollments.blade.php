@extends('layouts.adminLayout')
@section('title', 'Manage Enrollments')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Manage Enrollments</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Enrollments</li>
    </ol>

    @if(session('error') || $errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        @if(session('error'))
            {{ session('error') }}
        @else
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div><i class="fas fa-user-graduate me-1"></i> Enrollments List</div>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addEnrollmentModal">
                <i class="fas fa-plus"></i> Add New Enrollment
            </button>
        </div>
        <div class="card-body">
            <table id="enrollmentsTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Student Name</th>
                        <th>Subject Code</th>
                        <th>Subject Name</th>
                        <th>School Year</th>
                        <th>Semester</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enrollments as $enrollment)
                    <tr>
                        <td>{{ $enrollment->student->student_id }}</td>
                        <td>{{ $enrollment->student->user->first_name }} {{ $enrollment->student->user->last_name }}</td>
                        <td>{{ $enrollment->subject->code }}</td>
                        <td>{{ $enrollment->subject->name }}</td>
                        <td>{{ $enrollment->school_year }}</td>
                        <td>{{ $enrollment->semester }}</td>
                        <td>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editEnrollmentModal{{ $enrollment->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('admin.enrollments.destroy', $enrollment->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <!-- Edit Enrollment Modal -->
                    <div class="modal fade" id="editEnrollmentModal{{ $enrollment->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Enrollment</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('admin.enrollments.update', $enrollment->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Student</label>
                                            <select class="form-select" name="student_id" required>
                                                @foreach($students as $student)
                                                    <option value="{{ $student->id }}" {{ $enrollment->student_id == $student->id ? 'selected' : '' }}>
                                                        {{ $student->student_id }} - {{ $student->user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Subject</label>
                                            <select class="form-select" name="subject_id" required>
                                                @foreach($subjects as $subject)
                                                    <option value="{{ $subject->id }}" {{ $enrollment->subject_id == $subject->id ? 'selected' : '' }}>
                                                        {{ $subject->code }} - {{ $subject->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">School Year</label>
                                            <div class="input-group">
                                                <select class="form-select start-year" name="start_year" required>
                                                    @php
                                                        $currentYear = date('Y');
                                                        $startYear = $currentYear - 5;
                                                        $endYear = $currentYear + 5;
                                                        $enrollmentStartYear = explode('-', $enrollment->school_year)[0];
                                                    @endphp
                                                    @for($year = $startYear; $year <= $endYear; $year++)
                                                        <option value="{{ $year }}" {{ $year == $enrollmentStartYear ? 'selected' : '' }}>
                                                            {{ $year }}
                                                        </option>
                                                    @endfor
                                                </select>
                                                <span class="input-group-text">-</span>
                                                <select class="form-select end-year" name="end_year" required>
                                                    @php
                                                        $enrollmentEndYear = explode('-', $enrollment->school_year)[1];
                                                    @endphp
                                                    @for($year = $startYear; $year <= $endYear; $year++)
                                                        <option value="{{ $year }}" {{ $year == $enrollmentEndYear ? 'selected' : '' }}>
                                                            {{ $year }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Semester</label>
                                            <select class="form-select" name="semester" required>
                                                <option value="First" {{ $enrollment->semester == 'First' ? 'selected' : '' }}>First</option>
                                                <option value="Second" {{ $enrollment->semester == 'Second' ? 'selected' : '' }}>Second</option>
                                                <option value="Summer" {{ $enrollment->semester == 'Summer' ? 'selected' : '' }}>Summer</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Enrollment Modal -->
<div class="modal fade" id="addEnrollmentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Enrollment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.enrollments.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Student</label>
                        <select class="form-select" name="student_id" required>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->student_id }} - {{ $student->user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subject</label>
                        <select class="form-select" name="subject_id" required>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->code }} - {{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">School Year</label>
                        <div class="input-group">
                            <select class="form-select" name="start_year" id="startYear" required>
                                @php
                                    $currentYear = date('Y');
                                    $startYear = $currentYear - 5;
                                    $endYear = $currentYear + 5;
                                @endphp
                                @for($year = $startYear; $year <= $endYear; $year++)
                                    <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>
                            <span class="input-group-text">-</span>
                            <select class="form-select" name="end_year" id="endYear" required>
                                @for($year = $startYear; $year <= $endYear; $year++)
                                    <option value="{{ $year }}" {{ $year == ($currentYear + 1) ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Semester</label>
                        <select class="form-select" name="semester" required>
                            <option value="First">First</option>
                            <option value="Second">Second</option>
                            <option value="Summer">Summer</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Enrollment</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#enrollmentsTable').DataTable({
        pageLength: 10,
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'excel', 'pdf', 'print'
        ]
    });

    // Automatically update end year when start year changes
    $('#startYear').change(function() {
        var startYear = parseInt($(this).val());
        var endYear = parseInt($('#endYear').val());
        
        if (startYear >= endYear) {
            $('#endYear').val(startYear + 1);
        }
    });

    // Prevent end year from being less than start year
    $('#endYear').change(function() {
        var startYear = parseInt($('#startYear').val());
        var endYear = parseInt($(this).val());
        
        if (endYear <= startYear) {
            $(this).val(startYear + 1);
        }
    });

    // Show validation errors in modal if they exist
    @if($errors->any())
        var modal = new bootstrap.Modal(document.getElementById('addEnrollmentModal'));
        modal.show();
    @endif
});
</script>
@endpush