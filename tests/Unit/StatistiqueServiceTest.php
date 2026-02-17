<?php

namespace Tests\Unit;

use App\Models\Cagnotte;
use App\Models\Commission;
use App\Models\Don;
use App\Models\Utilisateur;
use App\Services\StatistiqueService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatistiqueServiceTest extends TestCase
{
    use RefreshDatabase;

    protected StatistiqueService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new StatistiqueService;
    }

    public function test_total_dons_somme_uniquement_complete(): void
    {
        $u = Utilisateur::create(['nom' => 'U', 'email' => 'u@u.com', 'statut_validation' => 'valide']);

        Don::create([
            'utilisateur_id' => $u->id_utilisateur,
            'montant' => 100,
            'statut' => Don::STATUT_COMPLETE,
            'paye_at' => now(),
        ]);
        Don::create([
            'utilisateur_id' => $u->id_utilisateur,
            'montant' => 50,
            'statut' => Don::STATUT_EN_ATTENTE,
        ]);

        $this->assertSame(100.0, $this->service->totalDons());
    }

    public function test_total_commissions(): void
    {
        $u = Utilisateur::create(['nom' => 'U', 'email' => 'u@u.com', 'statut_validation' => 'valide']);
        $don = Don::create([
            'utilisateur_id' => $u->id_utilisateur,
            'montant' => 100,
            'statut' => Don::STATUT_COMPLETE,
        ]);
        Commission::create(['don_id' => $don->id, 'montant_commission' => 10]);

        $this->assertSame(10.0, $this->service->totalCommissions());
    }

    public function test_top_5_cagnottes_ordonne_par_montant(): void
    {
        Cagnotte::create(['titre' => 'A', 'slug' => 'a', 'montant_collecte' => 100, 'objectif' => 500]);
        Cagnotte::create(['titre' => 'B', 'slug' => 'b', 'montant_collecte' => 500, 'objectif' => 500]);
        Cagnotte::create(['titre' => 'C', 'slug' => 'c', 'montant_collecte' => 200, 'objectif' => 500]);

        $top = $this->service->top5Cagnottes();

        $this->assertSame(3, $top->count());
        $this->assertSame(500.0, (float) $top->first()->montant_collecte);
    }

    public function test_resume_contient_toutes_les_cles(): void
    {
        $resume = $this->service->resume();

        $this->assertArrayHasKey('total_dons', $resume);
        $this->assertArrayHasKey('total_commissions', $resume);
        $this->assertArrayHasKey('top_5_cagnottes', $resume);
        $this->assertArrayHasKey('dons_par_mois', $resume);
    }
}
