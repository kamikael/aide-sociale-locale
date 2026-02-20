<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dons', function (Blueprint $table) {
            $table->id();

            $table->foreignId('donateur_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('cagnotte_id')
                ->constrained('cagnottes')
                ->cascadeOnDelete();

            $table->foreignId('paiement_id')
                ->unique()
                ->constrained('paiements')
                ->cascadeOnDelete();

            $table->decimal('montant', 12, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dons');
    }
};
