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
        Schema::table('koleksi', function (Blueprint $table) {
            $table->string('tempat_lahir_penyerah')->nullable()->after('nama_penyerah');
            $table->date('tanggal_lahir_penyerah')->nullable()->after('tempat_lahir_penyerah');
            $table->string('pekerjaan_penyerah')->nullable()->after('tanggal_lahir_penyerah');
            $table->text('alamat_penyerah')->nullable()->after('pekerjaan_penyerah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('koleksi', function (Blueprint $table) {
            $table->dropColumn([
                'tempat_lahir_penyerah',
                'tanggal_lahir_penyerah',
                'pekerjaan_penyerah',
                'alamat_penyerah'
            ]);
        });
    }
};
