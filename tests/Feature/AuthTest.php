<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_as_donateur(): void
    {
        Notification::fake();

        $role = Role::factory()->create([
            'name' => 'donateur',
        ]);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@mail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'donateur',
        ]);

        $response->assertRedirect(route('verification.notice'));

        $this->assertDatabaseHas('users', [
            'email' => 'test@mail.com',
            'role_id' => $role->id,
            'status' => 'active',
        ]);

        $user = User::where('email', 'test@mail.com')->firstOrFail();

        Notification::assertSentToTimes($user, VerifyEmail::class, 1);
        $this->assertAuthenticatedAs($user);
    }
}
