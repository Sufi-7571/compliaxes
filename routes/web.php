<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\DashboardController;




// Home page route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Contact form submission route
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Dashboard routes (requires authentication)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Website management
    Route::resource('websites', WebsiteController::class);
    
    // Scan routes
    Route::post('/websites/{website}/scan', [ScanController::class, 'store'])->name('scans.store');
    Route::get('/scans/{scan}', [ScanController::class, 'show'])->name('scans.show');
    
    // Profile routes (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
