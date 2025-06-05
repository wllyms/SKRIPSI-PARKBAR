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
        Schema::create('denda', function (Blueprint $table) {
            $table->id();
            $table->string('plat_kendaraan');
            $table->date('tanggal');
            $table->decimal('nominal', 15, 2);
            $table->unsignedBigInteger('parkir_id');
            $table->foreign('parkir_id')->references('id')->on('parkir')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('status', ['Belum Dibayar', 'Sudah Dibayar'])->default('Belum Dibayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('denda');
    }
};
