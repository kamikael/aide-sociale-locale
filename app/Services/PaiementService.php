<?php

namespace App\Services;

use App\Models\Paiement;
use FedaPay\FedaPay;
use FedaPay\Transaction;

class PaiementService
{
    public function __construct()
    {
        FedaPay::setApiKey(config('services.fedapay.secret_key'));
        FedaPay::setEnvironment(config('services.fedapay.environment'));
    }

    public function createCheckout(Paiement $paiement, string $customerEmail)
    {
        $transaction = Transaction::create([
            "description" => "Don pour cagnotte",
            "amount" => $paiement->montant,
            "currency" => ["iso" => "XOF"],
            "callback_url" => route('fedapay.callback'),
            "customer" => [
                "email" => $customerEmail,
            ],
            "metadata" => [
                "paiement_id" => $paiement->id,
            ]
        ]);

        return $transaction->generateToken()->url;
    }
}
