<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Cagnotte;

class CagnotteSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer organisateurs actifs
        $organisateurs = User::whereHas('role', function ($q) {
            $q->where('name', 'organisateur');
        })
        ->where('status', 'active')
        ->get();

        foreach ($organisateurs as $organisateur) {

            // Chaque organisateur aura entre 2 et 5 cagnottes
            Cagnotte::factory()
                ->count(rand(0, 1))
                ->create([
                    'organisateur_id' => $organisateur->id,
                ]);
        }
    }
}