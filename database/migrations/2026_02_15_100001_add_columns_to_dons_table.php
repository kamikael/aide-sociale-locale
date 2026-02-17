<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dons', function (Blueprint $table) {
            $table->unsignedBigInteger('utilisateur_id')->nullable()->after('id');
        $table->foreign('utilisateur_id')->references('id_utilisateur')->on('utilisateurs')->nullOnDelete();
            $table->decimal('montant', 12, 2)->default(0)->after('utilisateur_id');
            $table->string('statut')->default('en_attente')->after('montant'); // en_attente, complete, echoue, rembourse
            $table->string('reference_externe')->nullable()->after('statut');
            $table->timestamp('paye_at')->nullable()->after('reference_externe');
        });
    }

    public function down(): void
    {
        Schema::table('dons', function (Blueprint $table) {
            $table->dropColumn(['utilisateur_id', 'montant', 'statut', 'reference_externe', 'paye_at']);
        });
    }
};
