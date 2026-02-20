<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MobileMoneyProviderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'FedaPay',
            'api_base_url' => 'https://api.fedapay.com',
        ];
    }
}