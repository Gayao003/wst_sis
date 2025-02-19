@extends('layouts.studentLayout')
@section('title', 'My Subjects')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">My Subjects</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Subjects</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-book me-1"></i>
            My Subjects
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Subject Code</th>
                        <th>Subject Name</th>
                        <th>Description</th>
                        <th>Units</th>
                        <th>School Year</th>
                        <th>Semester</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enrollments as $enrollment)
                    <tr>
                        <td>{{ $enrollment->subject->code }}</td>
                        <td>{{ $enrollment->subject->name }}</td>
                        <td>{{ $enrollment->subject->description }}</td>
                        <td>{{ $enrollment->subject->units }}</td>
                        <td>{{ $enrollment->school_year }}</td>
                        <td>{{ $enrollment->semester }}</td>
                        <td>
                            @if($enrollment->grade)
                                @if($enrollment->grade->total_grade <= 3.0)
                                    <span class="badge bg-success">PASSED</span>
                                @else
                                    <span class="badge bg-danger">FAILED</span>
                                @endif
                            @else
                                <span class="badge bg-info">ONGOING</span>
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