<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

  public function up(): void 
  {
    Schema::create('utilisateur_role', function (Blueprint $table){
        
        $table->unsignedBigInteger('id_utilisateur');
        $table->unsignedBigInteger('id_role');

        $table->primary(['id_utilisateur', 'id_role']);

        // FK vers utilisateurs ajoutée dans une migration ultérieure (après create_utilisateurs)
        $table->foreign('id_role')
              ->references('id_role')
              ->on('roles')
              ->onDelete('cascade');    
    });
  }

  public function down(): void 
  {
    Schema::dropIfExists('utilisateur_role');
  }


};