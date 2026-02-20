<?php

namespace App\Http\Controllers;

use App\Models\Cagnotte;
use Illuminate\Support\Facades\Auth;

class OrganisateurController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Dashboard Organisateur
    |--------------------------------------------------------------------------
    */
    public function dashboard()
    {
        $user = Auth::user();

        $cagnottes = Cagnotte::where('organisateur_id', $user->id);

        $nombreCagnottes = $cagnottes->count();

        $montantTotalCollecte = $cagnottes->sum('collected_amount');

        return view('organisateur.dashboard', compact(
            'nombreCagnottes',
            'montantTotalCollecte'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Liste des cagnottes de l'organisateur
    |--------------------------------------------------------------------------
    */
    public function mesCagnottes()
    {
        $cagnottes = Cagnotte::where('organisateur_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('organisateur.mes_cagnottes', compact('cagnottes'));
    }

    /*
    |--------------------------------------------------------------------------
    | Supprimer une cagnotte
    |--------------------------------------------------------------------------
    */
    public function destroyCagnotte(Cagnotte $cagnotte)
    {
        $this->authorize('delete', $cagnotte);

        $cagnotte->delete();

        return back()->with('success', 'Cagnotte supprimée avec succès.');
    }
}
