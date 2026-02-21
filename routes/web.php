<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DonateurController;
use App\Http\Controllers\OrganisateurController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CagnotteController;
use App\Http\Controllers\OrganisationDocumentController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD REDIRECTION (Breeze compatibility)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'active'])
    ->get('/dashboard', function () {

        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->isOrganisateur()) {
            return redirect()->route('organisateur.dashboard');
        }

        return redirect()->route('donateur.dashboard');
    })
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'active'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | 🔵 DONATEUR
    |--------------------------------------------------------------------------
    */
    Route::prefix('donateur')
        ->middleware('role:donateur')
        ->name('donateur.')
        ->group(function () {

            Route::get('/dashboard', [DonateurController::class, 'dashboard'])
                ->name('dashboard');

            Route::get('/historique', [DonateurController::class, 'historique'])
                ->name('historique');
        });

    /*
    |--------------------------------------------------------------------------
    | 🟠 ORGANISATEUR
    |--------------------------------------------------------------------------
    */
    Route::prefix('organisateur')
        ->middleware(['role:organisateur'])
        ->name('organisateur.')
        ->group(function () {

            Route::get('/dashboard', [OrganisateurController::class, 'dashboard'])
                ->name('dashboard');

            Route::get('/mes-cagnottes', [OrganisateurController::class, 'mesCagnottes'])
                ->name('cagnottes');

            Route::post('/documents', [OrganisationDocumentController::class, 'store'])
                ->name('documents.store');
        });

    /*
    |--------------------------------------------------------------------------
    | CAGNOTTES (Organisateur validé uniquement)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:organisateur', 'organisateur.validated'])
        ->group(function () {

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

    /*
    |--------------------------------------------------------------------------
    | 🔴 ADMIN
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')
        ->middleware('role:admin')
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

            Route::post('/documents/{document}/approve', 
                [OrganisationDocumentController::class, 'approve'])
                ->name('documents.approve');

            Route::post('/documents/{document}/reject', 
                [OrganisationDocumentController::class, 'reject'])
                ->name('documents.reject');
        });
});

/*
|--------------------------------------------------------------------------
| PROFILE (Breeze)
|--------------------------------------------------------------------------
*/



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

require __DIR__.'/api.php';
