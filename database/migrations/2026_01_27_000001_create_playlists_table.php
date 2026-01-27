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
        Schema::create('playlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Tabela pivot para relacionar playlists com músicas
        Schema::create('playlist_music', function (Blueprint $table) {
            $table->id();
            $table->foreignId('playlist_id')->constrained('playlists')->onDelete('cascade');
            $table->foreignId('music_id')->constrained('musics')->onDelete('cascade');
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('playlist_music');
        Schema::dropIfExists('playlists');
    }
};
