<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Don;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use FedaPay\FedaPay;
use FedaPay\Event;

class PaiementController extends Controller
{
    public function callback(Request $request)
    {
        // 1️⃣ Config FedaPay
        FedaPay::setApiKey(config('services.fedapay.secret_key'));
        FedaPay::setEnvironment(config('services.fedapay.environment'));

        /** @var Event|null $event */
        $event = $request->attributes->get('fedapay_event');

        if (!$event) {
            Log::warning('FedaPay event manquant sur la requête (middleware non exécuté ?)');
            return response()->json(['error' => 'Invalid webhook context'], 400);
        }

        // ✅ On travaille maintenant avec l'event sécurisé
        Log::info('Webhook FedaPay reçu', ['event' => $event->name]);

        // 3️⃣ On traite seulement transaction.approved
        if ($event->name !== 'transaction.approved') {
            return response()->json(['status' => 'ignored']);
        }

        $transactionId = $event->entity->id ?? null;

        if (!$transactionId) {
            Log::error('Transaction ID manquant dans event');
            return response()->json(['error' => 'Missing transaction id'], 400);
        }

        // 4️⃣ Récupération transaction complète
        try {
            $transaction = \FedaPay\Transaction::retrieve($transactionId);
        } catch (\Exception $e) {
            Log::error('Erreur récupération transaction', [
                'message' => $e->getMessage()
            ]);
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        $paiementId = $transaction->metadata->paiement_id ?? null;

        if (!$paiementId) {
            Log::error('Paiement ID manquant dans metadata');
            return response()->json(['error' => 'Missing metadata'], 400);
        }

        $paiement = Paiement::find($paiementId);

        if (!$paiement) {
            Log::error('Paiement non trouvé', ['paiement_id' => $paiementId]);
            return response()->json(['error' => 'Paiement not found'], 404);
        }

        // 🔒 Idempotence
        if ($paiement->status === 'success') {
            return response()->json(['status' => 'already_processed']);
        }

        // ✅ SUCCESS
        $paiement->update([
            'status' => 'success',
            'paid_at' => now(),
            'external_reference' => $transaction->id,
        ]);

        Don::create([
            'donateur_id' => $paiement->user_id,
            'cagnotte_id' => $paiement->cagnotte_id,
            'paiement_id' => $paiement->id,
            'montant' => $paiement->montant,
            'status' => 'success',
        ]);

        Log::info("Paiement {$paiementId} confirmé via webhook");

        return response()->json(['status' => 'success']);
    }

    /**
     * Callback appelé par FedaPay après le paiement (via callback_url).
     * On utilise uniquement le paramètre "status" pour afficher une page
     * user-friendly, mais l'état réel est géré par le webhook.
     */
    public function redirectFromFedaPay(Request $request)
    {
        $status = $request->query('status');

        if ($status === 'approved') {
            return redirect()->route('paiement.success');
        }

        // Si le statut est encore "pending", on affiche une page dédiée
        if ($status === 'pending') {
            return redirect()->route('paiement.pending');
        }

        return redirect()->route('paiement.failed');
    }

    /**
     * Page de succès affichée à l'utilisateur après un paiement accepté.
     */
    public function successPage()
    {
        return view('paiement.success');
    }

    /**
     * Page d'échec affichée à l'utilisateur après un paiement refusé/annulé.
     */
    public function failedPage()
    {
        return view('paiement.failed');
    }

    /**
     * Page affichée quand FedaPay renvoie un statut "pending" (paiement en cours).
     */
    public function pendingPage()
    {
        return view('paiement.pending');
    }
}