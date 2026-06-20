<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;

// Route::view('/', 'welcome')->name('home');
Route::get('/', fn () => redirect()->route('login'))->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::resource('companies', CompanyController::class);
    Route::resource('employees', EmployeeController::class);
});

require __DIR__.'/settings.php';
