use App\Http\Controllers\AdminController;

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('admin.dashboard');

        Route::get('/statistiques', [AdminController::class, 'statistiques'])
            ->name('admin.statistiques');

        Route::get('/validation-organisateurs', [AdminController::class, 'validationOrganisateurs'])
            ->name('admin.validation.organisateurs');

        Route::post('/organisateur/{id}/approve', [AdminController::class, 'approveOrganisateur'])
            ->name('admin.organisateur.approve');

        Route::post('/organisateur/{id}/reject', [AdminController::class, 'rejectOrganisateur'])
            ->name('admin.organisateur.reject');

        Route::get('/paiements', [AdminController::class, 'paiements'])
            ->name('admin.paiements');

    });

