<?php

use App\Http\Controllers\AdminViewController;
use App\Livewire\Absences;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('absences', Absences::class)
    ->middleware(['auth', 'verified'])
    ->name('absences');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
