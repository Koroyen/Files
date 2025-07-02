<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\File;
use Illuminate\Support\Str;

class FileController extends Controller
{
    public function send(Request $request)
    {
         
        $request->validate([
            'document_number' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'remarks' => 'nullable|string',
            'file' => 'nullable|file|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $originalName = $request->file('file')->getClientOriginalName();
            $filename = time() . '_' . $originalName;
            $filePath = $request->file('file')->storeAs('uploads', $filename, 'public');
        }
        
        File::create([
            'user_id' => Auth::id(), // <-- Add this line
            'type' => $request->type,
            'document_number' => $request->document_number,
            'title' => $request->title,
            'remarks' => $request->remarks,
            'file_path' => $filePath,
            'is_deleted' => false,
            'uuid' => Str::uuid(), // Generate a UUID
        ]);
       
        return redirect()->route('dashboard')->with('success', 'File uploaded successfully!');
    }

    public function edit(File $file)
    {
        return view('files.edit', compact('file'));
    }

    public function update(Request $request, File $file)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'remarks' => 'nullable|string',
            'file' => 'nullable|file|max:2048',
        ]);

        $filePath = $file->file_path;
        if ($request->hasFile('file')) {
            $originalName = $request->file('file')->getClientOriginalName();
            $filename = time() . '_' . $originalName;
            $filePath = $request->file('file')->storeAs('uploads', $filename, 'public');
        }

        $file->update([
            'type' => $request->type,
            'title' => $request->title,
            'remarks' => $request->remarks,
            'file_path' => $filePath,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('dashboard')->with('success', 'File updated successfully!');
    }

    public function destroy(File $file)
    {
        $file->delete();
        return redirect()->route('dashboard')->with('success', 'File deleted!');
    }
}
