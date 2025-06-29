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
            // Ini akan mengubah kolom 'status' untuk bisa menerima 'selesai'
            $table->enum('status', ['hilang', 'ditemukan', 'selesai'])->default('hilang')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            // Ini akan mengembalikan seperti semula jika migrasi di-rollback
            $table->enum('status', ['hilang', 'ditemukan'])->default('hilang')->change();
        });
    }
};
