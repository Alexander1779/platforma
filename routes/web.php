<?php

use App\Models\Task;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::get('/task', [App\Http\Controllers\Tasks::class, 'index'])->name('tasks');
    Route::post('/task/create', [App\Http\Controllers\Tasks::class, 'store'])->name('create-task');
    Route::delete('/task/{task}/delete', [App\Http\Controllers\Tasks::class, 'delete'])->name('delete-task');
    Route::post('/task/update', [App\Http\Controllers\Tasks::class, 'update'])->name('update-task');
    Route::post('/task/take/{task}', [App\Http\Controllers\Tasks::class, 'take'])->name('take-task');
    Route::post('/task/cancel/{task}', [App\Http\Controllers\Tasks::class, 'cancel'])->name('cancel-task');
    Route::post('/task/compleate/{task}', [App\Http\Controllers\Tasks::class, 'compleate'])->name('compleate-task');
});
