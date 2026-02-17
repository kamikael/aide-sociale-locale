<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('don_id')->constrained('dons')->cascadeOnDelete();
            $table->decimal('montant', 12, 2);
            $table->string('statut')->default('initie'); // initie, en_attente, reussi, echoue, rembourse
            $table->string('reference_provider')->nullable()->unique();
            $table->string('provider')->nullable(); // stripe, paypal, orange_money, etc.
            $table->json('metadata')->nullable();
            $table->timestamp('paye_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
