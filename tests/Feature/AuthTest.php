<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_as_donateur()
    {
        // ✅ Créer le rôle et récupérer son id
        $role = Role::factory()->create([
            'name' => 'donateur'
        ]);

        // ✅ Envoyer la vraie payload utilisateur
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@mail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'donateur', // ✅ le controller doit mapper vers role_id
        ]);

        // ✅ Vérifier la redirection
        $response->assertRedirect();

        // ✅ Vérifier en base (plus strict)
        $this->assertDatabaseHas('users', [
            'email' => 'test@mail.com',
            'role_id' => $role->id,
            'status' => 'pending',
        ]);
    }
}
