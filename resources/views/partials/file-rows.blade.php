@forelse($files as $file)
    @include('partials.file-row', ['file' => $file])

    <!-- Modal for Viewing File Details
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
        <td colspan="11" class="text-center">No files found.</td>
    </tr>
@endforelse -->
