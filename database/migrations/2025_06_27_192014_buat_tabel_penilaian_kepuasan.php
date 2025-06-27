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
        Schema::create('penilaian_kepuasan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parkir_id')->unique()->constrained('parkir')->cascadeOnDelete();
            $table->foreignId('tuser_id')->constrained('tuser')->cascadeOnDelete();
            $table->text('komentar_fasilitas')->nullable();
            $table->text('komentar_petugas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_kepuasan');
    }
};
