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
        Schema::create('game_rivalries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tagger_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('tagged_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedInteger('tag_count')->default(0);
            $table->dateTime('last_tagged_at')->nullable();
            $table->timestamps();

            $table->unique(['game_id', 'tagger_id', 'tagged_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_rivalries');
    }
};
