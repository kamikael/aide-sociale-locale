<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organisation_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('fichier_path');
            $table->string('nom_fichier')->nullable();
            $table->string('statut')->default('pending'); // pending, valide, rejete
            $table->text('commentaire_admin')->nullable();
            $table->timestamp('valide_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id_utilisateur')->on('utilisateurs')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organisation_documents');
    }
};
