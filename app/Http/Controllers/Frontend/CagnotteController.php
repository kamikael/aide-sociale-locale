<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CagnotteController extends Controller
{
    /**
     * Affiche la liste des cagnottes publiques (mock pour l'instant)
     */
    public function index()
    {
        // Pour l'instant on va utiliser des données fictives
        $cagnottes = [
            [
                'id' => 1,
                'title' => 'Cagnotte Exemple 1',
                'description' => 'Description courte de la cagnotte 1',
                'target_amount' => 500000,
                'collected_amount' => 120000,
            ],
            [
                'id' => 2,
                'title' => 'Cagnotte Exemple 2',
                'description' => 'Description courte de la cagnotte 2',
                'target_amount' => 1000000,
                'collected_amount' => 600000,
            ],
        ];

        return view('cagnotte.index', compact('cagnottes'));
    }

    /**
     * Affiche le détail d'une cagnotte (mock pour l'instant)
     */
    public function show($id)
    {
        // Données fictives pour le détail
        $cagnotte = [
            'id' => $id,
            'title' => 'Cagnotte Exemple '.$id,
            'description' => 'Description détaillée de la cagnotte '.$id,
            'target_amount' => 500000,
            'collected_amount' => 120000,
            'status' => 'active',
        ];

        return view('cagnotte.show', compact('cagnotte'));
    }
}
