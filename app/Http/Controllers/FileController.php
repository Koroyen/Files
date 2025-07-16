<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\File;
use Illuminate\Support\Str;
use App\Models\DeleteRequest;


class FileController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'document_number' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'remarks' => 'nullable|string',
            'file' => 'nullable|file|max:5120',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $originalName = $request->file('file')->getClientOriginalName();
            $filename = time() . '_' . $originalName;
            $filePath = $request->file('file')->storeAs('uploads', $filename, 'public');
        }

        File::create([
            'user_id' => Auth::id(),
            'type' => $request->type,
            'document_number' => $request->document_number,
            'title' => $request->title,
            'remarks' => $request->remarks,
            'file_path' => $filePath,
            'is_deleted' => false,
            'uuid' => Str::uuid(),
        ]);

        return redirect()->route('dashboard')->with('success', 'File uploaded successfully!');
    }

    public function edit(File $file, Request $request)
    {
        $redirect = $request->query('redirect');
        return view('files.edit', compact('file', 'redirect'));
    }

    public function update(Request $request, File $file)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'remarks' => 'nullable|string',
            'file' => 'nullable|file|max:5120',
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

        $redirect = $request->input('redirect');
        if ($redirect === 'profile') {
            return redirect()->route('profile.index')->with('success', 'File updated successfully!');
        }

        return redirect()->route('dashboard')->with('success', 'File updated successfully!');
    }

    public function bin()
    {
        $files = File::where('user_id', Auth::id())
            ->where('is_deleted', true)
            ->latest()
            ->get();

        return view('files.bin', compact('files'));
    }

    public function restore($id)
    {
        $file = File::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('is_deleted', true)
            ->firstOrFail();

        $file->update(['is_deleted' => false]);

        return redirect()->route('files.bin')->with('success', 'File restored successfully.');
    }

    public function forceDelete($id)
    {
        $file = File::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('is_deleted', true)
            ->firstOrFail();

        $file->delete();

        return redirect()->route('files.bin')->with('success', 'File permanently deleted.');
    }

    public function forceDeleteAll()
    {
        $userId = Auth::id();

        $files = File::where('user_id', $userId)
            ->where('is_deleted', true)
            ->get();

        if ($files->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No deleted files to remove.'
            ]);
        }

        foreach ($files as $file) {
            $file->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'All deleted files permanently removed.'
        ]);
    }



    public function requestDeletion(Request $request, File $file)
    {
        $user = Auth::user();

        // Check if a pending request already exists
        if (DeleteRequest::where('file_id', $file->id)->where('status', 'pending')->exists()) {
            return back()->with('warning', 'A deletion request for this file is already pending.');
        }

        DeleteRequest::create([
            'file_id' => $file->id,
            'user_id' => $user->id,
            'status' => 'pending',
        ]);

        // OPTIONAL: send email to admin here

        return back()->with('success', 'Deletion request sent to the admin.');
    }
}
