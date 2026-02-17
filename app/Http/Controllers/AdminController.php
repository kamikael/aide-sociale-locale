<?php

namespace App\Http\Controllers;

use App\Events\OrganisateurValidated;
use App\Models\Don;
use App\Models\OrganisationDocument;
use App\Models\Paiement;
use App\Models\Utilisateur;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Stats (total dons, commissions, top 5 cagnottes, dons par mois).
     */
    public function stats(StatistiqueService $stats): JsonResponse
    {
        return response()->json($stats->resume());
    }

    /**
     * Tableau de bord admin : vue d’ensemble.
     */
    public function dashboard(): JsonResponse
    {
        $organisateursEnAttente = Utilisateur::enAttenteValidation()->count();
        $totalDons = Don::where('statut', Don::STATUT_COMPLETE)->sum('montant');
        $donsCeMois = Don::where('statut', Don::STATUT_COMPLETE)
            ->whereMonth('paye_at', now()->month)
            ->whereYear('paye_at', now()->year)
            ->sum('montant');
        $nombreDons = Don::where('statut', Don::STATUT_COMPLETE)->count();

        return response()->json([
            'organisateurs_en_attente' => $organisateursEnAttente,
            'total_dons' => (float) $totalDons,
            'dons_ce_mois' => (float) $donsCeMois,
            'nombre_dons' => $nombreDons,
        ]);
    }

    /**
     * Valider un organisateur (passer statut à "valide").
     */
    public function validateOrganisateur(Request $request, int $id): JsonResponse
    {
        $utilisateur = Utilisateur::findOrFail($id);
        $utilisateur->update(['statut_validation' => Utilisateur::STATUT_VALIDE]);

        OrganisateurValidated::dispatch($utilisateur->fresh());

        return response()->json([
            'message' => 'Organisateur validé.',
            'utilisateur' => $utilisateur->fresh(),
        ]);
    }

    /**
     * Rejeter un organisateur (passer statut à "rejete").
     */
    public function rejectOrganisateur(Request $request, int $id): JsonResponse
    {
        $utilisateur = Utilisateur::findOrFail($id);
        $utilisateur->update(['statut_validation' => Utilisateur::STATUT_REJETE]);

        return response()->json([
            'message' => 'Organisateur rejeté.',
            'utilisateur' => $utilisateur->fresh(),
        ]);
    }

    /**
     * Liste des paiements (avec filtres optionnels).
     */
    public function paiements(Request $request): JsonResponse
    {
        $query = Paiement::with('don.utilisateur')
            ->orderByDesc('created_at');

        if ($request->filled('statut')) {
            $query->where('statut', $request->input('statut'));
        }
        if ($request->filled('provider')) {
            $query->where('provider', $request->input('provider'));
        }

        $perPage = (int) $request->input('per_page', 15);
        $paiements = $query->paginate($perPage);

        return response()->json($paiements);
    }

    /**
     * Statistiques globales (dons, paiements, organisateurs).
     */
    public function statistiques(Request $request): JsonResponse
    {
        $stats = [
            'organisateurs' => [
                'en_attente' => Utilisateur::where('statut_validation', Utilisateur::STATUT_EN_ATTENTE)->count(),
                'valides' => Utilisateur::where('statut_validation', Utilisateur::STATUT_VALIDE)->count(),
                'rejetes' => Utilisateur::where('statut_validation', Utilisateur::STATUT_REJETE)->count(),
            ],
            'dons' => [
                'total_montant' => (float) Don::where('statut', Don::STATUT_COMPLETE)->sum('montant'),
                'total_nombre' => Don::where('statut', Don::STATUT_COMPLETE)->count(),
                'en_attente' => Don::where('statut', Don::STATUT_EN_ATTENTE)->count(),
                'echoues' => Don::where('statut', Don::STATUT_ECHOUE)->count(),
            ],
            'paiements' => [
                'reussis' => Paiement::where('statut', Paiement::STATUT_REUSSI)->count(),
                'echoues' => Paiement::where('statut', Paiement::STATUT_ECHOUE)->count(),
                'montant_total' => (float) Paiement::where('statut', Paiement::STATUT_REUSSI)->sum('montant'),
            ],
        ];

        return response()->json($stats);
    }

    /**
     * Valider un document d’organisation (admin).
     */
    public function validateOrganisationDocument(Request $request, int $id): JsonResponse
    {
        $doc = OrganisationDocument::findOrFail($id);
        $doc->update([
            'statut' => OrganisationDocument::STATUT_VALIDE,
            'valide_at' => now(),
            'commentaire_admin' => $request->input('commentaire'),
        ]);

        return response()->json([
            'message' => 'Document validé.',
            'document' => $doc->fresh(),
        ]);
    }

    /**
     * Rejeter un document d’organisation (admin).
     */
    public function rejectOrganisationDocument(Request $request, int $id): JsonResponse
    {
        $doc = OrganisationDocument::findOrFail($id);
        $doc->update([
            'statut' => OrganisationDocument::STATUT_REJETE,
            'commentaire_admin' => $request->input('commentaire'),
        ]);

        return response()->json([
            'message' => 'Document rejeté.',
            'document' => $doc->fresh(),
        ]);
    }
}
