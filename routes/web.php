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
Route::middleware(['auth'])->group(function () {
    // Putovanja
    Route::get('/admin/putovanja', [PutovanjeController::class, 'index'])->name('putovanja.index');
    Route::get('/admin/putovanja/create', [PutovanjeController::class, 'create'])->name('putovanja.create');
    Route::post('/admin/putovanja', [PutovanjeController::class, 'store'])->name('putovanja.store');
    Route::get('/admin/putovanja/{id}/edit', [PutovanjeController::class, 'edit'])->name('putovanja.edit');
    Route::put('/admin/putovanja/{id}', [PutovanjeController::class, 'update'])->name('putovanja.update');
    Route::delete('/admin/putovanja/{id}', [PutovanjeController::class, 'destroy'])->name('putovanja.destroy');
    Route::post('/admin/putovanja/tabela', [PutovanjeController::class, 'tabela'])->name('putovanja.datatable');

    // Rezervacije
    Route::get('/admin/rezervacije', [RezervacijeController::class, 'index'])->name('rezervacije.index');
    Route::get('/admin/rezervacije/create', [RezervacijeController::class, 'create'])->name('rezervacije.create');
    Route::get('/admin/rezervacije/{id}', [RezervacijeController::class, 'show'])->name('rezervacije.show');
    Route::get('/admin/rezervacije/{id}/edit', [RezervacijeController::class, 'edit'])->name('rezervacije.edit');
    Route::put('/admin/rezervacije/{id}', [RezervacijeController::class, 'update'])->name('rezervacije.update');
    Route::delete('/admin/rezervacije/{id}', [RezervacijeController::class, 'destroy'])->name('rezervacije.destroy');
    Route::post('/admin/rezervacije/tabela', [RezervacijeController::class, 'tabela'])->name('rezervacije.datatable');

    // Hoteli
    Route::get('/admin/hoteli', [HotelController::class, 'index'])->name('hoteli.index');
    Route::get('/admin/hoteli/create', [HotelController::class, 'create'])->name('hoteli.create');
    Route::post('/admin/hoteli', [HotelController::class, 'store'])->name('hoteli.store');
    Route::get('/admin/hoteli/{id}/edit', [HotelController::class, 'edit'])->name('hoteli.edit');
    Route::put('/admin/hoteli/{id}', [HotelController::class, 'update'])->name('hoteli.update');
    Route::delete('/admin/hoteli/{id}', [HotelController::class, 'destroy'])->name('hoteli.destroy');
    Route::get('/admin/hoteli/tabela', [HotelController::class, 'tabela'])->name('hoteli.datatable');
});
