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
                        <td>
                            @if($enrollment->grade)
                                @switch($enrollment->grade->status)
                                    @case('FDA')
                                        5.00 (FDA)
                                        @break
                                    @case('LOA')
                                        LOA
                                        @break
                                    @case('INC')
                                        INC
                                        @break
                                    @default
                                        {{ number_format($enrollment->grade->total_grade, 2) }}
                                @endswitch
                            @endif
                        </td>
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
                            @for($grade = 1.00; $grade <= 3.00; $grade += 0.25)
                                <option value="{{ number_format($grade, 2) }}" 
                                    {{ isset($enrollment->grade->midterm) && $enrollment->grade->midterm == $grade ? 'selected' : '' }}>
                                    {{ number_format($grade, 2) }}
                                </option>
                            @endfor
                            <option value="5.00" {{ isset($enrollment->grade->midterm) && $enrollment->grade->midterm == 5.00 ? 'selected' : '' }}>5.00</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Final</label>
                        <select class="form-control" name="final" required>
                            @for($grade = 1.00; $grade <= 3.00; $grade += 0.25)
                                <option value="{{ number_format($grade, 2) }}" 
                                    {{ isset($enrollment->grade->final) && $enrollment->grade->final == $grade ? 'selected' : '' }}>
                                    {{ number_format($grade, 2) }}
                                </option>
                            @endfor
                            <option value="5.00" {{ isset($enrollment->grade->final) && $enrollment->grade->final == 5.00 ? 'selected' : '' }}>5.00</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-control" name="status" required>
                            <option value="Regular" {{ isset($enrollment->grade->status) && $enrollment->grade->status == 'Regular' ? 'selected' : '' }}>Regular</option>
                            <option value="FDA" {{ isset($enrollment->grade->status) && $enrollment->grade->status == 'FDA' ? 'selected' : '' }}>FDA (Failure Due to Absences)</option>
                            <option value="LOA" {{ isset($enrollment->grade->status) && $enrollment->grade->status == 'LOA' ? 'selected' : '' }}>LOA (Leave of Absence)</option>
                            <option value="INC" {{ isset($enrollment->grade->status) && $enrollment->grade->status == 'INC' ? 'selected' : '' }}>INC (Incomplete)</option>
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