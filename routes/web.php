<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Livewire\User;
use App\Livewire\Dashboard;
use App\Http\Middleware\StudentAccessRestriction;
Route::get('/', Dashboard::class)->middleware(['auth', 'verified'])->name('home');
Route::get('/dashboard', Dashboard::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // User Management Route - Using Livewire component directly
    Route::get('/users', User::class)->middleware('auth')->name('users');

    // Event Management Routes - Using Livewire components directly
    Route::get('/events', \App\Livewire\ListEvent::class)->name('events.list');
    Route::get('/events/create', \App\Livewire\CreateEvent::class)->name('events.create');
    Route::get('/events/{id}/edit', \App\Livewire\CreateEvent::class)->name('events.edit');
});

require __DIR__.'/auth.php';
