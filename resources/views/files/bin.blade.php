@extends('layouts.app')

@section('title', 'Deleted Files Bin')

@section('content')
<div class="container mt-4">
    <div class="bg-dark text-white p-4 rounded shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0"><i class="bi bi-trash3 me-2"></i>Deleted Files Bin</h4>
            @if ($files->count())
            <form action="{{ route('files.forceDeleteAll') }}" method="POST" onsubmit="return confirm('Are you sure?');">
                @csrf
                @method('DELETE') {{-- THIS tells Laravel to treat the POST as a DELETE --}}
                <button class="btn btn-outline-danger">
                    <i class="bi bi-x-circle"></i> Request Delete
                </button>
            </form>
            @endif

        </div>

        @if ($files->isEmpty())
        <div class="alert alert-info text-center">
            No deleted files found.
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-dark table-striped table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Document #</th>
                        <th>Title</th>
                        <th>Remarks</th>
                        <th>Filename</th>
                        <th>UUID</th>
                        <th>Deleted At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($files as $file)
                    <tr>
                        <td>{{ Str::limit($file->type, 18) }}</td>
                        <td>{{ $file->document_number }}</td>
                        <td>{{ Str::limit($file->title, 10) }}</td>
                        <td>{{ Str::limit($file->remarks, 10) }}</td>
                        <td>{{ Str::limit(collect(explode('_', basename($file->file_path), 3))->last(), 17) }}</td>
                        <td>{{ $file->uuid }}</td>
                        <td>{{ \Carbon\Carbon::parse($file->updated_at)->format('Y-m-d') }}</td>
                        <td>
                            <form action="{{ route('files.restore', $file->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-success" title="Restore">
                                    <i class="bi bi-arrow-clockwise"></i>
                                </button>
                            </form>
                            <button id="deleteAllBtn" class="btn btn-outline-danger">
                                <i class="bi bi-x-circle"></i> Delete All
                            </button>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div id="deleteAllMsg" class="alert d-none mt-3"></div>
        @endif

        <a href="{{ route('dashboard') }}" class="btn btn-outline-light mt-3">
            <i class="bi bi-arrow-left"></i> Back to Dashboard
        </a>
    </div>
</div>

<script>
    function deleteAll() {
        if (confirm('Are you sure you want to delete all?')) {
            document.getElementById('deleteAllForm').submit();
        }
    }
</script>
@endsection