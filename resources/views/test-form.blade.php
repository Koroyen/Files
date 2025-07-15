<form action="{{ route('files.forceDeleteAll') }}" method="POST" onsubmit="return confirm('Test delete all?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Test Delete All</button>
</form>
