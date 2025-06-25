<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Auth;
use App\Models\File;
use App\Models\User;


Route::post('/account/create', [AccountController::class, 'store']);

Route::post('/files/send', [App\Http\Controllers\FileController::class, 'send'])->name('files.send');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $files = File::all(); // or use File::where('recipient_id', Auth::id())->get() for user-specific files
    $users = User::where('id', '!=', Auth::id())->get();    return view('dashboard', compact('files', 'users'));
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/files/create', function () {
    $users = User::where('id', '!=', Auth::id())->get();
    return view('files.create', compact('users'));
})->middleware(['auth']);


Route::get('/home', function () {
    return view('home');
})->middleware(['auth'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

require __DIR__.'/auth.php';
