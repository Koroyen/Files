@extends('layouts.admin')

@section('title', 'Deletion Requests')

@section('content')
<div class="container mt-4">
    <div class="bg-dark text-white p-4 rounded shadow-sm">
        <h4 class="mb-4">Pending Deletion Requests</h4>

        @if($requests->isEmpty())
            <p>No pending requests.</p>
        @else
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>File Title</th>
                    <th>UUID</th>
                    <th>Requested By</th>
                    <th>Requested At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $req)
                <tr>
                    <td>{{ $req->file->title }}</td>
                    <td>{{ $req->file->uuid }}</td>
                    <td>{{ $req->user->name ?? $req->user->email }}</td>
                    <td>{{ $req->created_at->format('Y-m-d H:i') }}</td>
                    <td class="d-flex gap-2">
                        <form action="{{ route('admin.requests.approve', $req->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Approve</button>
                        </form>
                        <form action="{{ route('admin.requests.reject', $req->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection
