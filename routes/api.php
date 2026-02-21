<?php 


use App\Http\Controllers\PaiementController;

Route::post('/fedapay/callback', [PaiementController::class, 'callback'])
    ->middleware('fedapay.webhook')
    ->name('fedapay.callback');