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

            $table->unsignedBigInteger('tarif_id');
            $table->foreign('tarif_id')->references('id')->on('tarif')->onDelete('cascade')->onUpdate('cascade');

            $table->date('tanggal')->nullable();
            $table->string('jam_masuk');
            $table->string('jam_keluar')->nullable();
            $table->enum('status', ['Terparkir', 'Keluar'])->default('Terparkir'); // Kolom Status
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
