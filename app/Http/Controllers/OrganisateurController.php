<?php

namespace App\Http\Controllers;

use App\Models\Cagnotte;
use Illuminate\Support\Facades\Auth;

class OrganisateurController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        $isValidated = $user->status === 'active';

        $latestDocument = $user->organisationDocuments()
            ->latest()
            ->first();

        $cagnottes = collect();

        $nombreCagnottes = 0;
        $totalCollected = 0;
        $totalTarget = 0;

        if ($isValidated) {

            $cagnottes = $user->cagnottes()
                ->latest()
                ->get();

            $nombreCagnottes = $cagnottes->count();

            $totalCollected = $cagnottes->sum('collected_amount');

            $totalTarget = $cagnottes->sum('target_amount');
        }

        return view('organisateur.dashboard', compact(
            'user',
            'isValidated',
            'latestDocument',
            'cagnottes',
            'nombreCagnottes',
            'totalCollected',
            'totalTarget'
        ));
    }


    public function mesCagnottes()
    {
        $user = Auth::user();

        $cagnottes = $user->cagnottes()
            ->latest()
            ->paginate(10);

        return view('organisateur.mes_cagnottes', compact('cagnottes'));
    }


    public function destroyCagnotte(Cagnotte $cagnotte)
    {
        $this->authorize('delete', $cagnotte);

        $cagnotte->delete();

        return back()->with('success', 'Cagnotte supprimée avec succès.');
    }


    public function historique()
{
    $user = Auth::user();

    if ($user->status !== 'active') {
        return redirect()
            ->route('organisateur.dashboard')
            ->with('error', 'Votre compte doit être validé.');
    }

    $cagnottes = $user->cagnottes()
        ->latest()
        ->get();

    $totalCollected = $cagnottes->sum('collected_amount');

    $totalTarget = $cagnottes->sum('target_amount');

    return view('organisateur.historique', [
        'cagnottes' => $cagnottes,
        'totalCollected' => $totalCollected,
        'totalTarget' => $totalTarget,
    ]);
}


}