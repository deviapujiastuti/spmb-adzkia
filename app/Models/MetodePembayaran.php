<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodePembayaran extends Model
{
    use HasFactory;

    protected $table = 'metode_pembayarans';

    protected $fillable = [
        'kategori',
        'nama_provider',
        'nama_bank_lengkap',
        'nomor_tujuan',
        'atas_nama',
        'is_active',
    ];
}