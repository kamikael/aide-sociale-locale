<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Role;
use App\Models\Cagnotte;
use Illuminate\Support\Facades\Hash;

class SingleCagnotteSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Récupération des rôles
        |--------------------------------------------------------------------------
        */
        $organisateurRole = Role::where('name', 'organisateur')->first();
        $donateurRole = Role::where('name', 'donateur')->first();

        if (!$organisateurRole || !$donateurRole) {
            throw new \Exception('Les rôles organisateur et donateur doivent exister.');
        }

        /*
        |--------------------------------------------------------------------------
        | Création Organisateur actif
        |--------------------------------------------------------------------------
        */
        $organisateur = User::create([
            'name' => 'Organisateur Test',
            'email' => 'organisateur@test.com',
            'password' => Hash::make('password'),
            'role_id' => $organisateurRole->id,
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Création Donateur actif
        |--------------------------------------------------------------------------
        */
        $donateur = User::create([
            'name' => 'Donateur Test',
            'email' => 'donateur@test.com',
            'password' => Hash::make('password'),
            'role_id' => $donateurRole->id,
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Création d'une seule Cagnotte
        |--------------------------------------------------------------------------
        */
        $title = 'Aide pour une opération médicale urgente';

        Cagnotte::create([
            'title' => $title,
            'slug' => Str::slug($title) . '-' . uniqid(),
            'description' => 'Cette cagnotte a été créée pour financer une opération médicale urgente. Votre soutien est précieux.',
            'organisateur_id' => $organisateur->id,
            'image_path' => null,
            'video_url' => null,
            'target_amount' => 100000,
            'collected_amount' => 5000,
            'status' => 'active',
            'published_at' => now(),
        ]);
    }
}