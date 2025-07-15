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
        <a href="#" data-bs-toggle="modal" data-bs-target="#viewFileModal{{ $file->id }}">
            <i class="bi bi-eye text-primary m-2"></i>
        </a>
            <a href="{{ route('files.edit', ['file' => $file->id, 'redirect' => 'dashboard']) }}" class="bi  text-warning me-2" title="Edit">
                <i class="bi bi-pencil"></i>
            </a>


        <form action="{{ route('files.destroy', $file->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
            @csrf
            @method('DELETE')
            <!-- <button type="submit" style="background: none; border: none; padding: 0;">
                <i class="bi bi-trash text-danger ms-2"></i>
            </button> -->
        </form>
    </td>
</tr>