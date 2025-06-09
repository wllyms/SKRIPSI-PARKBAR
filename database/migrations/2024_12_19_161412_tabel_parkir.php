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
        Schema::create('parkir', function (Blueprint $table) {
            $table->id();

            // Kolom baru untuk kode parkir otomatis 
            $table->string('kode_parkir')->unique();

            $table->string('plat_kendaraan');

            // Relasi ke tabel tarif
            $table->foreignId('tarif_id')
                ->constrained('tarif')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            // Relasi ke user petugas (misalnya tabel "tuser")
            $table->foreignId('user_id')
                ->constrained('tuser')
                ->cascadeOnDelete();

            $table->dateTime('waktu_masuk');
            $table->dateTime('waktu_keluar')->nullable();

            $table->enum('status', ['Terparkir', 'Keluar'])->default('Terparkir');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parkir');
    }
};
