<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mobile_money_providers', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->unique();
            $table->string('code', 50)->unique(); // mtn, moov, celtis
            $table->string('api_url')->nullable();
            $table->string('api_key')->nullable();
            $table->string('api_secret')->nullable();
            $table->boolean('sandbox')->default(true);
            $table->json('credentials')->nullable(); // extra config
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mobile_money_providers');
    }
};
