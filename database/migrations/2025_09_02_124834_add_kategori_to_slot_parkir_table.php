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
        Schema::table('slot_parkir', function (Blueprint $table) {
            // Tambahkan kolom 'kategori_id' sebagai foreign key yang mengacu ke tabel 'kategori'
            $table->foreignId('kategori_id')
                  ->nullable() // Atur ini ke nullable jika ada slot yang tidak terikat kategori
                  ->constrained('kategori')
                  ->onDelete('set null'); // Jika kategori dihapus, atur kategori_id di slot parkir menjadi NULL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('slot_parkir', function (Blueprint $table) {
            // Hapus foreign key terlebih dahulu
            $table->dropForeign(['kategori_id']);
            // Hapus kolom
            $table->dropColumn('kategori_id');
        });
    }
};
