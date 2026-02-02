<?php


namespace  Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{


   public function run(): void 
   {
      $roles = [
        'donateur',
        'beneficier',
        'association',
        'admin',
      ];

      foreach($roles as $role){ 
        Role::firstOrCreate([
            'libelle_role'=> $role,
        ]);
      }

   }  

}