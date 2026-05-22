@extends('layouts.admin')

@section('admin-content')

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-[#0B1C39] tracking-tight mb-2">Data Pendaftar</h1>
            <p class="text-brand-gray text-[14px] font-medium">
                Kelola seluruh data pendaftar dan pantau status admisi secara real-time.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <button class="flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 text-brand-dark rounded-xl font-bold text-[13px] hover:bg-gray-50 transition-all shadow-sm">
                <i data-feather="filter" class="w-4 h-4"></i> Filter
            </button>
            <button class="flex items-center gap-2 px-5 py-2.5 bg-brand-dark text-white rounded-xl font-bold text-[13px] hover:bg-opacity-90 transition-all shadow-md">
                <i data-feather="download" class="w-4 h-4"></i> Export CSV
            </button>
        </div>
    </div>

    {{-- Statistik Atas --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-center text-center hover:shadow-md transition-shadow">
            <p class="text-[11px] font-extrabold text-gray-400 uppercase tracking-widest mb-2">Total Pendaftar</p>
            <h3 class="text-4xl font-black text-brand-dark mb-2">{{ number_format($totalPendaftar) }}</h3> 
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-center text-center hover:shadow-md transition-shadow">
            <p class="text-[11px] font-extrabold text-gray-400 uppercase tracking-widest mb-2">Menunggu Validasi</p>
            <h3 class="text-4xl font-black text-amber-500 mb-2">{{ number_format($menungguValidasi) }}</h3> 
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-center text-center hover:shadow-md transition-shadow">
            <p class="text-[11px] font-extrabold text-gray-400 uppercase tracking-widest mb-2">Lulus Seleksi</p>
            <h3 class="text-4xl font-black text-green-500 mb-2">{{ number_format($lulusSeleksi) }}</h3> 
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-center text-center hover:shadow-md transition-shadow">
            <p class="text-[11px] font-extrabold text-gray-400 uppercase tracking-widest mb-2">Pembayaran Belum</p>
            <h3 class="text-4xl font-black text-gray-300 mb-2">{{ number_format($pembayaranBelum) }}</h3> 
        </div>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left whitespace-nowrap">
                <thead class="bg-white text-[11px] font-black text-brand-dark uppercase tracking-widest border-b border-gray-100">
                    <tr>
                        <th class="px-8 py-5">No</th>
                        <th class="px-4 py-5">Nama & Email</th>
                        <th class="px-4 py-5">No HP</th>
                        <th class="px-4 py-5">Pilihan 1</th>
                        <th class="px-4 py-5">Pilihan 2</th> {{-- Kolom Baru --}}
                        <th class="px-4 py-5">Jalur</th>
                        <th class="px-4 py-5">Status</th>
                        <th class="px-8 py-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-[13px]">
                    @foreach($users as $index => $data)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-8 py-5 text-gray-400 font-bold">{{ $index + 1 }}</td>
                        <td class="px-4 py-5">
                            <div class="flex flex-col">
                                <span class="font-bold text-brand-dark text-[14px]">{{ $data->nama_lengkap }}</span>
                                <span class="text-gray-400 text-[12px] font-medium">{{ $data->email }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-5 text-gray-500 font-medium">{{ $data->no_whatsapp }}</td>
                        <td class="px-4 py-5">
                            <span class="px-4 py-1.5 bg-blue-50 text-blue-600 rounded-xl text-[12px] font-bold">{{ $data->pilihan_jurusan_1 }}</span>
                        </td>
                        <td class="px-4 py-5">
                            <span class="px-4 py-1.5 bg-purple-50 text-purple-600 rounded-xl text-[12px] font-bold">{{ $data->pilihan_jurusan_2 }}</span>
                        </td>
                        <td class="px-4 py-5 font-medium text-gray-500">{{ $data->jalur_pendaftaran }}</td>
                        <td class="px-4 py-5">
                            @php
                                $status = $data->status_pembayaran;
                                $statusClasses = [
                                    'Terverifikasi' => 'bg-green-50 text-green-600',
                                    'Validasi'      => 'bg-amber-50 text-amber-500',
                                    'Belum Bayar'   => 'bg-gray-100 text-gray-500'
                                ];
                                $currentClass = $statusClasses[$status] ?? 'bg-gray-50 text-gray-400';
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 {{ $currentClass }} rounded-full text-[10px] font-black uppercase tracking-wider">
                                {{ $status }}
                            </span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-brand-blue hover:text-white transition-colors">
                                    <i data-feather="eye" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection