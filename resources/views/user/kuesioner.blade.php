<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tes Rekomendasi: Sesi 1 - SPMB Adzkia</title>
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
<body class="bg-brand-bg antialiased text-brand-dark min-h-screen flex flex-col relative pb-28" x-data="kuesionerApp()">

    <header class="w-full max-w-4xl mx-auto px-6 py-8 flex flex-col gap-6">
        <a href="/rekomendasi/mulai" class="w-10 h-10 flex items-center justify-center text-brand-dark hover:bg-gray-100 rounded-full transition-colors">
            <i data-feather="arrow-left" class="w-6 h-6"></i>
        </a>
        
        <div class="flex justify-between items-end border-b-2 border-gray-200 pb-4 relative">
            <div class="absolute bottom-[-2px] left-0 h-[2px] bg-brand-dark transition-all duration-500" :style="`width: ${progress}%`"></div>
            
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-brand-dark tracking-tight">Sesi 1: Minat & Ketertarikan</h1>
                <p class="text-[13px] md:text-[14px] font-medium text-brand-gray mt-1">Lengkapi instrumen ini untuk mendapatkan rekomendasi jurusan yang tepat.</p>
            </div>
            
            <div class="text-right hidden sm:block">
                <div class="px-3 py-1 bg-brand-blue-light text-brand-blue rounded-lg text-[11px] font-black uppercase tracking-widest mb-1">
                    <span x-text="Math.round(progress)"></span>% Selesai
                </div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Sesi 1 dari 7</p>
            </div>
        </div>
    </header>

<main class="flex-1 w-full max-w-4xl mx-auto px-6 flex flex-col gap-10 mt-4">
        
        <template x-for="(q, index) in questions" :key="q.id">
            <div class="flex flex-col md:flex-row gap-4 md:gap-6 items-start group">
                <div class="w-10 h-10 rounded-full bg-gray-100 text-brand-dark flex items-center justify-center font-black text-[14px] shrink-0 group-hover:bg-brand-blue-light group-hover:text-brand-blue transition-colors">
                    <span x-text="String(index + 1).padStart(2, '0')"></span>
                </div>
                
                <div class="flex-1 w-full">
                    <h3 class="text-[16px] md:text-[18px] font-extrabold text-brand-dark leading-snug mb-5" x-text="q.text"></h3>
                    
                    <div class="grid grid-cols-5 gap-2 md:gap-4">
                        <template x-for="opt in options" :key="opt.value">
                            <label class="cursor-pointer relative flex flex-col items-center justify-center p-3 md:p-5 rounded-2xl border-2 transition-all duration-300"
                                   :class="answers[q.id] == opt.value ? 'bg-brand-dark border-brand-dark shadow-xl shadow-brand-dark/20 scale-105 ring-4 ring-brand-blue-light' : 'bg-white border-gray-100 hover:border-brand-blue hover:bg-brand-blue-light'">
                                
                                <input type="radio" :name="q.id" :value="opt.value" x-model="answers[q.id]" class="sr-only">
                                
                                <span class="text-lg md:text-xl font-black mb-1 md:mb-2 transition-colors duration-300" 
                                      :class="answers[q.id] == opt.value ? 'text-white' : 'text-brand-dark'" 
                                      x-text="opt.value"></span>
                                
                                <span class="text-[7px] md:text-[9px] font-extrabold uppercase tracking-widest text-center leading-tight transition-colors duration-300" 
                                      :class="answers[q.id] == opt.value ? 'text-gray-300' : 'text-gray-400'" 
                                      x-text="opt.label"></span>
                            </label>
                        </template>
                    </div>
                </div>
            </div>
        </template>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mt-6">
            <div class="md:col-span-8 bg-brand-blue-light rounded-3xl p-6 md:p-8 border border-blue-100">
                <h4 class="text-lg font-black text-brand-blue mb-2">Mengapa tes ini penting?</h4>
                <p class="text-[13px] font-medium text-brand-blue/80 leading-relaxed mb-6">
                    Jawaban Anda membantu sistem AI kami memetakan preferensi kognitif dan ketertarikan emosional Anda ke dalam 16 program studi yang tersedia di Universitas Adzkia.
                </p>
                <div class="flex items-center gap-3">
                    <div class="flex -space-x-3">
                        <div class="w-8 h-8 rounded-full bg-brand-dark border-2 border-brand-blue-light"></div>
                        <div class="w-8 h-8 rounded-full bg-blue-800 border-2 border-brand-blue-light"></div>
                        <div class="w-8 h-8 rounded-full bg-red-800 border-2 border-brand-blue-light"></div>
                    </div>
                    <span class="text-[11px] font-black text-brand-blue uppercase tracking-widest">+2.4K SISWA TERBANTU</span>
                </div>
            </div>
            
            <div class="md:col-span-4 bg-gray-100 rounded-3xl p-6 md:p-8 border border-gray-200 relative overflow-hidden">
                <h4 class="text-[15px] font-black text-brand-dark mb-2 relative z-10">Tips Cepat</h4>
                <p class="text-[12px] font-medium text-gray-500 leading-relaxed relative z-10">
                    Jawablah secara jujur dan spontan. Tidak ada jawaban benar atau salah dalam tes minat.
                </p>
                <div class="absolute -bottom-4 -right-4 text-gray-200 w-20 h-20 opacity-50">
                    <i data-feather="target" class="w-full h-full"></i>
                </div>
            </div>
        </div>
    </main>

    <footer class="fixed bottom-0 left-0 w-full bg-white border-t border-gray-100 shadow-[0_-4px_20px_rgba(0,0,0,0.02)] z-40">
        <div class="max-w-4xl mx-auto px-6 py-4 flex justify-between items-center">
            <button class="flex items-center gap-2 px-5 py-3 text-gray-400 hover:text-brand-dark hover:bg-gray-50 rounded-xl font-bold text-[13px] transition-all">
                <i data-feather="arrow-left" class="w-4 h-4"></i> SEBELUMNYA
            </button>
            
            <button @click="lanjutkan()"
                    :disabled="!isAllAnswered"
                    :class="isAllAnswered ? 'bg-brand-dark text-white hover:bg-brand-blue shadow-lg hover:-translate-y-0.5' : 'bg-gray-200 text-gray-400 cursor-not-allowed'"
                    class="flex items-center gap-2 px-8 py-3 rounded-xl font-black text-[13px] transition-all duration-300">
                SELANJUTNYA <i data-feather="arrow-right" class="w-4 h-4"></i>
            </button>
        </div>
    </footer>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('kuesionerApp', () => ({
                // Data Jawaban User
                answers: { q1: null, q2: null, q3: null, q4: null, q5: null },
                
                // Daftar Pertanyaan Sesi 1
                questions: [
                    { id: 'q1', text: 'Saya sangat suka memecahkan masalah logika yang kompleks atau teka-teki matematika.' },
                    { id: 'q2', text: 'Saya merasa tertarik dengan desain visual, estetika tata letak, dan komposisi warna.' },
                    { id: 'q3', text: 'Saya senang bekerja dengan data, membuat laporan, dan mencari pola dari informasi yang ada.' },
                    { id: 'q4', text: 'Saya lebih suka menghabiskan waktu luang dengan membaca buku literatur atau menulis cerita.' },
                    { id: 'q5', text: 'Saya merasa puas ketika bisa membantu orang lain memecahkan masalah pribadi atau emosional mereka.' }
                ],
                
                // Opsi Skala Likert
                options: [
                    { value: 1, label: 'SANGAT TIDAK SETUJU' },
                    { value: 2, label: 'TIDAK SETUJU' },
                    { value: 3, label: 'NETRAL' },
                    { value: 4, label: 'SETUJU' },
                    { value: 5, label: 'SANGAT SETUJU' }
                ],

                // Mengecek apakah semua pertanyaan sudah dijawab
                get isAllAnswered() {
                    return Object.values(this.answers).every(answer => answer !== null);
                },

                // Menghitung progress (0% - 14%)
                get progress() {
                    const answeredCount = Object.values(this.answers).filter(a => a !== null).length;
                    const totalQuestionsInSession = this.questions.length;
                    // Sesi 1 adalah 1/7 dari total (sekitar 14.2%)
                    return (answeredCount / totalQuestionsInSession) * 14.28;
                },

                lanjutkan() {
                    if (this.isAllAnswered) {
                        // Simpan data ke session storage atau langsung submit ke backend
                        console.log("Data Sesi 1:", this.answers);
                        alert("Jawaban disimpan! Melanjutkan ke Sesi 2...");
                        // window.location.href = '/tes-rekomendasi/sesi-2';
                    }
                }
            }));
        });

        // Initialize Feather Icons
        document.addEventListener('DOMContentLoaded', () => {
            feather.replace();
        });
    </script>
</body>
</html>