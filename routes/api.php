<?php

use App\Http\Controllers\Api\PutovanjeController;
use Illuminate\Support\Facades\Route;

Route::get('/putovanja/{id}/detalji', [PutovanjeController::class, 'detalji']);
