<?php

use App\Http\Controllers\HotelController;
use App\Http\Controllers\KorisnikController;
use App\Http\Controllers\PutovanjeController;
use App\Http\Controllers\RezervacijeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes();

// Javne rute (dostupne bez logovanja)
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('pocetna');
Route::post('/kontakt', [App\Http\Controllers\KontaktController::class, 'posalji'])->name('kontakt.posalji');
Route::get('/putovanja/{id}', [PutovanjeController::class, 'show'])->name('putovanja.show');
// Route::post('/rezervacije', [RezervacijeController::class, 'store'])->name('rezervacije.store');

Route::middleware(['auth'])->get('/moj-nalog', [KorisnikController::class, 'mojNalog'])->name('moj-nalog');

// Admin rute (zahtevaju autentifikaciju)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Putovanja
    Route::post('/putovanja/tabela', [PutovanjeController::class, 'tabela'])->name('putovanja.datatable');
    Route::resource('putovanja', PutovanjeController::class)->except(['show'])->parameters(['putovanja' => 'id']);

    // Rezervacije
    Route::post('/rezervacije/tabela', [RezervacijeController::class, 'tabela'])->name('rezervacije.datatable');
    Route::resource('rezervacije', RezervacijeController::class)->parameters(['rezervacije' => 'id']);

    // Hoteli
    Route::get('/hoteli/po-drzavi/{id}', [HotelController::class, 'poDrzavi'])->name('hoteli.poDrzavi');
    Route::get('/hoteli/tabela', [HotelController::class, 'tabela'])->name('hoteli.datatable');
    Route::resource('hoteli', HotelController::class)->parameters(['hoteli' => 'id']);

    // Korisnici
    Route::get('/korisnici/tabela', [KorisnikController::class, 'tabela'])->name('korisnici.datatable');
    Route::resource('korisnici', KorisnikController::class)->parameters(['korisnici' => 'id']);
});
