<?php

use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Farmer\Dashboard as FarmerDashboard;
use App\Livewire\Buyer\Dashboard as BuyerDashboard;
use Illuminate\Support\Facades\Route;

// Public homepage
Route::view('/', 'welcome');

// Protected Routes (User must be logged in)
Route::middleware(['auth', 'verified'])->group(function () {

    // 1. Admin Dashboard
    Route::get('/admin/dashboard', AdminDashboard::class)
        ->middleware('role:admin')
        ->name('admin.dashboard');

    // 2. Farmer Dashboard
    Route::get('/farmer/dashboard', FarmerDashboard::class)
        ->middleware('role:farmer')
        ->name('farmer.dashboard');

    // 3. Buyer Dashboard
    Route::get('/buyer/dashboard', BuyerDashboard::class)
        ->middleware('role:buyer')
        ->name('buyer.dashboard');

    // 4. Shared Profile Route (Add this line!)
    Route::view('/profile', 'profile')
        ->name('profile');

        // 4. Shared Profile Route
    Route::view('/profile', 'profile')->name('profile');

    // 5. Shared Messaging System Route (Add this line!)
    Route::get('/messages/{listing?}', \App\Livewire\Messages::class)->name('messages');
});

// Include default Breeze auth routes
require __DIR__.'/auth.php';