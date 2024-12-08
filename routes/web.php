<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('admin/dashboard', 'admin.dashboard')
    ->middleware(['auth', 'verified', 'admin'])
    ->name('admin.dashboard');

Route::view('manager/dashboard', 'manager.dashboard')
    ->middleware(['auth', 'verified', 'manager'])
    ->name('manager.dashboard');

Route::view('hr/dashboard', 'hr.dashboard')
    ->middleware(['auth', 'verified', 'hr'])
    ->name('hr.dashboard');

Route::view('employee/dashboard', 'employee.dashboard')
    ->middleware(['auth', 'verified', 'employee'])
    ->name('employee.dashboard');


Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
