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
        Schema::create('game_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('total_seconds')->default(0);
            $table->unsignedInteger('times_as_tagger')->default(0);
            $table->unsignedInteger('longest_turn_seconds')->nullable();
            $table->unsignedInteger('shortest_turn_seconds')->nullable();
            $table->unsignedInteger('average_turn_seconds')->nullable();
            $table->dateTime('last_calculated_at')->nullable();
            $table->timestamps();

            $table->unique(['game_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_statistics');
    }
};
