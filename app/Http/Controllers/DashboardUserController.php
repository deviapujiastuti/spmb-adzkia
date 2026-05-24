<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataPendaftar;
use App\Models\MetodePembayaran; 
use Carbon\Carbon;
use App\Models\Prodi;
use App\Models\Pendaftar;
use Illuminate\Support\Facades\Auth;

class DashboardUserController extends Controller
{
    public function index() 
    {
        $pendaftarId = session('pendaftar_id');

        if (!$pendaftarId) {
            return redirect('/login')->withErrors(['error' => 'Silakan login terlebih dahulu!']);
        }

        $mahasiswa = DataPendaftar::with('prodi1')->find($pendaftarId);

        if (!$mahasiswa) {
            return redirect('/login')->withErrors(['error' => 'Data pendaftar tidak ditemukan!']);
        }

        $semuaMetode = MetodePembayaran::where('is_active', true)->get();

        $bankTransfer   = $semuaMetode->where('kategori', 'Bank Transfer');
        $virtualAccount = $semuaMetode->where('kategori', 'Virtual Account');
        $eWallet        = $semuaMetode->where('kategori', 'E-Wallet');
        
        $batasWaktu = now()->addDays(1)->format('M d, Y (23:59 \W\I\B)');

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
        $virtualAccount = [
            (object)['nama_provider' => 'MANDIRI', 'nama_bank_lengkap' => 'Bank Mandiri', 'nomor_tujuan' => '1234567890', 'atas_nama' => 'Universitas Adzkia'],
            (object)['nama_provider' => 'BCA', 'nama_bank_lengkap' => 'Bank BCA', 'nomor_tujuan' => '0987654321', 'atas_nama' => 'Universitas Adzkia'],
        ];

        $bankTransfer = [
            (object)['nama_provider' => 'BCA_MANUAL', 'nama_bank_lengkap' => 'BCA (Transfer Manual)', 'nomor_tujuan' => '0987654321', 'atas_nama' => 'Universitas Adzkia'],
            (object)['nama_provider' => 'BNI_MANUAL', 'nama_bank_lengkap' => 'BNI (Transfer Manual)', 'nomor_tujuan' => '1122334455', 'atas_nama' => 'Universitas Adzkia'],
        ];

        $batasWaktu = Carbon::now()->addDays(1)->format('d F Y, H:i');

        return view('user.pembayaran', compact('virtualAccount', 'bankTransfer', 'batasWaktu'));
    }

    public function prosesPembayaran(Request $request)
    {
        $pendaftar = \App\Models\DataPendaftar::where('user_id', session('user_id'))->first();
        
        $pendaftar->update([
            'metode_pembayaran' => $request->metode_pembayaran, 
            'nominal_biaya'     => 250000, 
            'status_pembayaran' => 'Validasi', 
        ]);

        return redirect()->route('dashboard.user')->with('success', 'Pembayaran diproses!');
    }

    public function prosesValidasi(Request $request)
    {
        $request->validate([
            'pendaftar_id' => 'required|exists:data_pendaftars,id',
        ]);

        $pendaftar = \App\Models\DataPendaftar::find($request->pendaftar_id);
        
        if ($pendaftar) {
            $pendaftar->update([
                'status_pembayaran' => 'Terverifikasi'
            ]);

            return back()->with('success', 'Pembayaran berhasil diverifikasi!');
        }

        return back()->with('error', 'Data tidak ditemukan.');
    }

    public function dashboardUser()
    {
        $pendaftar = \App\Models\DataPendaftar::find(session('pendaftar_id'));

        if ($pendaftar->status_pembayaran !== 'Terverifikasi') {
            return redirect()->route('pendaftaran.validasi')
                             ->with('error', 'Mohon tunggu verifikasi pembayaran oleh admin.');
        }

        return view('user.dashboard');
    }

    public function validasiUser()
    {
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
        
        $path = $request->file('bukti_bayar')->store('bukti_pembayaran', 'public');
        
        $pendaftar->update([
            'bukti_bayar' => $path,
            'status_pembayaran' => 'Menunggu Validasi'
        ]);

        return redirect()->route('pendaftaran.validasi')->with('success', 'Bukti berhasil diunggah!');
    }

    public function showBiodata()
    {
        $pendaftar = \App\Models\DataPendaftar::find(session('pendaftar_id'));

        if ($pendaftar->status_pembayaran !== 'Terverifikasi') {
            return redirect()->route('pendaftaran.validasi')
                             ->with('error', 'Mohon tunggu verifikasi pembayaran oleh admin sebelum melanjutkan.');
        }

        return view('user.biodata');
    }

    public function biodataIndex()
    {
        $pendaftarId = session('pendaftar_id');
        $pendaftar = \App\Models\DataPendaftar::find($pendaftarId);

        if (!$pendaftar) {
            dd("Session 'pendaftar_id' tidak ditemukan atau data tidak ada di database. ID Session: " . $pendaftarId);
        }

        if (strtolower($pendaftar->status_pembayaran) !== 'terverifikasi') {
            return redirect()->route('pembayaran.index')
                             ->with('error', 'Status pembayaran belum terverifikasi.');
        }

        $prodis = \App\Models\Prodi::all(); 
        return view('user.formulir', compact('pendaftar', 'prodis')); 
    }

    public function simpanBiodata(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik'          => 'required|string|max:20',
            'gender'       => 'required',
            'prodi_id'     => 'required',
            'pas_foto'     => 'required|file|image|max:2048',
            'scan_ktp'     => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'ijazah_skl'   => 'required|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $pathFoto   = $request->file('pas_foto')->store('dokumen/foto', 'public');
        $pathKtp    = $request->file('scan_ktp')->store('dokumen/ktp', 'public');
        $pathIjazah = $request->file('ijazah_skl')->store('dokumen/ijazah', 'public');

        \App\Models\DataPendaftar::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'nama_lengkap' => $request->nama_lengkap,
                'nik'          => $request->nik,
                'gender'       => $request->gender,
                'prodi_id'     => $request->prodi_id,
                'pas_foto'     => $pathFoto,
                'scan_ktp'     => $pathKtp,
                'ijazah_skl'   => $pathIjazah,
            ]
        );

        return redirect()->route('konfirmasi-data', $request->id)->with('success', 'Biodata berhasil disimpan!');
    }

    public function showVerifikasi($id)
    {
        $pendaftar = \App\Models\DataPendaftar::findOrFail($id);
        return view('admin.verifikasi', compact('pendaftar'));
    }

    public function tampilkanKonfirmasi($id)
    {
        $pendaftar = \App\Models\DataPendaftar::findOrFail($id);

        if (!$pendaftar) {
            return redirect()->route('formulir-biodata')->with('error', 'Silakan lengkapi biodata terlebih dahulu.');
        }

        return view('user.konfirmasi-data', compact('pendaftar'));
    }

    public function editBiodata()
    {
        $pendaftar = \App\Models\DataPendaftar::where('user_id', auth()->id())->firstOrFail();
        return view('user.edit-biodata', compact('pendaftar'));
    }

    public function edit()
    {
        $pendaftar = \App\Models\DataPendaftar::where('user_id', auth()->id())->first();
        return view('user.formulir-biodata', compact('pendaftar'));
    }

    public function update(Request $request, $id)
    {
        $pendaftar = \App\Models\DataPendaftar::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required',
            'nik'          => 'required|unique:data_pendaftars,nik,' . $pendaftar->id, 
        ]);

        $pendaftar->update($request->all());

        return redirect()->route('konfirmasi-data', ['id' => $pendaftar->id])
                         ->with('success', 'Data berhasil diperbarui!');
    } 

    public function updateBiodata(Request $request, $id)
    {
        $pendaftar = \App\Models\DataPendaftar::findOrFail($id);
        $pendaftar->update($request->all());
        return redirect()->back()->with('success', 'Data diperbarui');
    }

    public function tampilkanValidasiAkhir($id)
    {
        $pendaftar = \App\Models\DataPendaftar::findOrFail($id);
        return view('user.validasi-akhir', compact('pendaftar'));
    }

    public function prosesKonfirmasi($id)
    {
        $pendaftar = \App\Models\DataPendaftar::findOrFail($id);
        $pendaftar->status_pendaftaran = 'menunggu verifikasi'; 
        $pendaftar->save();

        return redirect()->route('pendaftaran.validasiakhir', ['id' => $id]);
    }

    public function tampilkanSukses()
    {
        $pendaftar = \App\Models\DataPendaftar::where('user_id', auth()->id())->first();

        if (!$pendaftar) {
            return redirect()->route('dashboard')->with('error', 'Data pendaftaran tidak ditemukan.');
        }
        
        return view('user.sukses', compact('pendaftar'));
    }
}