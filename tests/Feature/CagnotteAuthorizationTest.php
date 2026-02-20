<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CagnotteAuthorizationTest extends TestCase
{
    use RefreshDatabase;

   public function test_organisateur_without_approved_document_cannot_create_cagnotte()
{
    $role = Role::factory()->create(['name' => 'organisateur']);

    $user = User::factory()->create([
        'role_id' => $role->id,
        'status' => 'active',
        'email_verified_at' => now(), // IMPORTANT
    ]);

    $response = $this->actingAs($user)
        ->get('/cagnottes/create');

    $response->assertRedirect(route('organisateur.dashboard'));
}

public function test_organisateur_with_approved_document_can_create_cagnotte()
{
    $role = Role::factory()->create(['name' => 'organisateur']);

    $user = User::factory()->create([
        'role_id' => $role->id,
        'status' => 'active',
    ]);

    $user->organisationDocuments()->create([
        'file_path' => 'test.pdf',
        'status' => 'approved',
    ]);

    $response = $this->actingAs($user)
        ->post('/cagnottes', [
            'title' => 'Test',
            'description' => 'Desc',
            'target_amount' => 10000,
        ]);

    $this->assertDatabaseHas('cagnottes', [
        'title' => 'Test',
    ]);
}

}