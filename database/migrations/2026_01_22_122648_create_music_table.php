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
        Schema::create('musics', function (Blueprint $table) {
    $table->id();
    $table->foreignId('album_id')->constrained()->onDelete('cascade');
    $table->string('track_name');
    $table->string('artist_name');
    $table->integer('track_time')->nullable();
    $table->string('preview_url')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('music');
    }
};
