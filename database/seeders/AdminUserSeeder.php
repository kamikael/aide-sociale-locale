<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();

        if (!$adminRole) {
            $this->command->error('Le rôle admin est introuvable. Exécute d’abord RoleSeeder.');
            return;
        }

        User::firstOrCreate(
            [
                'email' => 'admin@cagnotte.com',
            ],
            [
                'name' => 'Administrateur',
                'role_id' => $adminRole->id,
                'password' => Hash::make('password123'),
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
    }
}