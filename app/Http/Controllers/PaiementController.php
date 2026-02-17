<?php

namespace App\Http\Controllers;

use App\Events\DonCreated;
use App\Models\Don;
use App\Models\Paiement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaiementController extends Controller
{
    /**
     * Initier un paiement : crée un Don + un Paiement et retourne l’URL / référence.
     */
    public function initiate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'utilisateur_id' => 'required|exists:utilisateurs,id_utilisateur',
            'montant' => 'required|numeric|min:0.01',
            'provider' => 'nullable|string|in:mtn,moov,celtis,stripe,paypal',
        ]);

        $don = Don::create([
            'utilisateur_id' => $validated['utilisateur_id'],
            'montant' => $validated['montant'],
            'statut' => Don::STATUT_EN_ATTENTE,
            'reference_externe' => 'DON-' . strtoupper(Str::random(10)),
        ]);

        $paiement = Paiement::create([
            'don_id' => $don->id,
            'montant' => $don->montant,
            'statut' => Paiement::STATUT_INITIE,
            'reference_provider' => null,
            'provider' => $validated['provider'] ?? 'mtn',
            'metadata' => $request->only(['email', 'description']) ?: null,
        ]);

        // En production : appeler le provider (Stripe, etc.) et mettre reference_provider + URL de paiement
        $checkoutUrl = url("/paiement/checkout/{$paiement->id}");

        return response()->json([
            'don_id' => $don->id,
            'paiement_id' => $paiement->id,
            'reference' => $don->reference_externe,
            'montant' => $don->montant,
            'checkout_url' => $checkoutUrl,
        ], 201);
    }

    /**
     * Callback du provider (webhook ou redirect) : met à jour le statut et déclenche DonCreated si succès.
     */
    public function callback(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'paiement_id' => 'required|exists:paiements,id',
            'statut' => 'required|string|in:reussi,echoue,rembourse',
            'reference_provider' => 'nullable|string',
        ]);

        $paiement = Paiement::with('don')->findOrFail($validated['paiement_id']);
        $don = $paiement->don;

        $statutPaiement = $validated['statut'];
        $paiement->update([
            'statut' => $statutPaiement,
            'reference_provider' => $validated['reference_provider'] ?? $paiement->reference_provider,
            'paye_at' => $statutPaiement === 'reussi' ? now() : $paiement->paye_at,
        ]);

        $this->updateDonStatus($don, $paiement);

        if ($statutPaiement === 'reussi') {
            DonCreated::dispatch($don->fresh());
        }

        return response()->json([
            'message' => 'Statut mis à jour.',
            'paiement' => $paiement->fresh(),
            'don' => $don->fresh(),
        ]);
    }

    /**
     * Mise à jour manuelle du statut d’un paiement (admin ou cron).
     */
    public function updateStatus(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'statut' => 'required|string|in:initie,en_attente,reussi,echoue,rembourse',
        ]);

        $paiement = Paiement::with('don')->findOrFail($id);
        $paiement->update([
            'statut' => $validated['statut'],
            'paye_at' => $validated['statut'] === Paiement::STATUT_REUSSI ? now() : $paiement->paye_at,
        ]);

        $this->updateDonStatus($paiement->don, $paiement);

        if ($paiement->statut === Paiement::STATUT_REUSSI) {
            DonCreated::dispatch($paiement->don->fresh());
        }

        return response()->json([
            'message' => 'Statut du paiement mis à jour.',
            'paiement' => $paiement->fresh(),
        ]);
    }

    /**
     * Synchronise le statut du don avec celui du paiement.
     */
    private function updateDonStatus(Don $don, Paiement $paiement): void
    {
        $donStatut = match ($paiement->statut) {
            Paiement::STATUT_REUSSI => Don::STATUT_COMPLETE,
            Paiement::STATUT_ECHOUE => Don::STATUT_ECHOUE,
            Paiement::STATUT_REMBOURSE => Don::STATUT_REMBOURSE,
            default => $don->statut,
        };

        $don->update([
            'statut' => $donStatut,
            'paye_at' => $paiement->isReussi() ? $paiement->paye_at : null,
            'reference_externe' => $paiement->reference_provider ?? $don->reference_externe,
        ]);
    }
}
