<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalonController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Rutas de Salones
    Route::resource('salones', SalonController::class)->parameters([
        'salones' => 'salon'
    ]);
});

Route::get('/health', function () {
    try {
        DB::connection()->getPdo();
        return response()->json(['status' => 'OK', 'db' => 'Connected']);
    } catch (\Exception $e) {
        return response()->json(['status' => 'ERROR', 'message' => 'Could not connect to the database.']);
    }
});

require __DIR__.'/auth.php';
