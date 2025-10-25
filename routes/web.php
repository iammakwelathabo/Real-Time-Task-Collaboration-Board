<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/tasks/all', [TaskController::class, 'getTasks'])->name('tasks.all');
    Route::resource('tasks', TaskController::class)->except(['index']);
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
});

require __DIR__.'/auth.php';
