<?php

use App\Http\Controllers\HotelController;
use App\Http\Controllers\PutovanjeController;
use App\Http\Controllers\RezervacijeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes();

// Javne rute (dostupne bez logovanja)
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('pocetna');
Route::get('/putovanja/{id}', [PutovanjeController::class, 'show'])->name('putovanja.show');
Route::post('/rezervacije', [RezervacijeController::class, 'store'])->name('rezervacije.store');

// Admin rute (zahtevaju autentifikaciju)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Putovanja
    Route::get('/putovanja', [PutovanjeController::class, 'index'])->name('putovanja.index');
    Route::get('/putovanja/create', [PutovanjeController::class, 'create'])->name('putovanja.create');
    Route::post('/putovanja', [PutovanjeController::class, 'store'])->name('putovanja.store');
    Route::get('/putovanja/{id}/edit', [PutovanjeController::class, 'edit'])->name('putovanja.edit');
    Route::put('/putovanja/{id}', [PutovanjeController::class, 'update'])->name('putovanja.update');
    Route::delete('/putovanja/{id}', [PutovanjeController::class, 'destroy'])->name('putovanja.destroy');
    Route::post('/putovanja/tabela', [PutovanjeController::class, 'tabela'])->name('putovanja.datatable');

    // Rezervacije
    Route::get('/rezervacije', [RezervacijeController::class, 'index'])->name('rezervacije.index');
    Route::get('/rezervacije/create', [RezervacijeController::class, 'create'])->name('rezervacije.create');
    Route::get('/rezervacije/{id}', [RezervacijeController::class, 'show'])->name('rezervacije.show');
    Route::get('/rezervacije/{id}/edit', [RezervacijeController::class, 'edit'])->name('rezervacije.edit');
    Route::put('/rezervacije/{id}', [RezervacijeController::class, 'update'])->name('rezervacije.update');
    Route::delete('/rezervacije/{id}', [RezervacijeController::class, 'destroy'])->name('rezervacije.destroy');
    Route::post('/rezervacije/tabela', [RezervacijeController::class, 'tabela'])->name('rezervacije.datatable');

    // Hoteli
    Route::get('/hoteli', [HotelController::class, 'index'])->name('hoteli.index');
    Route::get('/hoteli/create', [HotelController::class, 'create'])->name('hoteli.create');
    Route::post('/hoteli', [HotelController::class, 'store'])->name('hoteli.store');
    Route::get('/hoteli/{id}/edit', [HotelController::class, 'edit'])->name('hoteli.edit');
    Route::put('/hoteli/{id}', [HotelController::class, 'update'])->name('hoteli.update');
    Route::delete('/hoteli/{id}', [HotelController::class, 'destroy'])->name('hoteli.destroy');
    Route::get('/hoteli/tabela', [HotelController::class, 'tabela'])->name('hoteli.datatable');
});
