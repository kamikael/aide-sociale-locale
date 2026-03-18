<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\CagnotteSeeder;
use Database\Seeders\SingleCagnotteSeeder;
use Database\Seeders\MobileMoneyProviderSeeder;
use Database\Seeders\AdminUserSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
             AdminUserSeeder::class,
             SingleCagnotteSeeder::class,
             MobileMoneyProviderSeeder::class
        ]);
    }
}
