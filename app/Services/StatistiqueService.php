<?php

namespace App\Services;

use App\Models\Cagnotte;
use App\Models\Commission;
use App\Models\Don;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class StatistiqueService
{
    /**
     * Total des dons (montant) — statut complete uniquement.
     */
    public function totalDons(): float
    {
        return (float) Don::where('statut', Don::STATUT_COMPLETE)->sum('montant');
    }

    /**
     * Total des commissions.
     */
    public function totalCommissions(): float
    {
        return (float) Commission::sum('montant_commission');
    }

    /**
     * Top 5 cagnottes (par montant collecté).
     */
    public function top5Cagnottes(): Collection
    {
        return Cagnotte::orderByDesc('montant_collecte')->limit(5)->get();
    }

    /**
     * Dons par mois (année courante par défaut). Compatible SQLite et MySQL.
     */
    public function donsParMois(?int $annee = null): Collection
    {
        $annee = $annee ?? (int) date('Y');
        $driver = DB::connection()->getDriverName();
        $monthExpr = $driver === 'sqlite'
            ? "cast(strftime('%m', paye_at) as integer)"
            : 'MONTH(paye_at)';

        $query = Don::query()
            ->where('statut', Don::STATUT_COMPLETE)
            ->whereYear('paye_at', $annee)
            ->selectRaw("{$monthExpr} as mois, SUM(montant) as total");
        $query = $driver === 'sqlite'
            ? $query->groupByRaw($monthExpr)->orderByRaw($monthExpr)
            : $query->groupBy('mois')->orderBy('mois');

        return $query
            ->get()
            ->mapWithKeys(fn ($row) => [(int) $row->mois => (float) $row->total]);
    }

    /**
     * Résumé complet pour le dashboard.
     */
    public function resume(): array
    {
        return [
            'total_dons' => $this->totalDons(),
            'total_commissions' => $this->totalCommissions(),
            'top_5_cagnottes' => $this->top5Cagnottes(),
            'dons_par_mois' => $this->donsParMois(),
        ];
    }
}
