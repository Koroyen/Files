<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\File;
use App\Models\User;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfilePageController;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::post('/files/send', [FileController::class, 'send'])->name('files.send');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $files = File::latest()->paginate(10);
        $users = User::where('id', '!=', Auth::id())->get();
        return view('dashboard', compact('files', 'users'));
    })->name('dashboard');

    Route::get('/search-files', function (Request $request) {
        $search = $request->input('search');

        $files = File::with(['uploader', 'updater'])
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

    Route::get('/my-uploads', function () {
        $files = File::where('user_id', Auth::id())->paginate(6);
        return view('profile', compact('files'));
    })->name('my.uploads');

    Route::get('/files/create', function () {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('files.create', compact('users'));
    })->name('files.create');

    Route::get('/files/{file}/edit', [FileController::class, 'edit'])->name('files.edit');
    Route::put('/files/{file}', [FileController::class, 'update'])->name('files.update');
    Route::delete('/files/{file}', [FileController::class, 'destroy'])->name('files.destroy');
});

Route::get('/home', function () {
    return view('home');
})->middleware(['auth'])->name('home');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile-page', action: [ProfilePageController::class, 'index'])->name('profile.index');

});


// Logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Auth routes
require __DIR__ . '/auth.php';
