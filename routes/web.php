<?php
use App\Http\Controllers\Frontend\CagnotteController;
use App\Http\Controllers\Frontend\DonateurController;
use App\Http\Controllers\Frontend\DonationController;

Route::get('/', [CagnotteController::class, 'index']);
Route::get('/cagnottes', [CagnotteController::class, 'index']);
Route::get('/cagnottes/{id}', [CagnotteController::class, 'show']);

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DonateurController::class, 'dashboard']);
    Route::get('/historique', [DonateurController::class, 'historique']);
    Route::post('/donation', [DonationController::class, 'store']);
});
Route::get('/test', function () {
    return view('test');
});
