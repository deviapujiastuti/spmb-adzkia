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
        Schema::table('data_pendaftars', function (Blueprint $table) {
            // Cek jika kolom belum ada agar tidak bentrok
            if (!Schema::hasColumn('data_pendaftars', 'metode_pembayaran')) {
                $table->string('metode_pembayaran')->nullable();
            }
            if (!Schema::hasColumn('data_pendaftars', 'bukti_pembayaran')) {
                $table->string('bukti_pembayaran')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_pendaftars', function (Blueprint $table) {
            if (Schema::hasColumn('data_pendaftars', 'metode_pembayaran')) {
                $table->dropColumn('metode_pembayaran');
            }
            if (Schema::hasColumn('data_pendaftars', 'bukti_pembayaran')) {
                $table->dropColumn('bukti_pembayaran');
            }
        });
    }
};