<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\File;
use App\Models\User;

use App\Http\Controllers\FileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilePageController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

//  Public Routes
Route::view('/home', 'home')->name('home');
Route::post('/files/send', [FileController::class, 'send'])->name('files.send');

//  Authenticated User Routes
Route::middleware(['auth', 'verified'])->group(function () {
    //  Dashboard
    Route::get('/dashboard', function () {
        $files = File::notDeleted()->latest()->paginate(10);
        $users = User::where('id', '!=', Auth::id())->get();
        return view('dashboard', compact('files', 'users'));
    })->name('dashboard');

    //  Search Files (AJAX)
    Route::get('/search-files', function (Request $request) {
        $search = $request->input('search');

        $files = File::notDeleted()->with(['uploader', 'updater'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('document_number', 'like', "%{$search}%")
                        ->orWhere('type', 'like', "%{$search}%")
                        ->orWhere('uuid', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        return view('partials.file-rows', compact('files'))->render();
    });

    //  My Uploads
    Route::get('/my-uploads', function () {
        $files = File::where('user_id', Auth::id())
            ->where('is_deleted', false)
            ->latest()
            ->paginate(6);
        return view('profile', compact('files'));
    })->name('my.uploads');

    //  File Management 
    Route::get('/files/create', fn() => view('files.create', [
        'users' => User::where('id', '!=', Auth::id())->get()
    ]))->name('files.create');

    Route::get('/files/{file}/edit', [FileController::class, 'edit'])->name('files.edit');
    Route::put('/files/{file}', [FileController::class, 'update'])->name('files.update');
    Route::delete('/files/{file}', [FileController::class, 'destroy'])->name('files.destroy');

    //  Deleted Files Bin 
    Route::get('/files/bin', [FileController::class, 'bin'])->name('files.bin');
    Route::post('/files/restore/{id}', [FileController::class, 'restore'])->name('files.restore');
    Route::delete('/files/force-delete/{id}', [FileController::class, 'forceDelete'])->name('files.forceDelete');
    Route::delete('/files/force-delete-all', [FileController::class, 'forceDeleteAll'])->name('files.forceDeleteAll');

    // Profile Settings 
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile-page', [ProfilePageController::class, 'index'])->name('profile.index');
});

//  Admin-Only Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
});

//  Logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

//  Auth Scaffolding
require __DIR__ . '/auth.php';
