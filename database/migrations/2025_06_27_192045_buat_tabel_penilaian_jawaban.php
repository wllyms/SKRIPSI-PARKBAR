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
        Schema::create('penilaian_jawaban', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penilaian_kepuasan_id')->constrained('penilaian_kepuasan')->cascadeOnDelete();
            $table->foreignId('pertanyaan_id')->constrained('kuesioner_pertanyaan')->cascadeOnDelete();
            $table->tinyInteger('jawaban_rating');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_jawaban');
    }
};
