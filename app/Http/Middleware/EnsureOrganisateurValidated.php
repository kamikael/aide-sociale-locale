<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureOrganisateurValidated
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Sécurité
        if (!$user || !$user->isOrganisateur()) {
            abort(403);
        }

        // 1️⃣ Vérifier que le compte est actif
        if ($user->status !== 'active') {
            return redirect()
                ->route('organisateur.dashboard')
                ->withErrors([
                    'error' => 'Votre compte organisateur n\'est pas encore validé par un administrateur.'
                ]);
        }

        // 2️⃣ Vérifier qu'il a au moins un document approuvé
        $hasApprovedDocument = $user->organisationDocuments()
            ->where('status', 'approved')
            ->exists();

        if (!$hasApprovedDocument) {
            return redirect()
                ->route('organisateur.dashboard')
                ->withErrors([
                    'error' => 'Vous devez avoir au moins un document approuvé pour créer une cagnotte.'
                ]);
        }

        return $next($request);
    }

    
}