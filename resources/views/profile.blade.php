{{-- filepath: resources/views/profile.blade.php --}}
@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container-fluid px-0 py-1 profile-container">
    <div class="bg-dark shadow-sm rounded-lg p-4 text-white">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center">
                <div class="me-3">
                    <i class="bi bi-person-circle" style="font-size: 3rem;"></i>
                </div>
                <div>
                    <h4 class="mb-1">{{ Auth::user()->last_name }}</h4>
                    <div class="text-secondary">{{ Auth::user()->email }}</div>
                    <div class="text-secondary small">Joined: {{ Auth::user()->created_at->format('F d, Y') }}</div>
                </div>
            </div>
            <div>
                <a href="{{ route('files.bin') }}" class="btn btn-outline-danger">
                    <i class="bi bi-trash3"></i> Bin
                </a>
            </div>
        </div>


        <hr class="border-secondary">
        <div class="mb-3">
            <strong>Total Uploads:</strong> {{ $files->total() }}
            
        </div>

        <h5 class="mb-3">My Uploads</h5>
        <!-- Search Bar -->
        <div class="d-flex justify-content-end mb-3">
            <form class="w-auto" id="searchFormProfile" onsubmit="return false;">
                <div class="input-group">
                    <input class="form-control bg-gray text-dark" id="searchProfileUploads" type="text" placeholder="Search UUID">
                    <button class="btn btn-primary" type="button">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>

        <table class="table table-dark " style="width:100%; min-width:1000px;">
            <thead>
                <tr>
                    <th>Document Type</th>
                    <th>Document Number</th>
                    <th>Title</th>
                    <th>Remarks</th>
                    <th>File</th>
                    <th>UUID</th>
                    <th>Updated by</th>
                    <th>Date Updated</th>
                    <th>Date Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="filesData">
                @forelse($files as $file)
                <tr>
                    <td>{{ $file->type }}</td>
                    <td>{{ $file->document_number }}</td>
                    <td>{{ Str::limit($file->title, 10) }}</td>
                    <td>{{ Str::limit($file->remarks, 10)}}</td>
                    <td> {{ Str::limit(collect(explode('_', basename($file->file_path), 3))->last(), 30) }}
                    </td>
                    <td>{{ Str::limit ($file->uuid, ) }}</td>
                    <td>{{ $file->updater->last_name ?? $file->updater->name ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($file->updated_at)->format('Y-m-d') }}</td>
                    <td>{{ $file->created_at->format('Y-m-d') }}</td>
                    <td>
                        <!-- View Modal Trigger -->
                        <a href="#" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewFileModal{{ $file->id }}" title="View">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('files.edit', ['file' => $file->id, 'redirect' => 'profile']) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('files.destroy', $file->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this file?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>

                <!-- Modal for Viewing File Details -->
                <div class="modal fade" id="viewFileModal{{ $file->id }}" tabindex="-1" aria-labelledby="viewFileModalLabel{{ $file->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content bg-dark text-white">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewFileModalLabel{{ $file->id }}">File Details</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Document Type:</strong> {{ $file->type }}</p>
                                <p><strong>Document Number:</strong> {{ $file->document_number }}</p>
                                <p><strong>Title:</strong> {{ $file->title }}</p>
                                <p><strong>Remarks:</strong> {{ $file->remarks }}</p>
                                <p><strong>File Name:</strong> {{ $file->file_path ? collect(explode('_', basename($file->file_path), 2))->last() : 'No file attached' }}</p>
                                <p><strong>UUID:</strong> {{ $file->uuid }}</p>
                                <p><strong>Updated By:</strong> {{ $file->updater?->last_name ?? 'N/A' }}</p>
                                <p><strong>Date Updated:</strong> {{ $file->updated_at->format('Y-m-d') }}</p>

                                <p><strong>Date Created:</strong> {{ $file->created_at->format('Y-m-d') }}</p>
                                @if($file->file_path)
                                <a href="{{ asset('storage/' . $file->file_path) }}" class="btn btn-primary" download>
                                    <i class="bi bi-download"></i> Download Attachment
                                </a>
                                @else
                                <span class="text-muted">No attachment</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No uploads yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div>
            {{ $files->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection