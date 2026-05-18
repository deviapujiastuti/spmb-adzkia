<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminBeritaController extends Controller
{
    public function index() 
    {
        $data = Berita::latest()->get();
        return view('admin.berita', compact('data'));
    }

    public function create()
    {
        return view('admin.berita-create');
    }

    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required',
            'konten' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpg,png,jpeg|max:5120',
        ]);

        // 2. Handle Upload Gambar
        $fileName = null;
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $fileName = time() . '_' . Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();
            
            // Pastikan folder public/uploads/berita sudah dibuat ya!
            $file->move(public_path('uploads/berita'), $fileName);
        }

        // 3. Simpan ke Database
        // Sesuai struktur PHPMyAdmin kamu: id, judul, kategori, ringkasan, isi, status, thumbnail, tanggal_publish
        Berita::create([
            'judul'           => $request->judul,
            'kategori'        => $request->kategori,
            'ringkasan'       => $request->ringkasan, 
            'isi'             => $request->konten, // Mengambil 'konten' dari form, simpan ke 'isi' di DB
            'status'          => $request->status ?? 'Published',
            'thumbnail'       => $fileName,
            'tanggal_publish' => $request->tanggal_publish ?? now(),
        ]);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diterbitkan!');
    }
}