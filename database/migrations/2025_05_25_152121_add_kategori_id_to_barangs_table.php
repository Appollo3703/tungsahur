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
        Schema::table('barangs', function (Blueprint $table) {
            // Tambahkan kolom kategori_id setelah kolom user_id (atau sesuaikan posisinya)
            // Pastikan tipe datanya cocok dengan tipe kolom id di tabel 'kategoris' (biasanya unsignedBigInteger)
            // Buat nullable() jika ada data barang yang sudah ada dan mungkin belum punya kategori
            $table->foreignId('kategori_id')->nullable()->after('user_id')->constrained('kategoris')->onDelete('set null');
            // onDelete('set null') berarti jika kategori dihapus, kategori_id di barang akan jadi NULL
            // Anda bisa juga menggunakan onDelete('cascade') jika ingin barang ikut terhapus saat kategori dihapus,
            // atau onDelete('restrict') untuk mencegah penghapusan kategori jika masih ada barang terkait.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            // Hapus foreign key constraint terlebih dahulu sebelum menghapus kolom
            $table->dropForeign(['kategori_id']);
            $table->dropColumn('kategori_id');
        });
    }
};
