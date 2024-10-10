<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', [PropertyController::class, 'showMap']);

Route::get('/dashboard', function () {
    // Call the Laravel built-in 'inspire' command to get a random inspirational quote
    $quote = Artisan::call('inspire');
    $quote = Artisan::output(); // Get the output of the inspire command

    return view('dashboard', compact('quote'));
})->middleware(['auth'])->name('dashboard'); //add verifeid, next to auth to require email verifucaiton


    



Route::middleware(['auth'])->group(function () {
    // List all properties
    Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');

    // Create a new property
    Route::get('/properties/create', [PropertyController::class, 'create'])->name('properties.create');
    Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');

    // Edit an existing property
    Route::get('/properties/{id}/edit', [PropertyController::class, 'edit'])->name('properties.edit');
    Route::put('/properties/{id}', [PropertyController::class, 'update'])->name('properties.update');

    // Delete a property
    Route::delete('/properties/{id}', [PropertyController::class, 'destroy'])->name('properties.destroy');
});


require __DIR__.'/auth.php';
