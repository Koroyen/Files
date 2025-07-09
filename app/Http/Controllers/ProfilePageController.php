<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\File;

use Illuminate\Http\Request;

class ProfilePageController extends Controller
{
    public function index()
{
    $user = Auth::user();
    $files = File::where('user_id', $user->id)->latest()->paginate(10); // ✅ FIXED

    return view('profile', compact('user', 'files'));
}
}
