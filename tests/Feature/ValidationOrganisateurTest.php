<?php

namespace Tests\Feature;

use App\Models\Utilisateur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ValidationOrganisateurTest extends TestCase
{
    use RefreshDatabase;

    public function test_put_validate_organisateur_met_a_jour_statut(): void
    {
        $utilisateur = Utilisateur::create([
            'nom' => 'Org Test',
            'email' => 'org@test.com',
            'statut_validation' => Utilisateur::STATUT_EN_ATTENTE,
        ]);

        $response = $this->putJson("/api/admin/organisateur/{$utilisateur->id_utilisateur}/validate");

        $response->assertOk();
        $response->assertJsonPath('utilisateur.statut_validation', Utilisateur::STATUT_VALIDE);
        $this->assertDatabaseHas('utilisateurs', [
            'id_utilisateur' => $utilisateur->id_utilisateur,
            'statut_validation' => Utilisateur::STATUT_VALIDE,
        ]);
    }

    public function test_validate_organisateur_inexistant_retourne_404(): void
    {
        $response = $this->putJson('/api/admin/organisateur/99999/validate');

        $response->assertNotFound();
    }
}
