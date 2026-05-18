<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\DataPendaftar; 
use Carbon\Carbon;

class AdminPendaftarController extends Controller
{
    /**
     * Dashboard Utama Admin dengan Filter Waktu
     */
    public function dashboard(Request $request)
    {
        $filter = $request->get('filter', 'Bulan Ini');
        $now = Carbon::now();

        // Query Dasar
        $query = DataPendaftar::query();

        // Logika Filter Waktu
        if ($filter == 'Hari Ini') {
            $query->whereDate('created_at', Carbon::today());
        } elseif ($filter == 'Minggu Ini') {
            $query->whereBetween('created_at', [
                $now->startOfWeek()->format('Y-m-d'), 
                $now->endOfWeek()->format('Y-m-d')
            ]);
        } else {
            $query->whereMonth('created_at', $now->month)
                  ->whereYear('created_at', $now->year);
        }

        // Ambil Statistik Berdasarkan Filter
        $stats = [
            'totalPendaftar'   => (clone $query)->count(),
            'menungguValidasi' => (clone $query)->where('status', 'Validasi')->count(),
            'lulusSeleksi'     => (clone $query)->where('status', 'Terverifikasi')->count(),
            // Pendapatan: misal 250rb per orang yang lulus seleksi
            'pendapatan'       => ((clone $query)->where('status', 'Terverifikasi')->count() * 250000) / 1000000, 
        ];

        return view('admin.dashboard', compact('stats', 'filter'));
    }

    /**
     * List Semua Pendaftar
     */
    public function index()
    {
        $users = DataPendaftar::with('user')->get(); 
        $totalPendaftar = DataPendaftar::count();
        $menungguValidasi = DataPendaftar::where('status', 'Validasi')->count();
        $lulusSeleksi = DataPendaftar::where('status', 'Terverifikasi')->count();
        $pembayaranBelum = DataPendaftar::where('status', 'Belum Bayar')->count();

        return view('admin.pendaftar', compact('users', 'totalPendaftar', 'menungguValidasi', 'lulusSeleksi', 'pembayaranBelum'));
    }

    /**
     * Halaman Validasi Pembayaran
     */
    public function validasiPembayaranIndex(Request $request)
    {
        $query = DataPendaftar::with('user');

        if ($request->filled('jalur') && $request->jalur != 'Semua Jalur') {
            $query->where('jalur', $request->jalur);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'Belum Bayar');
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($u) use ($search) {
                    $u->where('name', 'like', "%{$search}%");
                })->orWhere('id', 'like', "%{$search}%");
            });
        }

        $pendaftarPending = $query->latest()->get();
        return view('admin.validasi-pembayaran', compact('pendaftarPending'));
    }

    public function setujuiPembayaran($id)
    {
        $pendaftar = DataPendaftar::findOrFail($id);
        $pendaftar->status = 'Terverifikasi';
        $pendaftar->save();
        return redirect()->back()->with('success', 'Pembayaran Berhasil Divalidasi!');
    }

    /**
     * Halaman Validasi Daftar Ulang
     */
    public function daftarUlangIndex()
    {
        $antrian = DataPendaftar::with('user')->where('status', 'Terverifikasi')->get();
        return view('admin.validasi-daftar-ulang', compact('antrian'));
    }

    public function setujuiDaftarUlang($id)
    {
        $pendaftar = DataPendaftar::findOrFail($id);
        $pendaftar->status = 'Verified'; 
        $pendaftar->save();
        return redirect()->back()->with('success', 'Daftar Ulang Berhasil Diverifikasi!');
    }

    /**
     * Halaman Pengumuman Kelulusan
     */
    public function pengumumanIndex(Request $request)
    {
        // Ambil pendaftar yang sudah bayar/verifikasi untuk ditentukan kelulusannya
        $pengumuman = DataPendaftar::with('user')->get();
        return view('admin.pengumuman', compact('pengumuman'));
    }

    public function updateKelulusan(Request $request, $id)
    {
        $request->validate([
            'status_kelulusan' => 'required|in:Lulus,Tidak Lulus'
        ]);

        $pendaftar = DataPendaftar::findOrFail($id);
        $pendaftar->status_kelulusan = $request->status_kelulusan;
        $pendaftar->save();

        return redirect()->back()->with('success', 'Status berhasil diperbarui!');
    }
}