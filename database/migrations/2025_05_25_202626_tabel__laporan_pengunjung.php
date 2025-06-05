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
        Schema::create('laporan_pengunjung', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('tuser')->onDelete('cascade');
            $table->string('nama');            // Nama pelapor (pengunjung)
            $table->dateTime('waktu_lapor');  // Gabungan tanggal dan jam pelaporan
            $table->string('no_telp');         // Nomor telepon pelapor
            $table->text('keterangan');        // Isi laporan kehilangan atau keterangan lain
            $table->timestamps();              // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_pengunjung');
    }
};
