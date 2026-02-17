<?php

namespace Database\Seeders;

use App\Models\MobileMoneyProvider;
use Illuminate\Database\Seeder;

class ProviderSeeder extends Seeder
{
    public function run(): void
    {
        $providers = [
            ['nom' => 'MTN', 'code' => 'mtn', 'sandbox' => true],
            ['nom' => 'Moov', 'code' => 'moov', 'sandbox' => true],
            ['nom' => 'Celtis', 'code' => 'celtis', 'sandbox' => true],
        ];

        foreach ($providers as $p) {
            MobileMoneyProvider::firstOrCreate(
                ['code' => $p['code']],
                array_merge($p, ['api_url' => null, 'api_key' => null, 'api_secret' => null])
            );
        }
    }
}
