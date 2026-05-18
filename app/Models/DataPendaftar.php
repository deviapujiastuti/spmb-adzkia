<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; 

class DataPendaftar extends Model
{
    use HasFactory;

    protected $table = 'data_pendaftar'; 

    protected $fillable = [
        'user_id',
        'no_hp',
        'program_studi',
        'jalur',
        'jalur_detail',
        'status',
        'nilai_seleksi',
        'status_kelulusan',
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}