@extends('layouts.studentLayout')
@section('title', 'Student Dashboard')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Student Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    Welcome, {{ Auth::user()->first_name }}!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection