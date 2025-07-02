{{-- filepath: resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="py-1">
    <div class="container-fluid px-0">
        <div class="bg-dark overflow-hidden shadow-sm rounded-lg">
            <div class="p-6 text-white">
                <h3 class="mb-">Files Storage</h3>
                <!-- Search Bar Start -->
                <div class="d-flex justify-content-end mb-4">
                    <form class="w-auto" id="searchForm" onsubmit="return false;">
                        <div class="input-group">
                            <input class="form-control bg-gray" id="tableSearch" type="text" placeholder="Search UUID...">
                            <button class="btn btn-primary" type="button" onclick="performSearch()">
                                <i class="bi bi-search fs-6"></i>
                            </button>
                        </div>
                    </form>

                </div>
                <table class="table-responsive table-dark my-table-size" style=" overflow-x:auto; width:100%; min-width:1300px;">
                    <thead>
                        <tr>
                            <th class="pb-4">Document Type</th>
                            <th class="pb-3 pe-5">Document<br>Number</th>
                            <th class="pb-4 pe-5">Title</th>
                            <th class="pb-4 pe-5">Remarks</th>
                            <th class="pb-4 pe-5">File</th>
                            <th class="pb-4 pe-5">UUID</th>
                            <th class="pb-4 ">Date Created</th>
                            <th class="pb-4">Author</th>
                            <th class="pb-4">Updated By</th>
                            <th class="pb-4">Date Updated</th>
                            <th class="ps-4 pb-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($files as $file)
                        <tr class="align-middle py-3">
                            <td class="">{{ Str::limit ( $file->type, 18) }}</td>
                            <td class="py-3">{{ $file->document_number }}</td>
                            <td>{{ Str::limit ($file->title, 10) }}</td>
                            <td>{{Str::limit ($file->remarks, 10) }}</td>
                            <td> {{ Str::limit(collect(explode('_', basename($file->file_path), 3))->last(), 17) }}
                            </td>
                            <td>{{ Str::limit ($file->uuid, 10) }}</td>
                            <td>{{ $file->created_at->format('Y-m-d') }}</td>
                            <td class="px-1">{{ $file->uploader?->last_name ?? $file->uploader?->name ??'N/A' }}</td>
                            <td class="px-3">{{ $file->updater?->last_name ?? $file->updater?->name ?? 'N/A' }}</td>
                            <td class="px-2">{{ $file->updated_at->format('Y-m-d') }}</td>
                            <td>
                                <!-- View Icon -->
                                <a href="#" data-bs-toggle="modal" data-bs-target="#viewFileModal{{ $file->id }}" title="View">
                                    <i class="bi bi-eye text-primary m-2"></i>
                                </a>
                                <!-- Update Icon -->
                                <a href="{{ route('files.edit', $file->id) }}" title="Update" class="ms-2">
                                    <i class="bi bi-pencil-square text-warning me-2"></i>
                                </a>
                                <!-- Delete Icon -->
                                <form action="{{ route('files.destroy', $file->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: none; border: none; padding: 0;" title="Delete">
                                        <i class="bi bi-trash text-danger ms-2"></i>
                                    </button>
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
                                        <p><strong>File Path:</strong> {{ $file->file_path ? collect(explode('_', basename($file->file_path), 2))->last() : 'No file attached' }}
                                        </p>
                                        <p><strong>UUID:</strong> {{ $file->uuid }}</p>
                                        <p><strong>Date Created:</strong> {{ $file->created_at->format('Y-m-d') }}</p>
                                        <p><strong>Author:</strong> {{ $file->uploader?->last_name ?? 'N/A' }}
                                        </p>
                                        <p><strong>Updated By:</strong> {{ $file->updater?->last_name ?? $file->updater?->last_name ?? 'N/A' }}</p>
                                        <p><strong>Date Updated:</strong> {{ $file->updated_at->format('Y-m-d') }}</p>
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
                            <td colspan="9" class="text-center">No files yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="bg-dark">
                    {{ $files->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection