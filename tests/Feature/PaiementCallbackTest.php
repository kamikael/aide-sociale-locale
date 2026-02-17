<?php

namespace Tests\Feature;

use App\Models\Don;
use App\Models\Paiement;
use App\Models\Utilisateur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaiementCallbackTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate', ['--env' => 'testing']);
    }

    public function test_paiement_callback_met_a_jour_statut_et_don(): void
    {
        $utilisateur = Utilisateur::create([
            'nom' => 'Test',
            'email' => 'test@test.com',
            'statut_validation' => 'valide',
        ]);

        $don = Don::create([
            'utilisateur_id' => $utilisateur->id_utilisateur,
            'montant' => 100,
            'statut' => Don::STATUT_EN_ATTENTE,
        ]);

        $paiement = Paiement::create([
            'don_id' => $don->id,
            'montant' => 100,
            'statut' => Paiement::STATUT_INITIE,
        ]);

        $response = $this->postJson('/api/paiement/callback', [
            'paiement_id' => $paiement->id,
            'statut' => 'reussi',
            'reference_provider' => 'REF-123',
        ]);

        $response->assertOk();
        $response->assertJsonPath('paiement.statut', 'reussi');
        $response->assertJsonPath('don.statut', Don::STATUT_COMPLETE);

        $this->assertDatabaseHas('paiements', ['id' => $paiement->id, 'statut' => 'reussi']);
        $this->assertDatabaseHas('dons', ['id' => $don->id, 'statut' => Don::STATUT_COMPLETE]);
    }
}
