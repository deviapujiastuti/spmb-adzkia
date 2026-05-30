<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataPendaftar;
use Carbon\Carbon;

class AdminPendaftarController extends Controller
{
// ==========================================
    // 1. DASHBOARD & STATISTIK ADMIN
    // ==========================================
    public function dashboard(Request $request)
    {
        // 1. Ambil filter dari request URL (Default: 'Bulan Ini')
        $filter = $request->query('filter', 'Bulan Ini');
        
        $query = \App\Models\DataPendaftar::query();
        $now = \Carbon\Carbon::now();

        // 2. Terapkan logika Filter Waktu pada Database
        if ($filter == 'Hari Ini') {
            $query->whereDate('created_at', $now->today());
        } elseif ($filter == 'Minggu Ini') {
            $query->whereBetween('created_at', [$now->startOfWeek(), $now->endOfWeek()]);
        } elseif ($filter == 'Bulan Ini') {
            $query->whereMonth('created_at', $now->month)
                  ->whereYear('created_at', $now->year);
        }

        // Ambil data yang sudah difilter
        $pendaftarFiltered = $query->get();

        // 3. Hitung Kartu Statistik (Berdasarkan Filter)
        $stats = [];
        $stats['totalPendaftar'] = $pendaftarFiltered->count();
        
        // Gabungan antara yang belum bayar & yang belum divalidasi berkasnya
        $stats['menungguValidasi'] = $pendaftarFiltered->whereIn('status_pembayaran', ['Menunggu Validasi'])->count() 
                                   + $pendaftarFiltered->whereIn('status_pendaftaran', ['menunggu verifikasi'])->count();
        
        // Hitung yang status kelulusannya mengandung kata 'Lulus'
        $stats['lulusSeleksi'] = $pendaftarFiltered->filter(function($item) {
            return str_contains($item->status_kelulusan, 'Lulus');
        })->count();

        // Hitung Pendapatan (Hanya ambil yang pembayarannya "Terverifikasi")
        $totalPendapatan = $pendaftarFiltered->where('status_pembayaran', 'Terverifikasi')->sum('nominal_biaya');
        // Dibagi 1 Juta karena di View desain Anda formatnya "Rp ... Jt"
        $stats['pendapatan'] = $totalPendapatan / 1000000; 

        // ==========================================
        // 4. Data untuk Grafik (Chart.js)
        // Grafik selalu mengambil data Tahun Ini agar grafiknya terlihat penuh
        // ==========================================
        $semuaPendaftarTahunIni = \App\Models\DataPendaftar::whereYear('created_at', $now->year)->get();

        $jurusanData = $semuaPendaftarTahunIni->groupBy('pilihan_jurusan_1')
            ->map(function ($row) { return $row->count(); })
            ->filter(function ($value, $key) { return !empty($key); });

        $labelsBulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
        $dataBulan = array_fill(0, 12, 0);
        
        $semuaPendaftarTahunIni->groupBy(function($date) {
            return \Carbon\Carbon::parse($date->created_at)->format('n'); // Ambil index bulan
        })->each(function ($item, $key) use (&$dataBulan) {
            $dataBulan[$key - 1] = $item->count();
        });

        // Lempar semua data ke View
        return view('admin.dashboard', compact('stats', 'filter', 'jurusanData', 'labelsBulan', 'dataBulan'));
    }

    // ==========================================
    // 2. EXPORT DATA EXCEL (CSV)
    // ==========================================
    public function exportCsv()
    {
        $pendaftar = \App\Models\DataPendaftar::orderBy('created_at', 'desc')->get();
        $filename = "Data_Pendaftar_Adzkia_" . date('Y-m-d') . ".csv";
        
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('ID', 'No Pendaftaran', 'Nama Lengkap', 'NIK', 'Jenis Kelamin', 'Pilihan 1', 'Pilihan 2', 'Jalur', 'Status Pembayaran', 'Status Kelulusan', 'Tanggal Daftar');

        $callback = function() use($pendaftar, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns); // Tulis Header kolom

            foreach ($pendaftar as $row) {
                fputcsv($file, array(
                    $row->id,
                    $row->no_pendaftaran,
                    $row->nama_lengkap,
                    $row->nik,
                    $row->gender,
                    $row->pilihan_jurusan_1,
                    $row->pilihan_jurusan_2,
                    $row->jalur_pendaftaran,
                    $row->status_pembayaran,
                    $row->status_kelulusan ?? 'Belum Ditetapkan',
                    Carbon::parse($row->created_at)->format('d-M-Y')
                ));
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    public function index()
    {
        $users = DataPendaftar::latest()->get(); 
        $totalPendaftar   = DataPendaftar::count();
        $menungguValidasi = DataPendaftar::where('status_pembayaran', 'Menunggu Validasi')->count();
        $lulusSeleksi     = DataPendaftar::where('status_pembayaran', 'Terverifikasi')->count();
        $pembayaranBelum  = DataPendaftar::where('status_pembayaran', 'Belum Bayar')->count();

        return view('admin.pendaftar', compact('users', 'totalPendaftar', 'menungguValidasi', 'lulusSeleksi', 'pembayaranBelum'));
    }
    
    // ==========================================
    // VALIDASI PEMBAYARAN (KEUANGAN)
    // ==========================================
    public function validasiPembayaranIndex(Request $request)
    {
        $query = DataPendaftar::query();

        if ($request->filled('jalur') && $request->jalur != 'Semua Jalur') {
            $query->where('jalur_pendaftaran', $request->jalur);
        }

        if ($request->filled('status')) {
            $query->where('status_pembayaran', $request->status);
        } else {
            $query->whereIn('status_pembayaran', ['Belum Bayar', 'Menunggu Validasi']);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
            });
        }

        $pendaftarPending = $query->latest()->get();

        foreach ($pendaftarPending as $data) {
            $tanggalDaftar = $data->created_at ?? now();
            if ($tanggalDaftar->between('2026-01-01', '2026-03-31')) $gelombang = 'Gelombang 1';
            elseif ($tanggalDaftar->between('2026-04-01', '2026-06-30')) $gelombang = 'Gelombang 2';
            else $gelombang = 'Gelombang 3';

            $data->jalur_lengkap = $data->jalur_pendaftaran . ' ' . $gelombang;
            $data->bank_pilihan = $data->metode_pembayaran ?? 'Belum Dipilih'; 
            $data->nominal_biaya = $data->nominal_biaya ?? 250000;
        }

        return view('admin.validasi-pembayaran', compact('pendaftarPending'));
    }

// Fungsi untuk menyetujui (Sudah ada di controller Anda, pastikan sesuai)
    public function setujuiPembayaran($id)
    {
        $pendaftar = DataPendaftar::findOrFail($id);
        $pendaftar->status_pembayaran = 'Terverifikasi';
        $pendaftar->save();

        return redirect()->back()->with('success', 'Pembayaran atas nama ' . $pendaftar->nama_lengkap . ' berhasil diverifikasi.');
    }

    // Fungsi BARU untuk menolak
    public function tolakPembayaran($id)
    {
        $pendaftar = DataPendaftar::findOrFail($id);
        // Kembalikan statusnya ke awal agar mereka bisa memilih bank dan unggah ulang
        $pendaftar->status_pembayaran = 'Belum Bayar'; 
        // Hapus file lama yang tidak valid (Opsional)
        if ($pendaftar->bukti_bayar) {
            \Illuminate\Support\Facades\Storage::delete('public/' . $pendaftar->bukti_bayar);
            $pendaftar->bukti_bayar = null;
        }
        $pendaftar->save();

        return redirect()->back()->with('error', 'Pembayaran ditolak. Pendaftar telah diminta mengunggah ulang bukti pembayaran.');
    }

    // ==========================================
    // VALIDASI BIODATA (AKADEMIK / VERIFIKATOR)
    // ==========================================
    public function daftarUlangIndex()
    {
        $pendaftarDaftarUlang = DataPendaftar::where('status_pembayaran', 'Terverifikasi')
                                ->whereIn('status_pendaftaran', ['menunggu verifikasi', 'Selesai', 'Revisi'])  
                                ->latest()
                                ->get();

        return view('admin.validasi-daftar-ulang', compact('pendaftarDaftarUlang'));
    }

    public function setujuiDaftarUlang($id)
    {
        $pendaftar = DataPendaftar::findOrFail($id);
        $pendaftar->status_pendaftaran = 'Selesai';
        $pendaftar->save();

        return redirect()->back()->with('success', 'Berkas pendaftar telah diverifikasi.');
    }

    public function revisiDaftarUlang(Request $request, $id)
    {
        $request->validate(['pesan_revisi' => 'required|string']);
        $pendaftar = DataPendaftar::findOrFail($id);
        $pendaftar->update([
            'status_pendaftaran' => 'Revisi',
            'pesan_revisi'       => $request->pesan_revisi
        ]);
        return back()->with('success', 'Pesan revisi berhasil dikirim ke pendaftar.');
    }

    // ==========================================
    // PENGUMUMAN KELULUSAN
    // ==========================================
    // ==========================================
    // MODUL PENGUMUMAN KELULUSAN
    // ==========================================
    public function pengumumanIndex(Request $request)
    {
        $query = DataPendaftar::whereIn('status_pendaftaran', ['Selesai', 'Terverifikasi', 'menunggu verifikasi']);
        
        if ($request->has('search')) {
            $query->where('nama_lengkap', 'like', '%' . $request->search . '%')
                  ->orWhere('no_pendaftaran', 'like', '%' . $request->search . '%');
        }

        $pendaftar = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // PASTIKAN BARIS INI MEMANGGIL 'admin.pengumuman' 
        // BUKAN 'admin.pengumuman-kelulusan'
        return view('admin.pengumuman', compact('pendaftar'));
    }

    public function tetapkanKelulusan(Request $request, $id)
    {
        $pendaftar = DataPendaftar::findOrFail($id);
        
        // Value dari form: 'Lulus Pilihan 1', 'Lulus Pilihan 2', atau 'Tidak Lulus'
        $pendaftar->status_kelulusan = $request->status_kelulusan;
        $pendaftar->save();

        return redirect()->back()->with('success', 'Status kelulusan atas nama ' . $pendaftar->nama_lengkap . ' berhasil ditetapkan.');
    }

public function updateKelulusan(Request $request, $id)
    {
        // Validasi disesuaikan dengan 3 opsi baru
        $request->validate([
            'status_kelulusan' => 'required|in:Lulus Pilihan 1,Lulus Pilihan 2,Tidak Lulus'
        ]);
        
        $pendaftar = DataPendaftar::findOrFail($id);
        $pendaftar->status_kelulusan = $request->status_kelulusan;
        $pendaftar->save();
        
        return redirect()->back()->with('success', 'Status kelulusan berhasil diperbarui!');
    }   
}