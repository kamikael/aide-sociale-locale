<?php

namespace App\Services;

use App\Models\Commission;
use App\Models\Don;

class CommissionService
{
    public const TAUX_COMMISSION = 0.10; // 10%

    /**
     * Calcule 10% du montant du don et crée l’entrée commission.
     */
    public function creerPourDon(Don $don): Commission
    {
        $montant = (float) $don->montant;
        $montantCommission = round($montant * self::TAUX_COMMISSION, 2);

        return Commission::updateOrCreate(
            ['don_id' => $don->id],
            ['montant_commission' => $montantCommission]
        );
    }

    /**
     * Calcul du montant commission (10%) sans persister.
     */
    public function calculer(float $montantDon): float
    {
        return round($montantDon * self::TAUX_COMMISSION, 2);
    }
}
