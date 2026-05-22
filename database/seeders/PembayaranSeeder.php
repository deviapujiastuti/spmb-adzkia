<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MetodePembayaran;

class PembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bersihkan data lama di tabel metode_pembayarans agar tidak duplikat saat dijalankan ulang
        MetodePembayaran::truncate();

        // 1. Opsi Metode Pembayaran: Bank Transfer
        MetodePembayaran::create([
            'kategori'          => 'Bank Transfer',
            'nama_provider'     => 'BCA',
            'nama_bank_lengkap' => 'Bank Central Asia',
            'nomor_tujuan'      => '0321 9842 112',
            'atas_nama'         => 'SPMB UNIVERSITAS ADZKIA',
            'is_active'         => true,
        ]);

        // 2. Opsi Metode Pembayaran: Virtual Account
        MetodePembayaran::create([
            'kategori'          => 'Virtual Account',
            'nama_provider'     => 'MANDIRI',
            'nama_bank_lengkap' => 'Bank Mandiri',
            'nomor_tujuan'      => '8829 1029 3847 221',
            'atas_nama'         => 'SPMB ADMISSION',
            'is_active'         => true,
        ]);

        MetodePembayaran::create([
            'kategori'          => 'Virtual Account',
            'nama_provider'     => 'BRI',
            'nama_bank_lengkap' => 'Bank Rakyat Indonesia',
            'nomor_tujuan'      => '9880 1234 5678 901',
            'atas_nama'         => 'SPMB ADMISSION ADZKIA',
            'is_active'         => true,
        ]);

        // 3. Opsi Metode Pembayaran: E-Wallet
        MetodePembayaran::create([
            'kategori'          => 'E-Wallet',
            'nama_provider'     => 'DANA',
            'nama_bank_lengkap' => 'Dompet Digital DANA',
            'nomor_tujuan'      => '0813 7943 7010',
            'atas_nama'         => 'UNIVERSITAS ADZKIA OFFICIAL',
            'is_active'         => true,
        ]);
        
        MetodePembayaran::create([
            'kategori'          => 'E-Wallet',
            'nama_provider'     => 'OVO',
            'nama_bank_lengkap' => 'OVO Cash',
            'nomor_tujuan'      => '0813 7943 7010',
            'atas_nama'         => 'UNIVERSITAS ADZKIA OFFICIAL',
            'is_active'         => true,
        ]);
    }
}