<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['libelle_role' => 'admin'],
            ['libelle_role' => 'donateur'],
            ['libelle_role' => 'organisateur'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['libelle_role' => $role['libelle_role']],
                $role
            );
        }
    }
}
