<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('metode_pembayarans', function (Blueprint $table) {
            $table->id();
            // Menyimpan jenis: 'Bank Transfer', 'Virtual Account', atau 'E-Wallet'
            $table->string('kategori'); 
            // Menyimpan nama: 'MANDIRI', 'BNI', 'DANA', 'OVO'
            $table->string('nama_provider'); 
            // Menyimpan nama bank resmi lengkap: 'Bank Mandiri', 'Bank Central Asia'
            $table->string('nama_bank_lengkap')->nullable(); 
            // Menyimpan nomor rekening / nomor VA / nomor HP e-wallet
            $table->string('nomor_tujuan'); 
            // Menyimpan atas nama rekening: 'SPMB ADMISSION'
            $table->string('atas_nama'); 
            // Untuk mengontrol apakah metode ini sedang diaktifkan atau dinonaktifkan oleh admin
            $table->boolean('is_active')->default(true); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('metode_pembayarans');
    }
};