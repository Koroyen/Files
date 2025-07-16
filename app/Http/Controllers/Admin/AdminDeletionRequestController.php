<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\DeleteRequest;
use App\Models\File;
use App\Models\User;

class AdminDeletionRequestController extends Controller
{
    public function index()
    {
        $requests = DeleteRequest::with('file', 'user')->where('status', 'pending')->latest()->get();
        return view('admin.requests', compact('requests'));
    }

    public function approve($id)
    {
        $request = DeleteRequest::findOrFail($id);
        $request->status = 'approved';
        $request->save();

        // Soft-delete the file
        $file = $request->file;
        $file->is_deleted = true;
        $file->save();

        // Send email to user (optional)
        Mail::raw("Your deletion request for file '{$file->title}' has been approved.", function ($message) use ($request) {
            $message->to($request->user->email)
                    ->subject('Deletion Request Approved');
        });

        return back()->with('success', 'Deletion request approved and file soft-deleted.');
    }

    public function reject($id)
    {
        $request = DeleteRequest::findOrFail($id);
        $request->status = 'rejected';
        $request->save();

        // Send email to user (optional)
        Mail::raw("Your deletion request for file '{$request->file->title}' has been rejected.", function ($message) use ($request) {
            $message->to($request->user->email)
                    ->subject('Deletion Request Rejected');
        });

        return back()->with('info', 'Deletion request rejected.');
    }
}
