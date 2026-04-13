<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::post('logout', function (App\Livewire\Actions\Logout $logout) {
        $logout();
        return redirect('/');
    })->name('logout');
});

Route::view('/', 'welcome');

Route::get('dashboard', function () {
    if (auth()->user()->role === 'owner') {
        return redirect()->route('owner.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth', 'role:owner'])->prefix('owner')->group(function () {
    Route::view('dashboard', 'owner.dashboard')->name('owner.dashboard');

    // Inventory Module
    Route::prefix('inventory')->group(function () {
        Livewire\Volt\Volt::route('suppliers', 'owner.inventory.suppliers')->name('owner.inventory.suppliers');
        Livewire\Volt\Volt::route('ingredients', 'owner.inventory.ingredients')->name('owner.inventory.ingredients');
        Livewire\Volt\Volt::route('products', 'owner.inventory.products')->name('owner.inventory.products');
    });

    // Management Module
    Livewire\Volt\Volt::route('employees', 'owner.employees')->name('owner.employees');
    Livewire\Volt\Volt::route('attendance', 'owner.attendance')->name('owner.attendance');
});

require __DIR__.'/auth.php';
