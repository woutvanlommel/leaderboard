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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('invite_code')->unique();
            $table->string('color');
            $table->json('rules')->nullable();
            $table->dateTime('starts_at');
            $table->dateTime('ends_at');
            $table->unsignedInteger('min_tagger_seconds')->default(0);
            $table->boolean('back_tag_allowed')->default(true);
            $table->boolean('notifications_enabled')->default(false);
            $table->unsignedInteger('auto_confirm_minutes')->default(15);
            $table->unsignedBigInteger('current_tag_turn_id')->nullable();
            $table->string('status')->default('scheduled');
            $table->foreignId('created_by_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropForeign(['created_by_id']);
        });

        Schema::dropIfExists('games');
    }
};
