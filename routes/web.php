<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Auth;
use App\Models\File;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\FileController;




// Route::get('/', function () {
//     return view('welcome');
// });

Route::post('/files/send', [App\Http\Controllers\FileController::class, 'send'])->name('files.send');

Route::middleware(['auth', 'verified'])->group(function () {
   Route::get('/dashboard', function () {
    $search = request('search');

    $files = File::when($search, function ($query, $search) {
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
                ->orWhere('document_number', 'like', "%{$search}%")
                ->orWhere('type', 'like', "%{$search}%")
                ->orWhere('uuid', 'like', "%{$search}%");
        });
    })->orderBy('created_at', 'desc')
      ->paginate(7)
      ->withQueryString(); // ✅ keeps search in the pagination links

    $users = User::where('id', '!=', Auth::id())->get();

    return view('dashboard', compact('files', 'users'));
})->name('dashboard');


    // Route::get('/search-files', function () {
    //     $search = request('search');

    //     $files = File::when($search, function ($query, $search) {
    //         $query->where(function ($q) use ($search) {
    //             $q->where('title', 'like', "%{$search}%")
    //                 ->orWhere('document_number', 'like', "%{$search}%")
    //                 ->orWhere('type', 'like', "%{$search}%")
    //                 ->orWhere('uuid', 'like', "%{$search}%");
    //         });
    //     })->get();

    //     return response()->json($files);
    // });

    Route::get('/my-uploads', function () {
        $files = File::where('user_id', Auth::id())->paginate(6);
        return view('profile', compact('files'));
    })->name('my.uploads');

    Route::get('/files/create', function () {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('files.create', compact('users'));
    });

    // Add these for update and delete:
    Route::get('/files/{file}/edit', [FileController::class, 'edit'])->name('files.edit');
    Route::put('/files/{file}', [FileController::class, 'update'])->name('files.update');
    Route::delete('/files/{file}', [FileController::class, 'destroy'])->name('files.destroy');
});





Route::get('/home', function () {
    return view('home');
})->middleware(['auth'])->name('home');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

require __DIR__ . '/auth.php';
