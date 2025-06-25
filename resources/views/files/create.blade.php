
@extends('layouts.app')

@section('title', 'Upload File')

@section('content')
<div class="container mt-5">
    <div class="card bg-dark text-white">
        <div class="card-body">
            <h4 class="mb-4">Upload a File</h4>
            <form method="POST" action="{{ route('files.send') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="type" class="form-label">Document Type</label>
                    <input type="text" class="form-control" id="type" name="type" required>
                </div>
                <div class="mb-3">
                    <label for="document_number" class="form-label">Document Number</label>
                    <input type="text" class="form-control" id="document_number" name="document_number" required>
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="remarks" class="form-label">Remarks</label>
                    <textarea class="form-control" id="remarks" name="remarks" rows="2"></textarea>
                </div>
                <div class="mb-3">
                    <label for="file" class="form-label">Attach File</label>
                    <input class="form-control" type="file" id="file" name="file">
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>
</div>
@endsection