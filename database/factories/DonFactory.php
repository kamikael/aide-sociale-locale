<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Cagnotte;
use App\Models\Paiement;
use Illuminate\Database\Eloquent\Factories\Factory;

class DonFactory extends Factory
{
    public function definition(): array
    {
        return [
            'donateur_id' => User::factory(),
            'cagnotte_id' => Cagnotte::factory(),
            'paiement_id' => Paiement::factory(),
            'montant' => 10000,
        ];
    }
}