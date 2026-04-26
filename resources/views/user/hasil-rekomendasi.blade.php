<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Rekomendasi - SPMB Adzkia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Manrope', 'sans-serif'] },
                    colors: {
                        'brand-bg': '#F8FAFC',
                        'brand-dark': '#0F172A',
                        'brand-gray': '#64748B',
                        'brand-blue': '#2563EB',
                        'brand-blue-light': '#EFF6FF',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-brand-bg antialiased text-brand-dark min-h-screen relative" x-data="rekomendasiResult()">

    <div x-show="isLoading" 
         x-transition:leave="transition ease-in duration-500"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-50 flex flex-col items-center justify-center bg-gradient-to-b from-white to-[#F0F4F8] px-6">
        
        <div class="w-16 h-16 bg-brand-dark rounded-2xl text-white flex items-center justify-center mb-6 shadow-xl shadow-brand-dark/20 animate-bounce">
            <i data-feather="cpu" class="w-8 h-8"></i>
        </div>
        <h2 class="text-xl font-black text-brand-dark mb-12">Universitas Adzkia</h2>

        <div class="w-full max-w-md mb-6">
            <div class="h-1.5 w-full bg-gray-200 rounded-full overflow-hidden">
                <div class="h-full bg-brand-dark transition-all duration-300 ease-out" :style="`width: ${progress}%`"></div>
            </div>
        </div>

        <div class="flex items-center gap-6 text-[10px] font-black uppercase tracking-widest text-gray-400 mb-10">
            <span class="flex items-center gap-1.5" :class="progress > 10 ? 'text-brand-blue' : ''">
                <i data-feather="activity" class="w-3.5 h-3.5"></i> Menganalisis Kognitif
            </span>
            <span class="flex items-center gap-1.5" :class="progress > 60 ? 'text-brand-blue' : ''">
                <i data-feather="cpu" class="w-3.5 h-3.5"></i> Memetakan Profil
            </span>
        </div>

        <div class="text-center max-w-lg mb-12">
            <h1 class="text-3xl md:text-4xl font-black text-brand-dark tracking-tight mb-4">Sedang Menganalisis Jawaban Kamu...</h1>
            <p class="text-[14px] font-medium text-gray-500 leading-relaxed">
                Sistem kurasi kami sedang memetakan profil kognitif Anda ke dalam 16 profil akademik terbaik untuk memberikan rekomendasi yang paling akurat.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 w-full max-w-2xl mb-12">
            <div class="bg-white py-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center text-center">
                <h3 class="text-xl font-black text-brand-dark mb-1">16</h3>
                <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Matriks Profil</p>
            </div>
            <div class="bg-white py-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center text-center">
                <h3 class="text-xl font-black text-brand-dark mb-1">AI-Powered</h3>
                <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Metode Kurasi</p>
            </div>
            <div class="bg-white py-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center text-center">
                <h3 class="text-xl font-black text-brand-dark mb-1" x-text="Math.floor(progress * 0.98) + '%'"></h3>
                <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">Akurasi Prediksi</p>
            </div>
        </div>

        <p class="text-[12px] font-bold text-gray-400 animate-pulse">Tunggu sebentar, kami sedang membangun masa depan akademis Anda.</p>
    </div>


    <div x-show="!isLoading" 
         x-transition:enter="transition ease-out duration-700 delay-300"
         x-transition:enter-start="opacity-0 translate-y-10"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="min-h-screen flex flex-col" x-cloak>
        
        <header class="w-full max-w-6xl mx-auto px-6 py-8 flex flex-col gap-8">
            <a href="/tes-rekomendasi" class="w-10 h-10 flex items-center justify-center text-brand-dark hover:bg-gray-200 bg-white rounded-full shadow-sm transition-colors">
                <i data-feather="arrow-left" class="w-6 h-6"></i>
            </a>
            
            <div class="max-w-2xl">
                <h1 class="text-3xl md:text-4xl font-black text-brand-dark tracking-tight mb-3">Hasil Rekomendasi Jurusan Kamu</h1>
                <p class="text-[14px] md:text-[15px] font-medium text-brand-gray leading-relaxed">
                    Berdasarkan analisis mendalam terhadap minat, bakat, dan pola jawaban yang telah kamu berikan, tim kurasi kami telah merumuskan jalur akademik yang paling sesuai untuk potensi masa depanmu.
                </p>
            </div>
        </header>

        <main class="flex-1 w-full max-w-6xl mx-auto px-6 pb-20 grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <div class="lg:col-span-8 space-y-6">
                
                <div class="bg-white p-8 md:p-10 rounded-[2.5rem] shadow-sm border border-gray-100 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-8 opacity-5 transition-transform duration-500 group-hover:scale-110">
                        <i data-feather="code" class="w-48 h-48"></i>
                    </div>
                    
                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-brand-blue-light text-brand-blue rounded-lg text-[11px] font-black tracking-widest mb-6 relative z-10">
                        <i data-feather="star" class="w-3.5 h-3.5 fill-current"></i> 94% Match
                    </div>
                    
                    <h2 class="text-4xl md:text-5xl font-black text-brand-dark tracking-tight mb-6 relative z-10">S1 Informatika</h2>
                    
                    <p class="text-[15px] font-medium text-gray-500 leading-relaxed mb-10 relative z-10 max-w-2xl">
                        Kamu menunjukkan kecenderungan kuat dalam pemikiran logis dan struktur matematis. Informatika adalah arena yang tepat bagi kamu yang bergairah dalam pengembangan perangkat lunak, kecerdasan buatan, dan pemecahan masalah melalui kode.
                    </p>
                    
                    <div class="flex flex-wrap items-center gap-4 relative z-10">
                        <button class="px-8 py-4 bg-brand-dark text-white rounded-2xl font-black text-[14px] hover:bg-brand-blue shadow-lg shadow-brand-dark/20 transition-all hover:-translate-y-1">
                            Daftar Sekarang
                        </button>
                        <button class="px-8 py-4 bg-gray-100 text-brand-dark rounded-2xl font-black text-[14px] hover:bg-gray-200 transition-all">
                            Lihat Detail Prodi
                        </button>
                    </div>
                </div>

                <div class="bg-[#F8FAFC] p-8 md:p-10 rounded-[2.5rem] border border-gray-200">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 bg-brand-dark text-white rounded-2xl flex items-center justify-center shadow-md">
                            <i data-feather="user" class="w-6 h-6"></i>
                        </div>
                        <h3 class="text-xl font-black text-brand-dark">Profil Kepribadian Kamu</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h4 class="text-[13px] font-black text-brand-dark mb-2 flex items-center gap-2"><i data-feather="check-square" class="w-4 h-4 text-brand-blue"></i> Analytical Thinking</h4>
                            <p class="text-[12px] font-medium text-gray-500 leading-relaxed">Mampu memecah masalah kompleks menjadi komponen yang dapat dikelola dan diproses secara sistematis.</p>
                        </div>
                        <div>
                            <h4 class="text-[13px] font-black text-brand-dark mb-2 flex items-center gap-2"><i data-feather="check-square" class="w-4 h-4 text-brand-blue"></i> Problem Solving</h4>
                            <p class="text-[12px] font-medium text-gray-500 leading-relaxed">Orientasi pada solusi yang efisien dan inovatif dalam menghadapi tantangan teknis maupun manajerial.</p>
                        </div>
                        <div>
                            <h4 class="text-[13px] font-black text-brand-dark mb-2 flex items-center gap-2"><i data-feather="check-square" class="w-4 h-4 text-brand-blue"></i> Interest in Tech</h4>
                            <p class="text-[12px] font-medium text-gray-500 leading-relaxed">Keingintahuan tinggi terhadap cara kerja mesin dan perangkat lunak di balik ekosistem digital modern.</p>
                        </div>
                        <div>
                            <h4 class="text-[13px] font-black text-brand-dark mb-2 flex items-center gap-2"><i data-feather="check-square" class="w-4 h-4 text-brand-blue"></i> Creative Logic</h4>
                            <p class="text-[12px] font-medium text-gray-500 leading-relaxed">Keseimbangan antara kreativitas dan struktur logis dalam menciptakan alur kerja yang baru.</p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap items-center justify-center gap-8 pt-4">
                    <button class="flex items-center gap-2 text-[13px] font-black text-brand-dark hover:text-brand-blue transition-colors">
                        <i data-feather="refresh-cw" class="w-4 h-4"></i> Ulangi Tes
                    </button>
                    <button class="flex items-center gap-2 text-[13px] font-black text-brand-dark hover:text-brand-blue transition-colors">
                        <i data-feather="bookmark" class="w-4 h-4"></i> Simpan Hasil
                    </button>
                    <button class="flex items-center gap-2 text-[13px] font-black text-brand-dark hover:text-brand-blue transition-colors">
                        <i data-feather="share-2" class="w-4 h-4"></i> Bagikan Ke Teman
                    </button>
                </div>

            </div>

            <div class="lg:col-span-4 space-y-4">
                <h3 class="text-[16px] font-black text-brand-dark mb-4">Alternatif Terbaik</h3>
                
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-all cursor-pointer group">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-10 h-10 bg-brand-blue-light text-brand-blue rounded-xl flex items-center justify-center">
                            <i data-feather="layout" class="w-5 h-5"></i>
                        </div>
                        <span class="px-2.5 py-1 bg-gray-100 text-brand-dark rounded-md text-[9px] font-black tracking-widest">85% Match</span>
                    </div>
                    <h4 class="text-[15px] font-black text-brand-dark mb-2">S1 Sistem Informasi</h4>
                    <p class="text-[11px] font-medium text-gray-500 leading-relaxed mb-4">Jembatan antara teknologi dan manajemen bisnis yang strategis.</p>
                    <div class="text-right text-gray-300 group-hover:text-brand-blue transition-colors">
                        <i data-feather="arrow-right" class="w-5 h-5 inline"></i>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-all cursor-pointer group">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-10 h-10 bg-gray-100 text-brand-dark rounded-xl flex items-center justify-center">
                            <i data-feather="settings" class="w-5 h-5"></i>
                        </div>
                        <span class="px-2.5 py-1 bg-gray-100 text-brand-dark rounded-md text-[9px] font-black tracking-widest">78% Match</span>
                    </div>
                    <h4 class="text-[15px] font-black text-brand-dark mb-2">S1 Teknik Industri</h4>
                    <p class="text-[11px] font-medium text-gray-500 leading-relaxed mb-4">Optimalisasi sistem kompleks dan manajemen operasional skala besar.</p>
                    <div class="text-right text-gray-300 group-hover:text-brand-blue transition-colors">
                        <i data-feather="arrow-right" class="w-5 h-5 inline"></i>
                    </div>
                </div>
            </div>

        </main>
        
        <footer class="w-full bg-brand-bg border-t border-gray-200 py-8 mt-auto">
            <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
                <div>
                    <h4 class="text-[15px] font-black text-brand-dark mb-2">Universitas Adzkia</h4>
                    <p class="text-[11px] font-medium text-gray-500 leading-relaxed max-w-xs mx-auto md:mx-0">
                        Membantu calon mahasiswa menemukan jalur akademik yang paling sesuai dengan potensi sejati mereka melalui teknologi kurasi berbasis data.
                    </p>
                </div>
                <div class="flex flex-col items-center md:items-start gap-2 text-[12px] font-bold text-gray-500">
                    <p class="text-[13px] text-brand-dark mb-1">Institusi</p>
                    <a href="#" class="hover:text-brand-blue">Global Rankings</a>
                    <a href="#" class="hover:text-brand-blue">Terms of Service</a>
                </div>
                <div class="flex flex-col items-center md:items-start gap-2 text-[12px] font-bold text-gray-500">
                    <p class="text-[13px] text-brand-dark mb-1">Bantuan</p>
                    <a href="#" class="hover:text-brand-blue">Privacy Policy</a>
                    <a href="#" class="hover:text-brand-blue">Contact Support</a>
                </div>
            </div>
            <div class="max-w-6xl mx-auto px-6 mt-8 pt-6 border-t border-gray-200 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-[10px] font-bold text-gray-400">© 2026 Universitas Adzkia. All Rights Reserved.</p>
                <div class="flex gap-4 text-gray-400">
                    <i data-feather="globe" class="w-4 h-4 hover:text-brand-dark cursor-pointer"></i>
                    <i data-feather="shield" class="w-4 h-4 hover:text-brand-dark cursor-pointer"></i>
                    <i data-feather="at-sign" class="w-4 h-4 hover:text-brand-dark cursor-pointer"></i>
                </div>
            </div>
        </footer>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('rekomendasiResult', () => ({
                isLoading: true,
                progress: 0,

                init() {
                    // Simulasi proses analisis AI (Machine Learning delay)
                    // Progress bar akan berjalan dari 0 ke 100 dalam ~3 detik
                    let interval = setInterval(() => {
                        this.progress += Math.floor(Math.random() * 15) + 5; // Naik secara random 5-20%
                        
                        if (this.progress >= 100) {
                            this.progress = 100;
                            clearInterval(interval);
                            
                            // Tunggu sebentar di angka 100% sebelum mengganti halaman
                            setTimeout(() => {
                                this.isLoading = false;
                                
                                // Render ulang ikon untuk halaman hasil
                                this.$nextTick(() => {
                                    if(window.feather) feather.replace();
                                });
                                
                            }, 500); 
                        }
                    }, 300); // Update setiap 300ms
                }
            }));
        });

        // Inisialisasi awal untuk halaman loading
        document.addEventListener('DOMContentLoaded', () => {
            feather.replace();
        });
    </script>
</body>
</html>