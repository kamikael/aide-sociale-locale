<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaiementController;

Route::post('/paiement/callback', [PaiementController::class, 'callback'])
    ->middleware('fedapay.webhook')
    ->name('fedapay.callback');
