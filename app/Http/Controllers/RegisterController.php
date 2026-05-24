<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataPendaftar;
use App\Models\Prodi;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function showRegister()
    {
        $prodiList = \App\Models\Prodi::all(); 
        return view('user.register', compact('prodiList'));
    }

    public function storeRegister(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik'          => 'required|numeric|digits:16|unique:data_pendaftars,nik',
            'no_whatsapp'  => 'required|numeric',
            'email'        => 'required|email|unique:data_pendaftars,email',
            'pilihan_jurusan_1' => 'required',
            'pilihan_jurusan_2' => 'required|different:pilihan_jurusan_1',
            'alamat_rumah'      => 'required|string',
        ]);

        $tahun = date('Y');
        $jumlahReguler = DataPendaftar::where('jalur_pendaftaran', 'Reguler')->count() + 1;
        $noPendaftaran = 'REG-' . $tahun . '-' . str_pad($jumlahReguler, 4, '0', STR_PAD_LEFT);
        $rawPassword = Str::random(6);

        $pendaftar = DataPendaftar::create([
            'no_pendaftaran'    => $noPendaftaran,
            'jalur_pendaftaran' => 'Reguler',
            'nama_lengkap'      => $request->nama_lengkap,
            'nik'               => $request->nik,
            'no_whatsapp'       => $request->no_whatsapp,
            'email'             => $request->email,
            'pilihan_jurusan_1' => $request->pilihan_jurusan_1,
            'pilihan_jurusan_2' => $request->pilihan_jurusan_2,
            'alamat_rumah'      => $request->alamat_rumah,
            'password'          => Hash::make($rawPassword),
            'nominal_biaya'     => 250000,
            'status_pembayaran' => 'Belum Bayar',
        ]);

        $this->kirimNotifikasiWA($pendaftar->no_whatsapp, $pendaftar->nama_lengkap, $noPendaftaran, $rawPassword);
        
        return redirect()->route('login')->with([
            'success' => 'Pendaftaran Berhasil!',
            'no_pendaftaran' => $noPendaftaran,
            'password'       => $rawPassword
        ]);
    }

 public function loginProses(Request $request)
    {
        $request->validate([
            'login_input' => 'required',
            'password'    => 'required',
        ]);

        $pendaftar = DataPendaftar::where('email', $request->login_input)
            ->orWhere('no_pendaftaran', $request->login_input)
            ->first();

        if ($pendaftar && Hash::check($request->password, $pendaftar->password)) {
             session()->put('pendaftar_id', $pendaftar->id); 
             session()->put('nama_pendaftar', $pendaftar->nama_lengkap);
             
             // KUNCI PERBAIKAN: Selalu arahkan ke hub dashboard utama terlebih dahulu
             return redirect()->route('dashboard.user');
        }

        return back()->withErrors(['login_error' => 'Email/No. Pendaftaran atau Password salah.'])->onlyInput('login_input');
    }

    public function logout()
    {
        session()->forget(['pendaftar_id', 'nama_pendaftar']);
        return redirect()->route('login');
    }

    private function kirimNotifikasiWA($nomor, $nama, $username, $password)
    {
        $isiPesan = "Halo {$nama}, akun anda: {$username} Pass: {$password}";
        logger($isiPesan);
    }
}