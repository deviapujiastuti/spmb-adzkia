@extends('layouts.admin')

@section('admin-content')
<div>
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-brand-dark tracking-tight mb-2">
                Selamat Datang, Admin! <span class="text-2xl">👋</span>
            </h1>
            <p class="text-brand-gray text-[14px] font-medium">
                Ringkasan aktivitas pendaftaran berdasarkan: <span class="text-brand-blue font-bold">{{ $filter }}</span>
            </p>
        </div>
        
        <div class="bg-white border border-gray-100 p-1.5 rounded-xl flex items-center shadow-sm">
            @foreach(['Hari Ini', 'Minggu Ini', 'Bulan Ini'] as $f)
                <a href="{{ route('admin.dashboard', ['filter' => $f]) }}" 
                   class="px-5 py-2.5 rounded-lg text-[12px] font-black tracking-wide transition-all {{ $filter == $f ? 'bg-brand-blue text-white shadow-md' : 'text-gray-500 hover:text-brand-dark hover:bg-gray-50' }}">
                    {{ $f }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm hover:-translate-y-1 transition-transform group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-brand-blue flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i data-feather="users" class="w-6 h-6"></i>
                </div>
            </div>
            <p class="text-[11px] font-extrabold text-gray-400 uppercase tracking-widest mb-1">Total Pendaftar</p>
            <h3 class="text-3xl font-black text-brand-dark">{{ number_format($stats['totalPendaftar']) }}</h3>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm hover:-translate-y-1 transition-transform group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i data-feather="clock" class="w-6 h-6"></i>
                </div>
            </div>
            <p class="text-[11px] font-extrabold text-gray-400 uppercase tracking-widest mb-1">Menunggu Validasi</p>
            <h3 class="text-3xl font-black text-brand-dark">{{ number_format($stats['menungguValidasi']) }}</h3>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm hover:-translate-y-1 transition-transform group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i data-feather="check-circle" class="w-6 h-6"></i>
                </div>
            </div>
            <p class="text-[11px] font-extrabold text-gray-400 uppercase tracking-widest mb-1">Lulus Seleksi</p>
            <h3 class="text-3xl font-black text-brand-dark">{{ number_format($stats['lulusSeleksi']) }}</h3>
        </div>

        <div class="bg-brand-dark p-6 rounded-[2rem] shadow-xl hover:-translate-y-1 transition-transform relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 opacity-10 text-white transform group-hover:scale-110 transition-transform">
                <i data-feather="dollar-sign" class="w-32 h-32"></i>
            </div>
            <div class="relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-white/10 text-white flex items-center justify-center mb-4 backdrop-blur-sm">
                    <i data-feather="credit-card" class="w-6 h-6"></i>
                </div>
                <p class="text-[11px] font-extrabold text-gray-400 uppercase tracking-widest mb-1">Pendapatan Formulir</p>
                <h3 class="text-3xl font-black text-white">Rp {{ number_format($stats['pendapatan'], 1) }} Jt</h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-8">
        <div class="lg:col-span-8 bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 flex flex-col">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h3 class="text-[16px] font-extrabold text-brand-dark">Statistik Pendaftaran</h3>
                    <p class="text-[12px] font-medium text-gray-400 mt-1">Grafik masuknya pendaftar (Visualisasi Data).</p>
                </div>
            </div>
            
            <div class="flex-1 flex items-end gap-3 md:gap-6 h-48 mt-auto">
                @php
                    // Contoh data bar statis, kamu bisa buat dinamis nanti
                    $bars = [
                        ['l' => 'Mgg 1', 'h' => 40], ['l' => 'Mgg 2', 'h' => 70],
                        ['l' => 'Mgg 3', 'h' => 100], ['l' => 'Mgg 4', 'h' => 60]
                    ];
                @endphp
                @foreach($bars as $bar)
                    <div class="flex flex-col items-center flex-1 group">
                        <div class="w-full bg-brand-blue-light rounded-t-xl relative overflow-hidden transition-all duration-500" style="height: {{ $bar['h'] }}%;">
                            <div class="absolute bottom-0 w-full bg-brand-blue rounded-t-xl transition-all duration-700 h-3/4"></div>
                        </div>
                        <span class="text-[10px] font-black text-gray-400 mt-3 uppercase">{{ $bar['l'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 h-full">
                <h3 class="text-[16px] font-extrabold text-brand-dark mb-6">Aksi Cepat</h3>
                <div class="space-y-4">
                    <a href="/admin/validasi-pembayaran" class="flex items-center gap-4 p-4 rounded-2xl bg-gray-50 border border-gray-100 hover:border-brand-blue hover:bg-white transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-white text-brand-dark shadow-sm flex items-center justify-center group-hover:bg-brand-blue-light group-hover:text-brand-blue transition-colors">
                            <i data-feather="check-square" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <p class="text-[13px] font-black text-brand-dark group-hover:text-brand-blue transition-colors">Validasi Pembayaran</p>
                            <p class="text-[11px] font-medium text-gray-400">Cek pendaftar baru</p>
                        </div>
                    </a>
                    
                    <a href="/admin/pengumuman" class="flex items-center gap-4 p-4 rounded-2xl bg-gray-50 border border-gray-100 hover:border-brand-blue hover:bg-white transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-white text-brand-dark shadow-sm flex items-center justify-center group-hover:bg-brand-blue-light group-hover:text-brand-blue transition-colors">
                            <i data-feather="volume-2" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <p class="text-[13px] font-black text-brand-dark group-hover:text-brand-blue transition-colors">Buat Pengumuman</p>
                            <p class="text-[11px] font-medium text-gray-400">Publikasi kelulusan</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection