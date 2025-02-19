@extends('layouts.adminLayout')
@section('title', 'Manage Subjects')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Manage Subjects</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Subjects</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div><i class="fas fa-book me-1"></i> Subjects List</div>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addSubjectModal">
                <i class="fas fa-plus"></i> Add New Subject
            </button>
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Units</th>
                        <th>Semester</th>
                        <th>Year Level</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subjects as $subject)
                    <tr>
                        <td>{{ $subject->code }}</td>
                        <td>{{ $subject->name }}</td>
                        <td>{{ $subject->description }}</td>
                        <td>{{ $subject->units }}</td>
                        <td>{{ $subject->semester }}</td>
                        <td>{{ $subject->year_level }}</td>
                        <td>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editSubjectModal{{ $subject->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('admin.subjects.destroy', $subject->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Subject Modal -->
                    <div class="modal fade" id="editSubjectModal{{ $subject->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Subject</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('admin.subjects.update', $subject->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Subject Code</label>
                                            <input type="text" class="form-control" name="code" value="{{ $subject->code }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Subject Name</label>
                                            <input type="text" class="form-control" name="name" value="{{ $subject->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control" name="description">{{ $subject->description }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Units</label>
                                            <input type="number" class="form-control" name="units" value="{{ $subject->units }}" min="1" max="5" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Semester</label>
                                            <select class="form-select" name="semester" required>
                                                <option value="First" {{ $subject->semester == 'First' ? 'selected' : '' }}>First</option>
                                                <option value="Second" {{ $subject->semester == 'Second' ? 'selected' : '' }}>Second</option>
                                                <option value="Summer" {{ $subject->semester == 'Summer' ? 'selected' : '' }}>Summer</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Year Level</label>
                                            <select class="form-select" name="year_level" required>
                                                <option value="First Year" {{ $subject->year_level == 'First Year' ? 'selected' : '' }}>First Year</option>
                                                <option value="Second Year" {{ $subject->year_level == 'Second Year' ? 'selected' : '' }}>Second Year</option>
                                                <option value="Third Year" {{ $subject->year_level == 'Third Year' ? 'selected' : '' }}>Third Year</option>
                                                <option value="Fourth Year" {{ $subject->year_level == 'Fourth Year' ? 'selected' : '' }}>Fourth Year</option>
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

<!-- Add Subject Modal -->
<div class="modal fade" id="addSubjectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.subjects.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Subject Code</label>
                        <input type="text" class="form-control" name="code" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subject Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Units</label>
                        <input type="number" class="form-control" name="units" min="1" max="5" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Semester</label>
                        <select class="form-select" name="semester" required>
                            <option value="First">First</option>
                            <option value="Second">Second</option>
                            <option value="Summer">Summer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Year Level</label>
                        <select class="form-select" name="year_level" required>
                            <option value="First Year">First Year</option>
                            <option value="Second Year">Second Year</option>
                            <option value="Third Year">Third Year</option>
                            <option value="Fourth Year">Fourth Year</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Subject</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#datatablesSimple').DataTable({
        pageLength: 10,
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'excel', 'pdf', 'print'
        ]
    });

    @if($errors->any())
        var modal = new bootstrap.Modal(document.getElementById('addSubjectModal'));
        modal.show();
    @endif
});
</script>
@endpush