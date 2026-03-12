<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MobileMoneyProvider;

class MobileMoneyProviderSeeder extends Seeder
{
    public function run(): void
    {
        $providers = [
            [
                'name' => 'MTN',
                'code' => 'mtn_open',
                'api_base_url' => 'https://api.fedapay.com',
                'country_iso' => 'bj',
                'is_active' => true,
            ],
            [
                'name' => 'Moov',
                'code' => 'moov_open',
                'api_base_url' => 'https://api.fedapay.com',
                'country_iso' => 'bj',
                'is_active' => true,
            ],
            [
                'name' => 'Celtis',
                'code' => 'celtis_open',
                'api_base_url' => 'https://api.fedapay.com',
                'country_iso' => 'bj',
                'is_active' => true,
            ],
        ];

        foreach ($providers as $provider) {
            MobileMoneyProvider::updateOrCreate(
                ['code' => $provider['code']],
                $provider
            );
        }
    }
}