<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\File;

class FileController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'document_number' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'remarks' => 'nullable|string',
            'file' => 'nullable|file|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('uploads', 'public');
        }

        File::create([
            'sender_id' => Auth::id(),
            'type' => $request->type,
            'document_number' => $request->document_number,
            'title' => $request->title,
            'remarks' => $request->remarks,
            'file_path' => $filePath,
            'is_deleted' => false,
        ]);

        return redirect()->route('dashboard')->with('success', 'File uploaded successfully!');
    }
}
