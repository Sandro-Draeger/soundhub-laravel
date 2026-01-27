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
        // Adicionar coluna role à tabela users se não existir
        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('user')->after('email');
            });
        }

        // Adicionar coluna release_date à tabela albums se não existir
        if (!Schema::hasColumn('albums', 'release_date')) {
            Schema::table('albums', function (Blueprint $table) {
                $table->date('release_date')->nullable()->after('title');
            });
        }

        // Adicionar coluna band_id à tabela albums se não existir
        if (!Schema::hasColumn('albums', 'band_id')) {
            Schema::table('albums', function (Blueprint $table) {
                $table->foreignId('band_id')->nullable()->constrained('bands')->onDelete('cascade')->after('id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }

        if (Schema::hasColumn('albums', 'release_date')) {
            Schema::table('albums', function (Blueprint $table) {
                $table->dropColumn('release_date');
            });
        }

        if (Schema::hasColumn('albums', 'band_id')) {
            Schema::table('albums', function (Blueprint $table) {
                $table->dropForeign(['band_id']);
                $table->dropColumn('band_id');
            });
        }
    }
};
