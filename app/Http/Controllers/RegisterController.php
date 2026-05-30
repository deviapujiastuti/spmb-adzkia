<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataPendaftar;
use App\Models\Prodi;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    // Menampilkan halaman pendaftaran (Tahap 1 SPMB)
    public function showRegister()
    {
        $prodiList = Prodi::all(); 
        
        // Data Dummy untuk Pilihan Jalur Khusus (Jika belum ada dari database)
        $jalurKhusus = [
            'Prestasi' => [
                (object)['name' => 'Prestasi Akademik (Juara Kelas/Olimpiade)'],
                (object)['name' => 'Prestasi Non-Akademik (Olahraga/Seni)'],
                (object)['name' => 'Tahfidz Al-Quran']
            ],
            'Kemitraan' => [
                (object)['name' => 'Kemitraan Instansi Pemerintah'],
                (object)['name' => 'Rekomendasi Yayasan Adzkia']
            ]
        ];

        return view('user.register', compact('prodiList', 'jalurKhusus'));
    }

    // Memproses data yang dikirim dari form
// Memproses data yang dikirim dari form
    public function storeRegister(Request $request)
    {
        // 1. Validasi Input dari Form
        $request->validate([
            'jalur_pendaftaran' => 'required|string',
            'nama_lengkap'      => 'required|string|max:255',
            'nik'               => 'required|numeric|digits:16|unique:data_pendaftars,nik',
            'no_whatsapp'       => 'required|numeric',
            'email'             => 'required|email|unique:data_pendaftars,email',
            'pilihan_jurusan_1' => 'required|string',
            'pilihan_jurusan_2' => 'required|string|different:pilihan_jurusan_1',
            'alamat_rumah'      => 'required|string',
        ], [
            'nik.unique' => 'NIK ini sudah terdaftar. Silakan hubungi admin jika merasa ini kesalahan.',
            'nik.digits' => 'NIK harus terdiri dari 16 angka.',
            'email.unique' => 'Email ini sudah digunakan. Silakan gunakan email lain.',
            'pilihan_jurusan_2.different' => 'Pilihan Jurusan 2 tidak boleh sama dengan Pilihan Jurusan 1.'
        ]);

        // 2. Tentukan Biaya berdasarkan Jalur
        $nominalBiaya = ($request->jalur_pendaftaran === 'Reguler') ? 250000 : 0;
        $statusPembayaran = ($nominalBiaya == 0) ? 'Terverifikasi' : 'Belum Bayar';

        // 3. Generate Nomor Pendaftaran Otomatis
        $tahun = date('Y');
        $pendaftarTerakhir = DataPendaftar::whereYear('created_at', $tahun)->orderBy('id', 'desc')->first();
        
        $urutan = $pendaftarTerakhir ? ((int) substr($pendaftarTerakhir->no_pendaftaran, -4) + 1) : 1;
        $noPendaftaran = 'REG-' . $tahun . '-' . str_pad($urutan, 4, '0', STR_PAD_LEFT);

        // 4. Generate Password Acak 6 Karakter
        $rawPassword = Str::upper(Str::random(6));

        // 5. Simpan ke Database
        $pendaftar = DataPendaftar::create([
            'no_pendaftaran'    => $noPendaftaran,
            'jalur_pendaftaran' => $request->jalur_pendaftaran . ($request->spesifikasi_jalur ? ' - ' . $request->spesifikasi_jalur : ''),
            'nama_lengkap'      => $request->nama_lengkap,
            'nik'               => $request->nik,
            'no_whatsapp'       => $request->no_whatsapp,
            'email'             => $request->email,
            'pilihan_jurusan_1' => $request->pilihan_jurusan_1,
            'pilihan_jurusan_2' => $request->pilihan_jurusan_2,
            'alamat_rumah'      => $request->alamat_rumah,
            'password'          => Hash::make($rawPassword),
            'nominal_biaya'     => $nominalBiaya,
            'status_pembayaran' => $statusPembayaran,
            'status_pendaftaran' => 'Draft'
        ]);

        // 6. AUTO-LOGIN SESSIONS
        session([
            'pendaftar_id' => $pendaftar->id,
            'nama_pendaftar' => $pendaftar->nama_lengkap,
            'role' => 'user' 
        ]);

        // 7. LANGSUNG ARAHKAN KE TAHAP 2 (PEMBAYARAN)
        // Kita selipkan informasi password di session 'success' agar muncul di halaman pembayaran
        return redirect()->route('pembayaran.index')->with(
            'success', 
            "Pendaftaran Berhasil! Harap CATAT akses Anda untuk login berikutnya -> No. Pendaftaran: {$noPendaftaran} | Password: {$rawPassword}"
        );
    }

    private function kirimNotifikasiWA($nomor, $nama, $username, $password)
    {
        // Fitur ini bisa dikembangkan nanti menggunakan API (misal Fonnte / Wablas)
        $isiPesan = "Halo {$nama}, Pendaftaran SPMB Universitas Adzkia Berhasil. No Pendaftaran: {$username}, Password: {$password}";
        logger($isiPesan);
    }
}