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
        Schema::create('modul_edukasis', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->foreignId('penulis_id')->constrained('users')->onDelete('cascade');
            $table->text('konten')->nullable();
            $table->enum('status', ['draf', 'menunggu_persetujuan', 'diterbitkan'])->default('draf');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modul_edukasis');
    }
};
