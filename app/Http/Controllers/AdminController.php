<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Don;
use App\Models\Commission;
use App\Models\Cagnotte;
use App\Models\Paiement;
use Carbon\Carbon;


class AdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Dashboard Admin (simple pour l'instant)
    |--------------------------------------------------------------------------
    */
    public function dashboard()
    {
        
        // Total dons validés

    $totalDons = Don::whereHas('paiement', function ($q) {
        $q->where('status', 'success');
    })->sum('montant');

    // Total commissions
    $totalCommissions = Commission::sum('amount');

    // Nombre total cagnottes
    $totalCagnottes = Cagnotte::count();

    // Nombre total utilisateurs
    $totalUtilisateurs = User::count();

    // Revenus du mois courant
    $revenusMois = Commission::whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->sum('amount');
        $organisateursPending = User::whereHas('role', function ($q) {
                $q->where('name', 'organisateur');
            })
            ->where('status', 'pending')
            ->count();

        return view('admin.dashboard', compact(
         'totalDons',
        'totalCommissions',
        'totalCagnottes',
        'totalUtilisateurs',
        'revenusMois',
        'organisateursPending'));
    }

    /*
    |--------------------------------------------------------------------------
    | Liste des organisateurs en attente
    |--------------------------------------------------------------------------
    */
    public function validationOrganisateurs()
    {
        $organisateurs = User::whereHas('role', function ($q) {
                $q->where('name', 'organisateur');
            })
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        return view('admin.validation_organisateurs', compact('organisateurs'));
    }

    /*
    |--------------------------------------------------------------------------
    | Approuver un organisateur
    |--------------------------------------------------------------------------
    */
    public function approve(User $user)
    {
        if (!$user->isOrganisateur()) {
            abort(403);
        }
     


               






    
        $user->update([
            'status' => 'active',
        ]);

        return back()->with('success', 'Organisateur validé avec succès.');
    }

    /*
    |--------------------------------------------------------------------------
    | Rejeter un organisateur
    |--------------------------------------------------------------------------
    */
    public function reject(User $user)
    {
        if (!$user->isOrganisateur()) {
            abort(403);
        }

        $user->update([
            'status' => 'rejected',
        ]);

        return back()->with('success', 'Organisateur rejeté.');
    }
}
