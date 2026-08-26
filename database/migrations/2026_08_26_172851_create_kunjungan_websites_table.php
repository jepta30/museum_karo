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
        Schema::create('kunjungan_websites', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address')->nullable();
            $table->string('device_type')->default('desktop');
            $table->string('url')->nullable();
            $table->foreignId('koleksi_id')->nullable()->constrained('koleksi')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kunjungan_websites');
    }
};
