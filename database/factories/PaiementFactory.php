<?php

namespace Database\Factories;

use App\Models\MobileMoneyProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PaiementFactory extends Factory
{
    public function definition(): array
    {
        return [
            'provider_id' => MobileMoneyProvider::factory(),
            'transaction_reference' => Str::uuid(),
            'montant' => 10000,
            'commission_amount' => 0,
            'status' => 'pending',
            'paid_at' => null,
        ];
    }
}