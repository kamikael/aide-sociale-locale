<?php

namespace Tests\Unit;

use App\Models\Don;
use App\Models\Utilisateur;
use App\Services\CommissionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommissionServiceTest extends TestCase
{
    use RefreshDatabase;

    protected CommissionService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new CommissionService;
    }

    /**
     * Test du calcul 10% sans base de données.
     */
    public function test_calcul_10_pourcent(): void
    {
        $this->assertSame(10.0, $this->service->calculer(100.0));
        $this->assertSame(5.5, $this->service->calculer(55.0));
        $this->assertSame(0.01, $this->service->calculer(0.10));
    }

    public function test_creer_pour_don_cree_commission(): void
    {
        $utilisateur = Utilisateur::create([
            'nom' => 'Test',
            'email' => 'test@test.com',
            'statut_validation' => 'valide',
        ]);

        $don = Don::create([
            'utilisateur_id' => $utilisateur->id_utilisateur,
            'montant' => 100,
            'statut' => Don::STATUT_COMPLETE,
        ]);

        $commission = $this->service->creerPourDon($don);

        $this->assertSame($don->id, $commission->don_id);
        $this->assertSame(10.0, (float) $commission->montant_commission);
    }

    public function test_creer_pour_don_update_si_existe_deja(): void
    {
        $utilisateur = Utilisateur::create([
            'nom' => 'Test',
            'email' => 'test2@test.com',
            'statut_validation' => 'valide',
        ]);

        $don = Don::create([
            'utilisateur_id' => $utilisateur->id_utilisateur,
            'montant' => 200,
            'statut' => Don::STATUT_COMPLETE,
        ]);

        $this->service->creerPourDon($don);
        $second = $this->service->creerPourDon($don->fresh());

        $this->assertSame(1, $don->commission()->count());
        $this->assertSame(20.0, (float) $second->montant_commission);
    }
}
