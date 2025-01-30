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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('plat_kendaraan');
            $table->string('nama');
            $table->string('no_telp');
            $table->string('email');
            $table->string('alamat'); 
            $table->string('merk_kendaraan');
            $table->string('image');

            $table->unsignedBigInteger('jenis_pegawai_id');
            $table->foreign('jenis_pegawai_id')->references('id')->on('jenis_pegawai')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
