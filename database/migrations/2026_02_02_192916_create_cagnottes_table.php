<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cagnottes', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();

            $table->foreignId('organisateur_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('title');
            $table->text('description');

            $table->string('image_path')->nullable();
            $table->string('video_url')->nullable();

            $table->decimal('target_amount', 12, 2);
            $table->decimal('collected_amount', 12, 2)->default(0);

            $table->enum('status', ['active', 'closed', 'suspended'])
                ->default('active');

            $table->timestamp('published_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cagnottes');
    }
};
