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
            <p class="text-[11px] font-bold text-green-500 flex items-center justify-center gap-1">
                <i data-feather="trending-up" class="w-3 h-3"></i> +12% dari minggu lalu
            </p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-center text-center hover:shadow-md transition-shadow">
            <p class="text-[11px] font-extrabold text-gray-400 uppercase tracking-widest mb-2">Menunggu Validasi</p>
            <h3 class="text-4xl font-black text-amber-500 mb-2">{{ number_format($menungguValidasi) }}</h3> 
            <p class="text-[11px] font-medium text-gray-400 italic">Perlu segera diproses</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-center text-center hover:shadow-md transition-shadow">
            <p class="text-[11px] font-extrabold text-gray-400 uppercase tracking-widest mb-2">Lulus Seleksi</p>
            <h3 class="text-4xl font-black text-green-500 mb-2">{{ number_format($lulusSeleksi) }}</h3> 
            <p class="text-[11px] font-medium text-gray-400">Kuota terisi: 65%</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-center text-center hover:shadow-md transition-shadow">
            <p class="text-[11px] font-extrabold text-gray-400 uppercase tracking-widest mb-2">Pembayaran Belum</p>
            <h3 class="text-4xl font-black text-gray-300 mb-2">{{ number_format($pembayaranBelum) }}</h3> 
            <p class="text-[11px] font-medium text-gray-400">Batas akhir: 3 hari lagi</p>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        
        <div class="p-8 border-b border-gray-50 flex justify-between items-center">
            <div class="flex items-center gap-3 text-[13px] font-medium text-gray-500">
                <span>Show</span>
                <select class="border border-gray-200 rounded-lg px-2 py-1 outline-none focus:border-brand-blue bg-gray-50">
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                </select>
                <span>entries</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left whitespace-nowrap">
                <thead class="bg-white text-[11px] font-black text-brand-dark uppercase tracking-widest border-b border-gray-100">
                    <tr>
                        <th class="px-8 py-5">No</th>
                        <th class="px-4 py-5">Nama & Email</th>
                        <th class="px-4 py-5">No HP</th>
                        <th class="px-4 py-5">Program Studi</th>
                        <th class="px-4 py-5">Jalur</th>
                        <th class="px-4 py-5">Status</th>
                        <th class="px-4 py-5">Tanggal Daftar</th>
                        <th class="px-8 py-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-[13px]">
                    
                    @foreach($users as $index => $data)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-8 py-5 text-gray-400 font-bold">{{ $index + 1 }}</td>
                        <td class="px-4 py-5">
                            <div class="flex flex-col">
                                <span class="font-bold text-brand-dark text-[14px]">{{ $data->user->name }}</span>
                                <span class="text-gray-400 text-[12px] font-medium">{{ $data->user->email }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-5 text-gray-500 font-medium">{{ $data->no_hp }}</td>
                        <td class="px-4 py-5">
                            <span class="px-4 py-1.5 bg-blue-50 text-blue-600 rounded-xl text-[12px] font-bold">{{ $data->program_studi }}</span>
                        </td>
                        <td class="px-4 py-5">
                            <div class="flex flex-col">
                                <span class="text-gray-500 font-medium">{{ $data->jalur }}</span>
                                <span class="text-gray-400 text-[11px]">{{ $data->jalur_detail }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-5">
                            @php
                                $statusClasses = [
                                    'Terverifikasi' => 'bg-green-50 text-green-600',
                                    'Validasi' => 'bg-amber-50 text-amber-500',
                                    'Diproses' => 'bg-blue-50 text-brand-blue',
                                    'Ditolak' => 'bg-red-50 text-red-500',
                                    'Belum Bayar' => 'bg-gray-100 text-gray-500'
                                ];
                                $dotClasses = [
                                    'Terverifikasi' => 'bg-green-500',
                                    'Validasi' => 'bg-amber-500',
                                    'Diproses' => 'bg-brand-blue',
                                    'Ditolak' => 'bg-red-500',
                                    'Belum Bayar' => 'bg-gray-400'
                                ];
                                $currentClass = $statusClasses[$data->status] ?? 'bg-gray-50 text-gray-400';
                                $currentDot = $dotClasses[$data->status] ?? 'bg-gray-400';
                            @endphp

                            <span class="inline-flex items-center gap-1.5 px-3 py-1 {{ $currentClass }} rounded-full text-[10px] font-black uppercase tracking-wider">
                                <div class="w-1.5 h-1.5 rounded-full {{ $currentDot }} {{ $data->status == 'Diproses' ? 'animate-pulse' : '' }}"></div> 
                                {{ $data->status }}
                            </span>
                        </td>
                        <td class="px-4 py-5 text-gray-500 font-medium">
                            <div class="flex flex-col">
                                <span>{{ $data->created_at->format('d M') }}</span>
                                <span class="text-gray-400 text-[11px]">{{ $data->created_at->format('Y') }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-brand-blue hover:text-white transition-colors">
                                    <i data-feather="eye" class="w-4 h-4"></i>
                                </button>
                                <button class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-brand-dark hover:text-white transition-colors">
                                    <i data-feather="more-vertical" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        <div class="p-8 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-[13px] font-medium text-gray-500">Showing 1 to {{ $users->count() }} of {{ $totalPendaftar }} entries</p>
            <div class="flex items-center gap-2">
                <button class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-gray-100 transition-colors"><i data-feather="chevron-left" class="w-4 h-4"></i></button>
                <button class="w-8 h-8 rounded-lg bg-brand-dark text-white font-bold text-[13px] flex items-center justify-center">1</button>
                <button class="w-8 h-8 rounded-lg text-brand-dark font-bold text-[13px] hover:bg-gray-100 transition-colors flex items-center justify-center">2</button>
                <button class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-gray-100 transition-colors"><i data-feather="chevron-right" class="w-4 h-4"></i></button>
            </div>
        </div>

    </div>

@endsection