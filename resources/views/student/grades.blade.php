@extends('layouts.studentLayout')
@section('title', 'My Grades')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">My Grades</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Grades</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Grade History
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Subject Code</th>
                        <th>Subject Name</th>
                        <th>School Year</th>
                        <th>Semester</th>
                        <th>Midterm</th>
                        <th>Finals</th>
                        <th>Final Grade</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enrollments as $enrollment)
                    <tr>
                        <td>{{ $enrollment->subject->code }}</td>
                        <td>{{ $enrollment->subject->name }}</td>
                        <td>{{ $enrollment->school_year }}</td>
                        <td>{{ $enrollment->semester }}</td>
                        <td>{{ $enrollment->grade->midterm ?? 'N/A' }}</td>
                        <td>{{ $enrollment->grade->final ?? 'N/A' }}</td>
                        <td>{{ $enrollment->grade->total_grade ?? 'N/A' }}</td>
                        <td>
                            @if(isset($enrollment->grade->total_grade))
                                @if($enrollment->grade->total_grade <= 3.0)
                                    <span class="text-success">PASSED</span>
                                @else
                                    <span class="text-danger">FAILED</span>
                                @endif
                            @else
                                <span class="text-muted">PENDING</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection