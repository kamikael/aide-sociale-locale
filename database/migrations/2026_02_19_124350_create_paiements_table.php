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

            $table->foreignId('provider_id')
                ->constrained('mobile_money_providers')
                ->cascadeOnDelete();

            $table->string('transaction_reference')->unique();

            $table->decimal('montant', 12, 2);
            $table->decimal('commission_amount', 12, 2)->default(0);

            $table->enum('status', ['pending', 'success', 'failed'])
                ->default('pending');

            $table->timestamp('paid_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
