<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cagnottes', function (Blueprint $table) {
            $table->string('titre')->after('id');
            $table->string('slug')->unique()->after('titre');
            $table->text('description')->nullable()->after('slug');
            $table->decimal('objectif', 12, 2)->default(0)->after('description');
            $table->decimal('montant_collecte', 12, 2)->default(0)->after('objectif');
            $table->boolean('active')->default(true)->after('montant_collecte');
        });
    }

    public function down(): void
    {
        Schema::table('cagnottes', function (Blueprint $table) {
            $table->dropColumn(['titre', 'slug', 'description', 'objectif', 'montant_collecte', 'active']);
        });
    }
};
