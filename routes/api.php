<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaiementController;

Route::post('/paiement/callback', [PaiementController::class, 'callback'])
    ->middleware('fedapay.webhook')
    ->name('paiement.callback');

Route::get('/paiement/success', [PaiementController::class, 'success'])
    ->name('paiement.success');

Route::get('/paiement/callback', [PaiementController::class, 'redirectFromFedaPay'])
    ->name('paiement.callback');

Route::get('/paiement/success', [PaiementController::class, 'successPage'])
    ->name('paiement.success');

Route::get('/paiement/failed', [PaiementController::class, 'failedPage'])
    ->name('paiement.failed');

Route::get('/paiement/pending', [PaiementController::class, 'pendingPage'])
    ->name('paiement.pending');    