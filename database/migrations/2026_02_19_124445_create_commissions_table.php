<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('paiement_id')
                ->unique()
                ->constrained('paiements')
                ->cascadeOnDelete();

            $table->decimal('amount', 12, 2);
            $table->decimal('rate_percentage', 5, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
};
