<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil - SPMB Adzkia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Manrope', 'sans-serif'] },
                    colors: {
                        'adzkia-red': '#d9241c',
                        'adzkia-blue': '#2c7ebd',
                        'adzkia-dark': '#1e293b',
                        'adzkia-muted': '#64748b',
                        'adzkia-badge-bg': '#eff6ff',
                        'adzkia-badge-txt': '#2c7ebd',
                        'adzkia-bg': '#FAFBFC',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-adzkia-bg antialiased text-adzkia-dark min-h-screen flex flex-col" x-data="suksesApp()">

    <nav class="w-full bg-white py-8 border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-6">
            <div class="flex items-center justify-between relative">
                <div class="absolute top-5 left-0 w-full h-0.5 bg-adzkia-blue z-0"></div>
                
                <template x-for="step in steps" :key="step.id">
                    <div class="relative z-10 flex flex-col items-center gap-3 w-20">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-extrabold text-[13px] bg-adzkia-blue text-white transition-all duration-300 shadow-sm"
                             :class="step.id === 7 ? 'bg-adzkia-red shadow-red-600/30 scale-110 ring-4 ring-red-50' : ''">
                            <i data-feather="check" class="w-5 h-5"></i>
                        </div>
                        <span class="text-[9px] font-black uppercase tracking-widest text-center text-adzkia-dark" x-text="step.title"></span>
                    </div>
                </template>
            </div>
        </div>
    </nav>

    <main class="flex-1 max-w-3xl mx-auto w-full px-6 py-12 flex flex-col justify-center">
        <div class="bg-white p-10 md:p-14 rounded-[3rem] shadow-xl shadow-adzkia-dark/5 border border-gray-100 text-center relative overflow-hidden">
            
            <div class="absolute top-0 right-0 p-8 opacity-5 pointer-events-none">
                <i data-feather="award" class="w-48 h-48 text-adzkia-blue"></i>
            </div>

            <div class="w-20 h-20 bg-green-50 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm ring-8 ring-green-50/50">
                <i data-feather="check-circle" class="w-10 h-10"></i>
            </div>
            
            <h1 class="text-3xl md:text-4xl font-black text-adzkia-blue tracking-tight mb-4 relative z-10">Pendaftaran Berhasil!</h1>
            <p class="text-[14px] font-medium text-gray-500 leading-relaxed max-w-md mx-auto mb-10 relative z-10">
                Selamat! Anda telah menyelesaikan seluruh proses pendaftaran di Universitas Adzkia.
            </p>

            <div class="bg-adzkia-badge-bg rounded-3xl p-6 md:p-8 mb-10 border border-adzkia-blue/10 grid grid-cols-2 gap-y-6 gap-x-4 text-left relative z-10 shadow-inner">
                <div>
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Nama Pendaftar</p>
                    <h4 class="text-[14px] md:text-[16px] font-extrabold text-adzkia-dark">{{ $pendaftar->nama_lengkap }}</h4>
                </div>
                <div>
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Program Studi</p>
                    <h4 class="text-[14px] md:text-[16px] font-extrabold text-adzkia-dark">{{ $pendaftar->pilihan_jurusan_1 }}</h4>
                </div>
                <div>
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Nomor Pendaftaran</p>
                    <h4 class="text-[15px] md:text-[18px] font-black text-adzkia-red tracking-wider">{{ $pendaftar->no_pendaftaran }}</h4>
                </div>
                <div>
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Tanggal Selesai</p>
                    <h4 class="text-[14px] md:text-[16px] font-extrabold text-adzkia-dark">
                        {{ \Carbon\Carbon::parse($pendaftar->updated_at)->format('d F Y') }}
                    </h4>
                </div>
            </div>

            <div class="mb-12 relative z-10">
                <div class="flex items-center justify-center gap-4 mb-6">
                    <div class="h-px bg-gray-200 flex-1"></div>
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Langkah Selanjutnya</span>
                    <div class="h-px bg-gray-200 flex-1"></div>
                </div>
                
                <div class="space-y-4 max-w-md mx-auto text-left">
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center shrink-0 mt-0.5 text-adzkia-blue">
                            <i data-feather="mail" class="w-3.5 h-3.5"></i>
                        </div>
                        <p class="text-[13px] font-bold text-gray-600 leading-relaxed">Silakan cek email untuk informasi selanjutnya.</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center shrink-0 mt-0.5 text-adzkia-blue">
                            <i data-feather="layout" class="w-3.5 h-3.5"></i>
                        </div>
                        <p class="text-[13px] font-bold text-gray-600 leading-relaxed">Pantau dashboard untuk update terbaru.</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center shrink-0 mt-0.5 text-adzkia-blue">
                            <i data-feather="calendar" class="w-3.5 h-3.5"></i>
                        </div>
                        <p class="text-[13px] font-bold text-gray-600 leading-relaxed">Ikuti jadwal seleksi / pengumuman.</p>
                    </div>
                </div>
            </div>

            <p class="text-[15px] font-black text-adzkia-red italic mb-8">"Selamat bergabung bersama kami!"</p>

            <div class="flex flex-col items-center gap-4 relative z-10">
                <button onclick="window.location.href='/'" class="w-full py-4 bg-adzkia-dark text-white rounded-2xl font-black text-[15px] hover:bg-adzkia-blue shadow-lg shadow-adzkia-dark/20 transition-all active:scale-[0.98]">
                    Ke Dashboard
                </button>
                <button class="flex items-center gap-2 text-[13px] font-extrabold text-adzkia-blue hover:text-adzkia-red transition-colors py-2">
                    <i data-feather="download" class="w-4 h-4"></i> Download Bukti Pendaftaran
                </button>
            </div>

        </div>
    </main>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('suksesApp', () => ({
                currentStep: 7,
                steps: [
                    { id: 1, title: 'Pendaftaran' }, { id: 2, title: 'Biaya Pendaftaran' },
                    { id: 3, title: 'Validasi Pembayaran' }, { id: 4, title: 'Biodata' },
                    { id: 5, title: 'Daftar Ulang' }, { id: 6, title: 'Validasi' },
                    { id: 7, title: 'Selesai' }
                ]
            }));
        });
        document.addEventListener('DOMContentLoaded', () => { feather.replace(); });
    </script>
</body>
</html>