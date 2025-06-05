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
            $table->string('plat_kendaraan');

            $table->foreignId('tarif_id')->constrained('tarif')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('user_id')->constrained('tuser')->cascadeOnDelete();

            $table->dateTime('waktu_masuk');            // gabungan tanggal + jam masuk
            $table->dateTime('waktu_keluar')->nullable(); // gabungan tanggal + jam keluar, nullable karena kendaraan bisa belum keluar

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
