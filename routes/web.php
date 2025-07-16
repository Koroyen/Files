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
use App\Http\Controllers\Admin\AdminDeletionRequestController;

// ==========================
// 🌐 Public Routes
// ==========================

Route::view('/home', 'home')->name('home');
Route::post('/files/send', [FileController::class, 'send'])->name('files.send');

// ==========================
// 🔐 Authenticated User Routes
// ==========================

Route::middleware(['auth', 'verified'])->group(function () {

    // 🧭 Dashboard
    Route::get('/dashboard', function () {
        $files = File::notDeleted()->latest()->paginate(10);
        $users = User::where('id', '!=', Auth::id())->get();
        return view('dashboard', compact('files', 'users'));
    })->name('dashboard');

    // 🔍 AJAX Search Files
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

    // 📁 My Uploads
    Route::get('/my-uploads', function () {
        $files = File::where('user_id', Auth::id())
            ->where('is_deleted', false)
            ->latest()
            ->paginate(6);
        return view('profile', compact('files'));
    })->name('my.uploads');

    // 📄 File Management
    Route::prefix('files')->name('files.')->group(function () {
        Route::get('/create', fn() => view('files.create', [
            'users' => User::where('id', '!=', Auth::id())->get()
        ]))->name('create');

        Route::get('{file}/edit', [FileController::class, 'edit'])->name('edit');
        Route::put('{file}', [FileController::class, 'update'])->name('update');
        Route::delete('{file}', [FileController::class, 'destroy'])->name('destroy');

        // 🗑️ Deleted Files Bin
        Route::get('/bin', [FileController::class, 'bin'])->name('bin');
        Route::post('/restore/{id}', [FileController::class, 'restore'])->name('restore');
        Route::delete('/force-delete/{id}', [FileController::class, 'forceDelete'])->name('forceDelete');
        Route::delete('/force-delete-all', [FileController::class, 'forceDeleteAll'])->name('forceDeleteAll');

        // 🆕 Request Deletion (Placeholder for next step)
        Route::post('{file}/request-deletion', [FileController::class, 'requestDeletion'])->name('requestDeletion');
        Route::post('/files/request-deletion/{file}', [FileController::class, 'requestDeletion'])->name('files.requestDeletion');

    });

    // 👤 Profile
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::get('/page', [ProfilePageController::class, 'index'])->name('profile.index');
    });
});

// ==========================
// 🛡️ Admin-Only Routes
// ==========================

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // ✅ Admin approval/review for deletion requests
    Route::get('/requests', [AdminDeletionRequestController::class, 'index'])->name('requests.index');
    Route::post('/requests/{id}/approve', [AdminDeletionRequestController::class, 'approve'])->name('requests.approve');
    Route::post('/requests/{id}/reject', [AdminDeletionRequestController::class, 'reject'])->name('requests.reject');
});

// ==========================
// 🔓 Logout
// ==========================

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// ==========================
// 🔧 Auth Scaffolding
// ==========================

require __DIR__ . '/auth.php';
