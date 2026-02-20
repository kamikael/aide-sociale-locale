<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Events\DonCreated;
use Illuminate\Http\Request;
use FedaPay\FedaPay;
use FedaPay\Transaction;

class PaiementController extends Controller
{
    public function callback(Request $request)
    {
        FedaPay::setApiKey(config('services.fedapay.secret_key'));
        FedaPay::setEnvironment(config('services.fedapay.environment'));

        $transactionId = $request->input('entity.id');

        if (!$transactionId) {
            return response()->json(['error' => 'Invalid payload'], 400);
        }

        $transaction = Transaction::retrieve($transactionId);

        if ($transaction->status !== "approved") {
            return response()->json(['status' => 'ignored']);
        }

        $paiementId = $transaction->metadata->paiement_id ?? null;

        if (!$paiementId) {
            return response()->json(['error' => 'Missing metadata'], 400);
        }

        $paiement = Paiement::find($paiementId);

        if (!$paiement) {
            return response()->json(['error' => 'Paiement not found'], 404);
        }

        // Idempotence : éviter double traitement
        if ($paiement->status === 'success') {
            return response()->json(['status' => 'already_processed']);
        }

        $paiement->update([
            'status' => 'success',
            'paid_at' => now(),
        ]);

        event(new DonCreated($paiement->don));

        return response()->json(['status' => 'success']);
    }
}
