<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CagnotteController;
use App\Http\Controllers\OrganisationDocumentController;
use App\Http\Controllers\PaiementController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes – NEAL (Admin + Paiement + Public)
|--------------------------------------------------------------------------
*/

// Admin API
Route::prefix('admin')->group(function () {
    Route::get('stats', [AdminController::class, 'stats']);
    Route::get('paiements', [AdminController::class, 'paiements']);
    Route::put('organisateur/{id}/validate', [AdminController::class, 'validateOrganisateur']);
    Route::post('organisateur/{id}/reject', [AdminController::class, 'rejectOrganisateur']);
    Route::get('dashboard', [AdminController::class, 'dashboard']);
    Route::get('statistiques', [AdminController::class, 'statistiques']);
    Route::post('documents/{id}/validate', [AdminController::class, 'validateOrganisationDocument']);
    Route::post('documents/{id}/reject', [AdminController::class, 'rejectOrganisationDocument']);
});

// Paiement API
Route::post('paiement/initiate', [PaiementController::class, 'initiate']);
Route::post('paiement/callback', [PaiementController::class, 'callback']);
Route::patch('paiement/{id}/status', [PaiementController::class, 'updateStatus']);

// Documents organisation (upload)
Route::post('organisation-documents/upload', [OrganisationDocumentController::class, 'upload']);
Route::post('organisation-documents/store', [OrganisationDocumentController::class, 'store']);

// Public API
Route::get('cagnottes', [CagnotteController::class, 'index']);
Route::get('cagnottes/{slug}', [CagnotteController::class, 'show']);
