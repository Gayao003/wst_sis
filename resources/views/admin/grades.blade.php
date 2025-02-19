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
            <table id="datatablesSimple">
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
                        <td>{{ $enrollment->grade ? number_format($enrollment->grade->total_grade, 2) : '' }}</td>
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
            <form action="{{ route('admin.grades.update', $enrollment->grade ? $enrollment->grade->id : 'new') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="enrollment_id" value="{{ $enrollment->id }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Midterm</label>
                        <select class="form-control" name="midterm" required>
                            @for($grade = 1.00; $grade <= 5.00; $grade += 0.25)
                                <option value="{{ number_format($grade, 2) }}" 
                                    {{ isset($enrollment->grade->midterm) && $enrollment->grade->midterm == $grade ? 'selected' : '' }}>
                                    {{ number_format($grade, 2) }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Final</label>
                        <select class="form-control" name="final" required>
                            @for($grade = 1.00; $grade <= 5.00; $grade += 0.25)
                                <option value="{{ number_format($grade, 2) }}" 
                                    {{ isset($enrollment->grade->final) && $enrollment->grade->final == $grade ? 'selected' : '' }}>
                                    {{ number_format($grade, 2) }}
                                </option>
                            @endfor
                        </select>
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