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
        Schema::create('kuesioner_pertanyaan', function (Blueprint $table) {
            $table->id();
            $table->string('teks_pertanyaan');
            $table->enum('kategori', ['fasilitas', 'petugas']);
            $table->enum('tipe_jawaban', ['rating_bintang'])->default('rating_bintang');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuesioner_pertanyaan');
    }
};
