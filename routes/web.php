<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('landing');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// redirects user to dashboard according to their auth
Route::middleware(['auth'])->group(function () {
    //dashboard controller
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    //Task controller
     Route::resource('tasks', TaskController::class)->only(['create', 'store']);
});

// 
Route::get('/UserProfile', function () {
    return view('UserProfile');
})->name('UserProfile');

// updating status
Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');

// time spent
Route::patch('/tasks/{task}/log-time', [TaskController::class, 'logTime'])->name('tasks.logTime');

//feedback
Route::patch('/tasks/{task}/feedback', [TaskController::class, 'submitFeedback'])->name('tasks.feedback');





require __DIR__.'/auth.php';
