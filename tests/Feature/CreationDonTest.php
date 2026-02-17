<?php

namespace Tests\Feature;

use App\Models\Don;
use App\Models\Utilisateur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreationDonTest extends TestCase
{
    use RefreshDatabase;

    public function test_post_paiement_initiate_cree_don_et_paiement(): void
    {
        $utilisateur = Utilisateur::create([
            'nom' => 'Donateur',
            'email' => 'don@test.com',
            'statut_validation' => 'valide',
        ]);

        $response = $this->postJson('/api/paiement/initiate', [
            'utilisateur_id' => $utilisateur->id_utilisateur,
            'montant' => 50.00,
            'provider' => 'mtn',
        ]);

        $response->assertStatus(201);
        $this->assertEquals(50, (float) $response->json('montant'));
        $response->assertJsonStructure(['don_id', 'paiement_id', 'reference', 'checkout_url']);

        $this->assertDatabaseHas('dons', [
            'utilisateur_id' => $utilisateur->id_utilisateur,
            'montant' => 50,
            'statut' => Don::STATUT_EN_ATTENTE,
        ]);
        $donId = $response->json('don_id');
        $this->assertDatabaseHas('paiements', ['don_id' => $donId]);
    }

    public function test_initiate_sans_utilisateur_valide_echoue(): void
    {
        $response = $this->postJson('/api/paiement/initiate', [
            'utilisateur_id' => 99999,
            'montant' => 10,
        ]);

        $response->assertUnprocessable();
    }
}
