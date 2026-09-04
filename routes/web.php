<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\KorisnikController;
use App\Http\Controllers\PutovanjeController;
use App\Http\Controllers\RezervacijeController;
use App\Http\Controllers\KontaktController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes();

// Javne rute (dostupne bez logovanja)
Route::get('/', [HomeController::class, 'index'])->name('pocetna');
Route::post('/kontakt', [KontaktController::class, 'posalji'])->name('kontakt.posalji');
Route::get('/putovanja/{id}', [PutovanjeController::class, 'show'])->name('putovanja.show');
Route::post('/rezervacije', [RezervacijeController::class, 'store'])->name('rezervacije.store.javno');
Route::get('/rezervacije/otkazi/{token}', [RezervacijeController::class, 'javnoOtkazivanje'])->name('rezervacije.javno.otkazivanje');
Route::post('/rezervacije/otkazi/{token}', [RezervacijeController::class, 'javnoPotvrdiOtkazivanje'])->name('rezervacije.javno.potvrdiOtkazivanje');

Route::middleware(['auth'])->get('/moj-nalog', [KorisnikController::class, 'mojNalog'])->name('moj-nalog');

// Admin rute (zahtevaju autentifikaciju)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Putovanja
    Route::get('/putovanja/{id}/putnici-pdf', [PutovanjeController::class, 'putnici_pdf'])->name('putovanja.putnici_pdf');
    Route::post('/putovanja/tabela', [PutovanjeController::class, 'tabela'])->name('putovanja.datatable');
    Route::resource('putovanja', PutovanjeController::class)->except(['show'])->parameters(['putovanja' => 'id']);

    // Rezervacije
    Route::post('/rezervacije/tabela', [RezervacijeController::class, 'tabela'])->name('rezervacije.datatable');
    Route::get('/rezervacije/{id}/otkazivanje', [RezervacijeController::class, 'otkazivanje'])->name('rezervacije.otkazivanje');
    Route::post('/rezervacije/{id}/otkazivanje', [RezervacijeController::class, 'potvrdiOtkazivanje'])->name('rezervacije.potvrdiOtkazivanje');
    Route::resource('rezervacije', RezervacijeController::class)->parameters(['rezervacije' => 'id']);

    // Hoteli
    Route::get('/hoteli/po-drzavi/{id}', [HotelController::class, 'poDrzavi'])->name('hoteli.poDrzavi');
    Route::get('/hoteli/tabela', [HotelController::class, 'tabela'])->name('hoteli.datatable');
    Route::resource('hoteli', HotelController::class)->parameters(['hoteli' => 'id']);

    // Korisnici
    Route::get('/korisnici/tabela', [KorisnikController::class, 'tabela'])->name('korisnici.datatable');
    Route::resource('korisnici', KorisnikController::class)->parameters(['korisnici' => 'id']);
});
