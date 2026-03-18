<?php

namespace App\Listeners;

use App\Events\DonCreated;
use App\Models\Commission;

class UpdateCagnotteAmount
{
    public function handle(DonCreated $event): void
    {
        $don = $event->don;
        $cagnotte = $don->cagnotte;

        $cagnotte->increment('collected_amount', $don->montant);

        $commissionRate = 10; // 10%
        $commissionAmount = ($don->montant * $commissionRate) / 100;

        Commission::create([
            'paiement_id' => $don->paiement_id,
            'amount' => $commissionAmount,
            'rate_percentage' => $commissionRate,
        ]);
    }

}
