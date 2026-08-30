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
        Schema::create('galeri_moduls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('modul_edukasi_id')->constrained('modul_edukasis')->onDelete('cascade');
            $table->enum('tipe', ['foto', 'video'])->default('foto');
            $table->string('path_file');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galeri_moduls');
    }
};
