{{-- filepath: resources/views/files/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit File')

@section('content')
<div class="container mt-5 edit-container">
    <div class="card bg-dark text-white">
        <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <h4 class="mb-4" style="font-size: 16px;">Edit File</h4>
            <form method="POST" action="{{ route('files.update', $file->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Hidden redirect input -->
                <input type="hidden" name="redirect" value="{{ $redirect ?? '' }}">

                <div class="mb-3">
                    <label for="type" class="form-label">Document Type</label>
                    <input type="text" class="form-control" id="type" name="type" value="{{ old('type', $file->type) }}" required>
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $file->title) }}" required>
                </div>
                <div class="mb-3">
                    <label for="remarks" class="form-label">Remarks</label>
                    <textarea class="form-control" id="remarks" name="remarks" rows="2">{{ old('remarks', $file->remarks) }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="file" class="form-label">Replace File</label>
                    <input class="form-control" type="file" id="file" name="file">
                </div>
                <button type="submit" class="btn btn-primary">Update</button>

                {{-- Cancel button redirects based on request --}}
                <a href="{{ ($redirect ?? '') === 'profile' ? route('profile.index') : route('dashboard') }}" class="btn btn-dark ms-4 position-absolute bottom-0 end-0 mb-3 me-3">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection