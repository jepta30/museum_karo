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
        Schema::create('koleksi', function (Blueprint $table) {
            $table->id();
            
            // Status dan Relasi
            $table->enum('status', ['menunggu_kurasi', 'menunggu_persetujuan', 'disetujui', 'dipublikasi'])->default('menunggu_kurasi');
            $table->foreignId('kategori_id')->constrained('kategori')->onDelete('cascade');
            
            // Data Pendaftar
            $table->string('nama_sementara');
            $table->string('nama_penyerah');
            $table->date('tanggal_terima');
            $table->text('kondisi_awal')->nullable();
            $table->string('path_foto');
            $table->text('klaim_asal_usul')->nullable();
            
            // Data Kurator
            $table->text('sejarah_asal_usul')->nullable();
            $table->text('kondisi_kuratorial')->nullable();
            $table->string('draf_nomor_inventaris')->nullable();
            
            // Data Pimpinan
            $table->string('nomor_inventaris_final')->nullable();
            $table->timestamp('tanggal_persetujuan')->nullable();
            $table->string('path_dokumen_berita_acara')->nullable();
            
            // Data Edukator
            $table->text('narasi_publik')->nullable();
            $table->text('fungsi_masa_lalu')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('koleksi');
    }
};
