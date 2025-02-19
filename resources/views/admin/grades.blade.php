@extends('layouts.adminLayout')
@section('title', 'Manage Grades')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Manage Grades</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Grades</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-star me-1"></i> Student Grades
        </div>
        <div class="card-body">
            <table id="gradesTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Student Name</th>
                        <th>Subject</th>
                        <th>School Year</th>
                        <th>Semester</th>
                        <th>Midterm</th>
                        <th>Final</th>
                        <th>Total Grade</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enrollments as $enrollment)
                    <tr>
                        <td>{{ $enrollment->student->student_id }}</td>
                        <td>{{ $enrollment->student->user->first_name }} {{ $enrollment->student->user->last_name }}</td>
                        <td>{{ $enrollment->subject->name }}</td>
                        <td>{{ $enrollment->school_year }}</td>
                        <td>{{ $enrollment->semester }}</td>
                        <td>{{ $enrollment->grade->midterm ?? '' }}</td>
                        <td>{{ $enrollment->grade->final ?? '' }}</td>
                        <td>{{ $enrollment->grade->total_grade ?? '' }}</td>
                        <td>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editGradeModal{{ $enrollment->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@foreach($enrollments as $enrollment)
<!-- Edit Grade Modal -->
<div class="modal fade" id="editGradeModal{{ $enrollment->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Grade</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.grades.store') }}" method="POST">
                @csrf
                @if($enrollment->grade)
                    @method('PUT')
                @endif
                <input type="hidden" name="enrollment_id" value="{{ $enrollment->id }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Midterm</label>
                        <input type="number" step="0.01" class="form-control" name="midterm" value="{{ $enrollment->grade->midterm ?? '' }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Final</label>
                        <input type="number" step="0.01" class="form-control" name="final" value="{{ $enrollment->grade->final ?? '' }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Grade</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#gradesTable').DataTable({
        pageLength: 10,
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'excel', 'pdf', 'print'
        ]
    });
});
</script>
@endpush