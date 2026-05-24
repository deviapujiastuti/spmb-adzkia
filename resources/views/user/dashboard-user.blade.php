@extends('layouts.app')

@section('title', 'Dashboard Pendaftar - SPMB Adzkia')

@section('content')
<main class="max-w-4xl mx-auto px-6 py-16">
    
    <div class="mb-12">
        <h1 class="text-3xl font-black text-adzkia-blue tracking-tight mb-2">Halo, {{ $pendaftar->nama_lengkap ?? 'Calon Mahasiswa' }}!</h1>
        <p class="text-adzkia-muted font-medium">Selamat datang di portal pendaftaran Universitas Adzkia. Mari selesaikan tahapan pendaftaran Anda.</p>
    </div>

    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-1">Status Pendaftaran Anda</p>
            <h2 class="text-xl font-extrabold text-adzkia-blue">{{ $pendaftar->status_pendaftaran ?? 'Pendaftaran Baru' }}</h2>
        </div>
        
        @if($pendaftar->status_pendaftaran == 'Draf')
            <div class="flex items-center gap-4">
                <div class="text-right hidden md:block">
                    <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest">Progress</p>
                    <p class="text-sm font-extrabold text-adzkia-dark">Tahap Biodata</p>
                </div>
                <a href="{{ route('pendaftaran.biodata', $pendaftar->id) }}" 
                   class="px-8 py-4 bg-adzkia-red text-white font-black rounded-2xl hover:bg-red-700 shadow-lg shadow-red-600/20 transition-all active:scale-[0.98]">
                    Lanjutkan Pendaftaran &rarr;
                </a>
            </div>
        @elseif($pendaftar->status_pendaftaran == 'Menunggu Validasi')
            <div class="px-6 py-3 bg-amber-50 text-amber-700 font-bold rounded-xl text-sm border border-amber-200">
                Data sedang diverifikasi oleh admin.
            </div>
        @else
            <div class="px-6 py-3 bg-green-50 text-green-700 font-bold rounded-xl text-sm border border-green-200">
                Pendaftaran Selesai.
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="p-6 bg-white rounded-2xl border border-gray-100 shadow-sm">
            <i data-feather="book" class="w-6 h-6 text-adzkia-blue mb-4"></i>
            <h4 class="font-bold text-sm text-adzkia-dark mb-1">Prodi Pilihan</h4>
            <p class="text-sm text-adzkia-muted font-medium">{{ $pendaftar->pilihan_jurusan_1 ?? '-' }}</p>
        </div>
        <div class="p-6 bg-white rounded-2xl border border-gray-100 shadow-sm">
            <i data-feather="calendar" class="w-6 h-6 text-adzkia-blue mb-4"></i>
            <h4 class="font-bold text-sm text-adzkia-dark mb-1">Jalur Masuk</h4>
            <p class="text-sm text-adzkia-muted font-medium">{{ $pendaftar->jalur_pendaftaran ?? '-' }}</p>
        </div>
        <div class="p-6 bg-white rounded-2xl border border-gray-100 shadow-sm">
            <i data-feather="shield" class="w-6 h-6 text-adzkia-blue mb-4"></i>
            <h4 class="font-bold text-sm text-adzkia-dark mb-1">ID Pendaftaran</h4>
            <p class="text-sm text-adzkia-muted font-medium">#{{ $pendaftar->id_pendaftaran ?? 'Pending' }}</p>
        </div>
    </div>

</main>
@endsection