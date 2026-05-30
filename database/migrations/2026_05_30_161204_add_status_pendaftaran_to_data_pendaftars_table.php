<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_pendaftars', function (Blueprint $table) {
            // Ini untuk mengembalikan kolom status PENDAFTARAN yang hilang
            if (!Schema::hasColumn('data_pendaftars', 'status_pendaftaran')) {
                $table->string('status_pendaftaran')->nullable()->default('Draft');
            }
        });
    }

    public function down(): void
    {
        Schema::table('data_pendaftars', function (Blueprint $table) {
            if (Schema::hasColumn('data_pendaftars', 'status_pendaftaran')) {
                $table->dropColumn('status_pendaftaran');
            }
        });
    }
};
