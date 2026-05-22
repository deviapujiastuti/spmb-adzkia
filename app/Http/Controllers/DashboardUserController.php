<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataPendaftar;
use App\Models\MetodePembayaran; 
use Carbon\Carbon;
use App\Models\Prodi;

class DashboardUserController extends Controller
{
    public function index() // <--- Pastikan namanya 'index'
    {
        $pendaftarId = session('pendaftar_id');

        if (!$pendaftarId) {
            return redirect('/login')->withErrors(['error' => 'Silakan login terlebih dahulu!']);
        }

        $mahasiswa = DataPendaftar::with('prodi1')->find($pendaftarId);

        if (!$mahasiswa) {
            return redirect('/login')->withErrors(['error' => 'Data pendaftar tidak ditemukan!']);
        }

        // Ambil data dari table metode_pembayaran
        $semuaMetode = MetodePembayaran::where('is_active', true)->get();

        // Filter perkategori
        $bankTransfer   = $semuaMetode->where('kategori', 'Bank Transfer');
        $virtualAccount = $semuaMetode->where('kategori', 'Virtual Account');
        $eWallet        = $semuaMetode->where('kategori', 'E-Wallet');
        
        $batasWaktu = now()->addDays(1)->format('M d, Y (23:59 \W\I\B)');

        // Kirim kelimanya ke Blade
        return view('user.pembayaran', compact(
            'mahasiswa', 
            'bankTransfer', 
            'virtualAccount', 
            'eWallet', 
            'batasWaktu'
        ));
    }

    public function pembayaranIndex()
    {
        // 1. Data Virtual Account (Dummy untuk sementara agar tidak error)
        $virtualAccount = [
            (object)['nama_provider' => 'MANDIRI', 'nama_bank_lengkap' => 'Bank Mandiri', 'nomor_tujuan' => '1234567890', 'atas_nama' => 'Universitas Adzkia'],
            (object)['nama_provider' => 'BCA', 'nama_bank_lengkap' => 'Bank BCA', 'nomor_tujuan' => '0987654321', 'atas_nama' => 'Universitas Adzkia'],
        ];

        // 2. Data Bank Transfer (INI YANG KAMU CARI - HARUS ADA)
        $bankTransfer = [
            (object)['nama_provider' => 'BCA_MANUAL', 'nama_bank_lengkap' => 'BCA (Transfer Manual)', 'nomor_tujuan' => '0987654321', 'atas_nama' => 'Universitas Adzkia'],
            (object)['nama_provider' => 'BNI_MANUAL', 'nama_bank_lengkap' => 'BNI (Transfer Manual)', 'nomor_tujuan' => '1122334455', 'atas_nama' => 'Universitas Adzkia'],
        ];

        // 3. Batas Waktu
        $batasWaktu = Carbon::now()->addDays(1)->format('d F Y, H:i');

        // 4. KIRIM SEMUA KE VIEW
        return view('user.pembayaran', compact('virtualAccount', 'bankTransfer', 'batasWaktu'));
    }

    // Di DashboardUserController.php (fungsi simpan pembayaran)
public function prosesPembayaran(Request $request)
{
    $pendaftar = \App\Models\DataPendaftar::where('user_id', session('user_id'))->first();
    
    // Simpan metode pembayaran yang dipilih user
    $user->update([
        'metode_pembayaran' => $request->metode_pembayaran, // Misal: Mandiri/BCA
        'nominal_biaya'     => 250000, // Sesuaikan dengan biaya yang ditentukan
        'status_pembayaran' => 'Validasi', // Mengubah status agar muncul di admin
    ]);

    return redirect()->route('dashboard.user')->with('success', 'Pembayaran diproses!');
}

public function dashboardUser()
{
    $pendaftar = \App\Models\DataPendaftar::find(session('pendaftar_id'));

    // Pengecekan Kunci:
    if ($pendaftar->status_pembayaran !== 'Terverifikasi') {
        return redirect()->route('pendaftaran.validasi')
                         ->with('error', 'Mohon tunggu verifikasi pembayaran oleh admin.');
    }

    return view('user.dashboard');
}

public function validasiUser()
{
    // Gunakan 'id' bukan 'user_id' karena database kamu belum punya kolom user_id
    $pendaftar = \App\Models\DataPendaftar::find(session('pendaftar_id'));

    if (!$pendaftar) {
        return redirect()->route('login')->withErrors(['error' => 'Silakan login kembali.']);
    }

    return view('user.validasi-pembayaran', compact('pendaftar'));
}

public function prosesUploadBukti(Request $request)
{
    $request->validate(['bukti_bayar' => 'required|image|mimes:jpeg,png,jpg|max:2048']);
    
    $pendaftar = \App\Models\DataPendaftar::find(session('pendaftar_id'));
    
    // Simpan file
    $path = $request->file('bukti_bayar')->store('bukti_pembayaran', 'public');
    
    // Update status agar admin bisa melihatnya di halaman validasi
    $pendaftar->update([
        'bukti_bayar' => $path,
        'status_pembayaran' => 'Menunggu Validasi' // Status ini yang akan dibaca admin
    ]);

    return redirect()->route('pendaftaran.validasi')->with('success', 'Bukti berhasil diunggah!');
}

public function showBiodata()
{
    // Ambil data pendaftar yang login
    $pendaftar = \App\Models\DataPendaftar::find(session('pendaftar_id'));

    // KUNCI: Jika status belum Terverifikasi, tendang balik ke halaman validasi
    if ($pendaftar->status_pembayaran !== 'Terverifikasi') {
        return redirect()->route('pendaftaran.validasi')
                         ->with('error', 'Mohon tunggu verifikasi pembayaran oleh admin sebelum melanjutkan.');
    }

    return view('user.biodata');
}
// DashboardUserController.php

public function biodataIndex()
{
    // 1. Ambil ID dari session yang benar ('pendaftar_id' sesuai kode login kamu)
    $pendaftarId = session('pendaftar_id');

    // 2. Ambil data pendaftar berdasarkan ID tersebut
    $pendaftar = \App\Models\DataPendaftar::find($pendaftarId);

    // 3. Debugging untuk memastikan data terambil
    if (!$pendaftar) {
        dd("Session 'pendaftar_id' tidak ditemukan atau data tidak ada di database. ID Session: " . $pendaftarId);
    }

    // 4. Cek status pembayaran (menggunakan strtolower agar tidak case-sensitive)
    if (strtolower($pendaftar->status_pembayaran) !== 'terverifikasi') {
        return redirect()->route('pembayaran.index')
                         ->with('error', 'Status pembayaran belum terverifikasi.');
    }

    // 5. Jika lolos, ambil data prodi dan tampilkan view
    $prodis = \App\Models\Prodi ::all(); 
    return view('user.formulir', compact('pendaftar', 'prodis')); 
}
}