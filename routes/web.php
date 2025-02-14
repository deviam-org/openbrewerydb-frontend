<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BreweryController;

Route::get('/', fn () => redirect()->route('login'));

Route::get('/dashboard', fn () => view('dashboard'))->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function (): void {

    Route::get('/breweries', [BreweryController::class, 'index'])->name('breweries.index');
    Route::post('/breweries/ajax', [BreweryController::class, 'ajax'])->name('breweries.ajax.index');

    Route::post('/auth/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

});

require __DIR__.'/auth.php';
