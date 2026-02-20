<?php 


use App\Http\Controllers\PaiementController;

Route::post('/fedapay/callback', [PaiementController::class, 'callback'])
    ->name('fedapay.callback');
