<?php 

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder 
{
    public function run():void
    {
        Role::create(['name' => 'admin', 'created_at' => now(), 'updated_at' => now()]);
        Role::create(['name' => 'donateur', 'created_at' => now(), 'updated_at' => now()]);
        Role::create(['name' => 'organisateur', 'created_at' => now(), 'updated_at' => now()]);
    }
}