@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="py-4">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-dark overflow-hidden shadow-sm rounded-lg">
            <div class="p-6 text-white">
                <h3 class="mb-4">Your Files</h3>
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th>Document Type</th>
                            <th>Document Number</th>
                            <th>Title</th>
                            <th>Remarks</th>
                            <th>Date Created</th>
                            <th>Author</th>
                            <th>Updated By</th>
                            <th>Date Updated</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($files as $file)
                        <tr>
                            <td>{{ $file->type }}</td>
                            <td>{{ $file->document_number }}</td>
                            <td>{{ $file->title }}</td>
                            <td>{{ $file->remarks }}</td>
                            <td>{{ $file->created_at->format('Y-m-d') }}</td>
                            <td>{{ $file->uploader?->username ?? $file->uploader?->name ?? 'N/A' }}</td> <!-- Author -->
                            <td>{{ $file->updater?->username ?? $file->updater?->name ?? 'N/A' }}</td> <!-- Updated By -->
                            <td>{{ $file->updated_at->format('Y-m-d') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No files yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection