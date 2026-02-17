<?php

namespace App\Http\Controllers;

use App\Models\Cagnotte;
use Illuminate\Http\JsonResponse;

class CagnotteController extends Controller
{
    /**
     * Liste des cagnottes (actives par défaut).
     */
    public function index(): JsonResponse
    {
        $cagnottes = Cagnotte::where('active', true)
            ->orderByDesc('montant_collecte')
            ->get();

        return response()->json(['data' => $cagnottes]);
    }

    /**
     * Détail d’une cagnotte par slug.
     */
    public function show(string $slug): JsonResponse
    {
        $cagnotte = Cagnotte::where('slug', $slug)->where('active', true)->firstOrFail();

        return response()->json($cagnotte);
    }
}
