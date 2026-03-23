<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DonateurController;
use App\Http\Controllers\OrganisateurController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CagnotteController;
use App\Http\Controllers\OrganisationDocumentController;
use App\Http\Controllers\DonController;
use App\Http\Controllers\PaiementController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/cagnottes/{slug}', [CagnotteController::class, 'show'])
    ->name('cagnottes.show');    

Route::get('/paiement/callback', [PaiementController::class, 'redirectFromFedaPay'])
    ->name('paiement.callback');

Route::get('/paiement/success', [PaiementController::class, 'successPage'])
    ->name('paiement.success');

Route::get('/paiement/failed', [PaiementController::class, 'failedPage'])
    ->name('paiement.failed');

Route::get('/paiement/pending', [PaiementController::class, 'pendingPage'])
    ->name('paiement.pending');

/*
|--------------------------------------------------------------------------
| DASHBOARD REDIRECTION
|--------------------------------------------------------------------------
|
| On ne met pas "active" ici pour éviter les boucles de redirection
| entre /app et /verify-email.
|
*/

Route::middleware(['auth', 'verified'])->get('/app', function () {
    $user = Auth::user();

    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->isOrganisateur()) {
        return redirect()->route('organisateur.dashboard');
    }

    return redirect()->route('donateur.feed');
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DONATEUR
    |--------------------------------------------------------------------------
    |
    | Ici on garde "active" car un donateur doit être actif pour accéder
    | à son espace et faire des dons.
    |
    */

    Route::prefix('donateur')
        ->middleware(['role:donateur', 'active'])
        ->name('donateur.')
        ->group(function () {

            Route::get('/cagnottes', [DonateurController::class, 'feed'])
                ->name('feed');

            Route::get('/historique', [DonateurController::class, 'historique'])
                ->name('historique');

            Route::get('/dons/create/{cagnotte}', [DonController::class, 'create'])
                ->name('dons.create');

            Route::post('/dons/create/{cagnotte}', [DonController::class, 'store'])
                ->name('dons.store');
        });

    /*
    |--------------------------------------------------------------------------
    | ORGANISATEUR
    |--------------------------------------------------------------------------
    |
    | On ne met pas "active" ici si tu veux qu'un organisateur pending
    | puisse accéder à son dashboard et envoyer ses documents.
    |
    */

   Route::prefix('organisateur')
    ->middleware('role:organisateur')
    ->name('organisateur.')
    ->group(function () {

        Route::get('/dashboard', [OrganisateurController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('/mes-cagnottes', [OrganisateurController::class, 'mesCagnottes'])
            ->name('cagnottes');

        Route::get('/historique', [OrganisateurController::class, 'historique'])
            ->name('historique');

        Route::post('/documents', [OrganisationDocumentController::class, 'store'])
            ->name('documents.store');

        Route::middleware('organisateur.validated')->group(function () {

            Route::get('/cagnottes/create', [CagnotteController::class, 'create'])
                ->name('cagnottes.create');

            Route::post('/cagnottes', [CagnotteController::class, 'store'])
                ->name('cagnottes.store');

            Route::get('/cagnottes/{cagnotte}/edit', [CagnotteController::class, 'edit'])
                ->name('cagnottes.edit');

            Route::put('/cagnottes/{cagnotte}', [CagnotteController::class, 'update'])
                ->name('cagnottes.update');

            Route::delete('/cagnottes/{cagnotte}', [CagnotteController::class, 'destroy'])
                ->name('cagnottes.destroy');
        });

    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin')
        ->middleware(['role:admin', 'active'])
        ->name('admin.')
        ->group(function () {

            Route::get('/dashboard', [AdminController::class, 'dashboard'])
                ->name('dashboard');

            Route::get('/validation-organisateurs', [AdminController::class, 'validationOrganisateurs'])
                ->name('validation.organisateur');

            Route::post('/organisateurs/{user}/approve', [AdminController::class, 'approve'])
                ->name('organisateur.approve');

            Route::post('/organisateurs/{user}/reject', [AdminController::class, 'reject'])
                ->name('organisateur.reject');

            Route::post('/documents/{document}/approve', [OrganisationDocumentController::class, 'approve'])
                ->name('documents.approve');

            Route::post('/documents/{document}/reject', [OrganisationDocumentController::class, 'reject'])
                ->name('documents.reject');

            Route::get('/documents/{document}', [OrganisationDocumentController::class, 'show'])
                ->name('documents.show');
        });
});

/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
