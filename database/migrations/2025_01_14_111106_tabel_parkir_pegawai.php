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
        Schema::create('parkir_pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('kode_member');
            $table->string('plat_kendaraan');
            $table->dateTime('waktu_masuk');
            $table->dateTime('waktu_keluar')->nullable(); // Diisi saat pegawai keluar
            $table->unsignedBigInteger('pegawai_id');
            $table->foreign('pegawai_id')->references('id')->on('pegawai')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('status', ['Terparkir', 'Keluar'])->default('Terparkir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parkir_pegawai');
    }
};
