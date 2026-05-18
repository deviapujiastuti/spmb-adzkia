<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DataPendaftar; // Model yang digunakan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('user.register'); 
    }

    public function store(Request $request)
    {
        // 1. Validasi Inputan Mahasiswa
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'no_hp'    => 'required|string|max:20',
            'password' => 'required|string|min:8',
        ], [
            'email.unique' => 'Email ini sudah terdaftar di sistem kami.',
            'password.min' => 'Password minimal harus berisikan 8 karakter.',
        ]);

        try {
            DB::transaction(function () use ($request) {
                
                // Masukkan data dasar login ke tabel users
                $user = User::create([
                    'name'     => $request->name,
                    'email'    => $request->email,
                    'password' => Hash::make($request->password),
                ]);

                // PERBAIKAN 1: Menggunakan DataPendaftar sesuai dengan import di atas
                DataPendaftar::create([
                    'user_id'       => $user->id, 
                    'no_hp'         => $request->no_hp,
                    'status'        => 'Belum Bayar', 
                    'program_studi' => '-', 
                    'jalur'         => '-',
                    'jalur_detail'  => '-',
                ]);

            auth()->login($user);
        });

        // Diarahkan langsung ke URL /pembayaran yang baru kita buat rutenya
        return redirect('/pembayaran')->with('success', 'Registrasi sukses! Silakan lakukan pembayaran.');

    } catch (\Exception $e) {
        return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan sistem: ' . $e->getMessage()]);
    }
}
}