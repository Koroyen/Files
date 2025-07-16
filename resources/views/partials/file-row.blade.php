<tr>
    <td>{{ Str::limit($file->type, 18) }}</td>
    <td>{{ $file->document_number }}</td>
    <td>{{ Str::limit($file->title, 10) }}</td>
    <td>{{ Str::limit($file->remarks, 10) }}</td>
    <td>{{ Str::limit(collect(explode('_', basename($file->file_path), 3))->last(), 17) }}</td>
    <td>{{ $file->uuid }}</td>
    <td>{{ \Carbon\Carbon::parse($file->created_at)->format('Y-m-d') }}</td>
    <td>{{ $file->uploader->last_name ?? $file->uploader->name ?? 'N/A' }}</td>
    <td>{{ $file->updater->last_name ?? $file->updater->name ?? 'N/A' }}</td>
    <td>{{ \Carbon\Carbon::parse($file->updated_at)->format('Y-m-d') }}</td>
    <td>
    <!-- View Button -->
    <a href="#" data-bs-toggle="modal" data-bs-target="#viewFileModal{{ $file->id }}">
        <i class="bi bi-eye text-primary m-2"></i>
    </a>

    <!-- Edit Button -->
    <a href="{{ route('files.edit', ['file' => $file->id, 'redirect' => 'dashboard']) }}" class="bi  text-warning me-2" title="Edit">
        <i class="bi bi-pencil"></i>
    </a>

</td>

</tr>