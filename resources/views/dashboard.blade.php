{{-- filepath: resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="py-1">
    <div class="container-fluid px-0">
        <div class="bg-dark overflow-hidden shadow-sm rounded-lg">
            <div class="p-6 text-white">

                <!-- Search Bar -->
                <div class="d-flex justify-content-end mb-4">
                     <h3 class="mb-2 position-absolute start-0 ms-3 mt-1" style="font-size: 22px;">Files Storage</h3>
                    <form class="w-auto" id="searchForm" onsubmit="return false;">
                        <div class="input-group">
                            <input class="form-control bg-gray text-dark" id="ajaxSearch" type="text" placeholder="Search UUID or Title...">
                            <button class="btn btn-primary" type="button" onclick="performSearch()">
                                <i class="bi bi-search fs-6"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-dark table-bordered my-table-size" style="min-width:1300px;">
                        <thead>
                            <tr>
                                <th class="pb-4">Document Type</th>
                                <th class="pb-3 pe-5">Document<br>Number</th>
                                <th class="pb-4 pe-5">Title</th>
                                <th class="pb-4 pe-5">Remarks</th>
                                <th class="pb-4 pe-5">File</th>
                                <th class="pb-4 pe-5">UUID</th>
                                <th class="pb-4">Date Created</th>
                                <th class="pb-4">Author</th>
                                <th class="pb-4">Updated By</th>
                                <th class="pb-4">Date Updated</th>
                                <th class="ps-4 pb-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="filesData">
                            @forelse($files as $file)
                                @include('partials.file-row', ['file' => $file])

                                <!-- View Modal -->
                                <div class="modal fade my-modal" id="viewFileModal{{ $file->id }}" tabindex="-1" aria-labelledby="viewFileModalLabel{{ $file->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content bg-dark text-white">
                                            <div class="modal-header">
                                                <h5 class="modal-title">File Details</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Document Type:</strong> {{ $file->type }}</p>
                                                <p><strong>Document Number:</strong> {{ $file->document_number }}</p>
                                                <p><strong>Title:</strong> {{ $file->title }}</p>
                                                <p><strong>Remarks:</strong> {{ $file->remarks }}</p>
                                                <p><strong>File Path:</strong> {{ $file->file_path ? collect(explode('_', basename($file->file_path), 2))->last() : 'No file attached' }}</p>
                                                <p><strong>UUID:</strong> {{ $file->uuid }}</p>
                                                <p><strong>Date Created:</strong> {{ $file->created_at->format('Y-m-d') }}</p>
                                                <p><strong>Author:</strong> {{ $file->uploader?->last_name ?? 'N/A' }}</p>
                                                <p><strong>Updated By:</strong> {{ $file->updater?->last_name ?? 'N/A' }}</p>
                                                <p><strong>Date Updated:</strong> {{ $file->updated_at->format('Y-m-d') }}</p>

                                                @if($file->file_path)
                                                    <a href="{{ asset('storage/' . $file->file_path) }}" class="btn btn-primary text-light" download>
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
                                <td colspan="11" class="text-center">No files yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination outside table -->
                <div id="paginationWrapper" class="bg-dark mt-3">
                    {{ $files->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
