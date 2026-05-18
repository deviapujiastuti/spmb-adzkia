<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'beritas'; // Pastikan nama tabel di PHPMyAdmin memang 'beritas'

    protected $fillable = [
        'judul', 
        'kategori', 
        'ringkasan', 
        'isi', 
        'status', 
        'thumbnail', 
        'tanggal_publish'
    ];
}