<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mobile_money_providers', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('api_base_url')->nullable();
   $table->string('code')->unique()->after('name');
    $table->string('country_iso')->default('bj')->after('code');
     $table->boolean('is_active')->default(true)->after('country_iso');
    
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobile_money_providers');
    }
};
