<?php

namespace App\Http\Controllers;

use App\Models\Don;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Cagnotte;
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


   public function feed(Request $request)
{
    $query = Cagnotte::query()
        ->with('user')
        ->active();

    // 🔍 Recherche
    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    // 🔽 Tri
    switch ($request->get('sort')) {
        case 'popular':
            $query->orderBy('collected_amount', 'desc');
            break;

        case 'goal':
            $query->orderBy('goal_amount', 'desc');
            break;

        default:
            $query->latest();
            break;
    }

    $cagnottes = $query->paginate(9)->withQueryString();

    return view('donateur.feed', compact('cagnottes'));
}
    
}
