@extends('layouts.adminLayout')
@section('title', 'Manage Students')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Manage Students</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Students</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div><i class="fas fa-users me-1"></i> Students List</div>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                <i class="fas fa-plus"></i> Add New Student
            </button>
        </div>
        <div class="card-body">
            <table id="studentsTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Course</th>
                        <th>Year & Section</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                    <tr>
                        <td>{{ $student->student_id }}</td>
                        <td>{{ $student->user->first_name }} {{ $student->user->last_name }}</td>
                        <td>{{ $student->user->email }}</td>
                        <td>{{ $student->course }}</td>
                        <td>{{ $student->year_level }}-{{ $student->section }}</td>
                        <td>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editStudentModal{{ $student->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            @if(!$student->enrollments()->exists())
                                <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this student?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-danger btn-sm" disabled title="Cannot delete enrolled student">
                                    <i class="fas fa-trash"></i>
                                </button>
                            @endif
                        </td>
                    </tr>
                    
                    <!-- Edit Student Modal -->
                    <div class="modal fade" id="editStudentModal{{ $student->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Student</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('admin.students.update', $student->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">First Name</label>
                                            <input type="text" class="form-control" name="first_name" value="{{ $student->user->first_name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Last Name</label>
                                            <input type="text" class="form-control" name="last_name" value="{{ $student->user->last_name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email" value="{{ $student->user->email }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Phone</label>
                                            <div class="input-group">
                                                <span class="input-group-text">+63</span>
                                                <input class="form-control phone-input" 
                                                       id="editPhone{{ $student->id }}" 
                                                       type="tel" 
                                                       name="phone" 
                                                       value="{{ $student->user->phone }}" 
                                                       placeholder="XXX XXXX XXX" 
                                                       pattern="[0-9]{3} [0-9]{4} [0-9]{3}"
                                                       maxlength="13"
                                                       required />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Birth Date</label>
                                            <input type="date" class="form-control" name="birth_date" value="{{ $student->user->birth_date }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Address</label>
                                            <textarea class="form-control" name="address" required>{{ $student->user->address }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Course</label>
                                            <input type="text" class="form-control" name="course" value="{{ $student->course }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Year Level</label>
                                            <input type="number" class="form-control" name="year_level" value="{{ $student->year_level }}" min="1" max="5" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Section</label>
                                            <input type="text" class="form-control" name="section" value="{{ $student->section }}" required>
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

<!-- Add Student Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.students.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">First Name</label>
                        <input type="text" class="form-control" name="first_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="last_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <div class="input-group">
                            <span class="input-group-text">+63</span>
                            <input class="form-control phone-input" 
                                   id="addPhone" 
                                   type="tel" 
                                   name="phone" 
                                   value="{{ old('phone') }}" 
                                   placeholder="XXX XXXX XXX" 
                                   pattern="[0-9]{3} [0-9]{4} [0-9]{3}"
                                   maxlength="13"
                                   required />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Birth Date</label>
                        <input type="date" class="form-control" name="birth_date" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" name="address" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Course</label>
                        <input type="text" class="form-control" name="course" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Year Level</label>
                        <input type="number" class="form-control" name="year_level" min="1" max="5" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Section</label>
                        <input type="text" class="form-control" name="section" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Student</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#studentsTable').DataTable({
        pageLength: 10,
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'excel', 'pdf', 'print'
        ]
    });

    // Phone number formatting
    $('.phone-input').on('input', function(e) {
        let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
        if (value.length > 9) value = value.slice(0, 9);
        
        let formattedValue = '';
        if (value.length >= 3) {
            formattedValue += value.slice(0, 3) + ' ';
        } else {
            formattedValue += value;
        }
        
        if (value.length >= 7) {
            formattedValue += value.slice(3, 7) + ' ';
            formattedValue += value.slice(7);
        } else if (value.length > 3) {
            formattedValue += value.slice(3);
        }
        
        e.target.value = formattedValue;
    });

    // Show validation errors in modals if they exist
    @if($errors->any())
        var modal = new bootstrap.Modal(document.getElementById('addStudentModal'));
        modal.show();
    @endif
});
</script>
@endpush

@push('styles')
<style>
    .input-group-text {
        background-color: #f8f9fa;
        border-right: none;
    }
    .input-group .form-control {
        border-left: none;
    }
    .phone-label {
        margin-left: 40px;
    }
</style>
@endpush