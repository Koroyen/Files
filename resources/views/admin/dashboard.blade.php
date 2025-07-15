@extends('layouts.admin')



@section('title', 'Admin Dashboard')

@section('content')
<div class="container mt-5">
    <div class="bg-dark text-white p-4 rounded shadow-sm">
        <h2>Welcome, Admin {{ auth()->user()->first_name }}</h2>
        <p class="text-muted">This is your admin dashboard.</p>

        <hr class="border-secondary">

        <div class="row">
            <div class="col-md-4">
                <div class="card bg-secondary text-white mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Users</h5>
                        <p class="card-text display-6">{{ $userCount }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-info text-white mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Uploaded Files</h5>
                        <p class="card-text display-6">{{ $fileCount }}</p>
                    </div>
                </div>
            </div>
            <!-- Add more cards or widgets here -->
        </div>
    </div>
</div>
@endsection