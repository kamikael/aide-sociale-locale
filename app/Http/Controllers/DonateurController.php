<?php

namespace App\Http\Controllers;

use App\Models\Don;
use Illuminate\Support\Facades\Auth;

class DonateurController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Dashboard Donateur
    |--------------------------------------------------------------------------
    */
    
    public function dashboard()
    {
        $user = Auth::user();

        $donsQuery = Don::where('donateur_id', $user->id)
            ->whereHas('paiement', function ($query) {
                $query->where('status', 'success');
            });

        $totalDons = $donsQuery->sum('montant');
        $nombreDons = $donsQuery->count();
        $dernierDon = $donsQuery->latest()->first();

        return view('donateur.dashboard', compact(
            'totalDons',
            'nombreDons',
            'dernierDon'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Historique des dons
    |--------------------------------------------------------------------------
    */
    public function historique()
    {
        $dons = Don::with(['cagnotte', 'paiement'])
            ->where('donateur_id', Auth::id())
            ->whereHas('paiement', function ($query) {
                $query->where('status', 'success');
            })
            ->latest()
            ->paginate(10);

        return view('donateur.historique', compact('dons'));
    }
}
