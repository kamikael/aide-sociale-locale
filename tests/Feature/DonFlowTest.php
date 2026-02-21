<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Cagnotte;
use App\Models\Paiement;
use App\Models\Don;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DonFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_commission_created_when_paiement_success()
    {
        $roleDonateur = Role::factory()->create(['name' => 'donateur']);
        $roleOrganisateur = Role::factory()->create(['name' => 'organisateur']);

        $organisateur = User::factory()->create([
            'role_id' => $roleOrganisateur->id,
            'status' => 'active',
        ]);

        $cagnotte = Cagnotte::factory()->create([
            'organisateur_id' => $organisateur->id,
        ]);

        $donateur = User::factory()->create([
            'role_id' => $roleDonateur->id,
        ]);

        $paiement = Paiement::factory()->create([
            'status' => 'success',
        ]);

        $don = Don::factory()->create([
            'donateur_id' => $donateur->id,
            'cagnotte_id' => $cagnotte->id,
            'paiement_id' => $paiement->id,
            'montant' => 10000,
        ]);

        event(new \App\Events\DonCreated($don));

        $this->assertDatabaseHas('commissions', [
            'paiement_id' => $paiement->id,
            'amount' => 1000,
        ]);
    }

    public function test_admin_can_validate_organisateur()
{
    $roleAdmin = Role::factory()->create(['name' => 'admin']);
    $roleOrg = Role::factory()->create(['name' => 'organisateur']);

    $admin = User::factory()->create([
        'role_id' => $roleAdmin->id,
        'status' => 'active',
    ]);

    $organisateur = User::factory()->create([
        'role_id' => $roleOrg->id,
        'status' => 'pending',
    ]);

    $this->actingAs($admin)
        ->post("/admin/organisateurs/{$organisateur->id}/approve");

    $this->assertDatabaseHas('users', [
        'id' => $organisateur->id,
        'status' => 'active',
    ]);
}

}