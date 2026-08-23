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
        Schema::table('modul_edukasis', function (Blueprint $table) {
            $table->foreignId('koleksi_id')->nullable()->constrained('koleksi')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('modul_edukasis', function (Blueprint $table) {
            $table->dropForeign(['koleksi_id']);
            $table->dropColumn('koleksi_id');
        });
    }
};
