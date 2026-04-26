<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mulai Tes Rekomendasi - SPMB Adzkia</title>
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
<body class="bg-brand-bg antialiased text-brand-dark min-h-screen flex flex-col relative" x-data="rekomendasiApp()">

    <div class="fixed top-0 left-0 w-full h-1.5 bg-gray-200 z-50">
        <div class="h-full bg-brand-dark w-1/4 transition-all duration-500 rounded-r-full"></div>
    </div>

    <header class="w-full px-8 py-6 flex items-center">
        <a href="/" class="p-2 text-brand-dark hover:bg-gray-100 rounded-full transition-colors">
            <i data-feather="arrow-left" class="w-6 h-6"></i>
        </a>
    </header>

    <main class="flex-1 flex flex-col items-center justify-start px-6 pt-4 pb-20 w-full max-w-5xl mx-auto">
        
        <div class="text-center mb-12">
            <h1 class="text-[32px] md:text-[40px] font-black text-brand-dark tracking-tight mb-4">Pilih Jurusan yang Anda Minati</h1>
            <p class="text-[15px] font-medium text-brand-gray max-w-lg mx-auto leading-relaxed">
                Pilih jurusan yang paling menarik bagi Anda sebelum memulai tes rekomendasi. Anda dapat memilih hingga <span class="font-extrabold text-brand-dark">3 program studi</span>.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 w-full mb-12">
            <template x-for="item in jurusanList" :key="item.id">
                <div @click="toggleSelection(item.id)" 
                     class="relative p-8 rounded-3xl border-2 cursor-pointer transition-all duration-300 flex flex-col items-center text-center group bg-white shadow-sm hover:shadow-md"
                     :class="selected.includes(item.id) ? 'border-brand-dark shadow-lg scale-[1.02]' : 'border-transparent hover:border-gray-200'">
                    
                    <div x-show="selected.includes(item.id)" 
                         x-transition.scale.origin.center
                         class="absolute top-4 right-4 w-6 h-6 bg-brand-dark text-white rounded-full flex items-center justify-center shadow-md">
                        <i data-feather="check" class="w-3.5 h-3.5"></i>
                    </div>

                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-5 transition-colors"
                         :class="selected.includes(item.id) ? 'bg-brand-blue-light text-brand-blue' : 'bg-gray-50 text-gray-400 group-hover:bg-gray-100 group-hover:text-brand-dark'">
                        <span class="flex items-center justify-center w-6 h-6" x-html="feather.icons[item.icon].toSvg()"></span>
                    </div>

                    <h3 class="text-[15px] font-extrabold text-brand-dark mb-2" x-text="item.nama"></h3>
                    <p class="text-[11px] font-medium text-gray-400 leading-relaxed px-2" x-text="item.desc"></p>
                </div>
            </template>
        </div>

        <div class="flex flex-col items-center gap-4">
            <p class="text-[13px] font-extrabold text-red-500 flex items-center gap-1.5 transition-opacity duration-300"
               :class="selected.length === 0 ? 'opacity-100' : 'opacity-0'">
                <i data-feather="info" class="w-4 h-4"></i> Silakan pilih minimal 1 jurusan
            </p>

            <button @click="lanjutkan()"
                    :disabled="selected.length === 0"
                    :class="selected.length > 0 ? 'bg-brand-dark text-white hover:bg-brand-blue hover:shadow-lg hover:-translate-y-0.5' : 'bg-gray-200 text-gray-400 cursor-not-allowed'"
                    class="px-10 py-4 rounded-2xl font-black text-[15px] transition-all duration-300 w-full sm:w-auto min-w-[200px]">
                Selanjutnya
            </button>

            <div class="px-4 py-1.5 bg-brand-blue-light text-brand-blue rounded-full text-[11px] font-black uppercase tracking-widest">
                <span x-text="selected.length"></span>/3 Dipilih
            </div>
        </div>

    </main>

    <section class="w-full bg-white py-16 mt-10 border-t border-gray-100">
        <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="max-w-md">
                <h2 class="text-3xl font-black text-brand-dark leading-tight mb-4">Masa depan dimulai dengan pilihan yang tepat.</h2>
                <p class="text-[14px] font-medium text-gray-500 leading-relaxed">
                    Tim kurator AI kami telah menyusun instrumen evaluasi berdasarkan karakteristik akademik dan non-akademik. Pilihan awal Anda akan menjadi baseline bagi sistem untuk menganalisis kecocokan Anda di tahapan selanjutnya.
                </p>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <img src="https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=400&q=80" alt="Kampus Adzkia" class="rounded-3xl rounded-tr-[4rem] w-full h-64 object-cover shadow-sm">
                <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=400&q=80" alt="Mahasiswa" class="rounded-3xl rounded-bl-[4rem] w-full h-64 object-cover shadow-sm mt-8">
            </div>
        </div>
    </section>

    <footer class="w-full bg-brand-bg border-t border-gray-200 py-6 px-8 flex flex-col sm:flex-row justify-between items-center gap-4">
        <p class="text-[11px] font-bold text-gray-400">© 2026 Universitas Adzkia. All Rights Reserved.</p>
        <div class="flex gap-6 text-[11px] font-bold text-brand-dark">
            <a href="#" class="hover:text-brand-blue transition-colors">Privacy Policy</a>
            <a href="#" class="hover:text-brand-blue transition-colors">Terms of Service</a>
            <a href="#" class="hover:text-brand-blue transition-colors">Accessibility</a>
        </div>
    </footer>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('rekomendasiApp', () => ({
                selected: [],
                maxSelection: 3,
                
                // Menggunakan data asli dari PDF Universitas Adzkia
                jurusanList: [
                    { id: 'if', nama: 'Informatika', desc: 'Software Engineering, AI & Data Science', icon: 'monitor' },
                    { id: 'dkv', nama: 'DKV', desc: 'Desain Grafis, Animasi & Multimedia', icon: 'pen-tool' },
                    { id: 'mnj', nama: 'Manajemen Ritel', desc: 'Bisnis, Pemasaran & Keuangan', icon: 'briefcase' },
                    { id: 'ts', nama: 'Teknik Sipil', desc: 'Infrastruktur, Struktur & Konstruksi', icon: 'tool' },
                    { id: 'psi', nama: 'Pendidikan Khusus', desc: 'Pendidikan & Perilaku Inklusif', icon: 'heart' },
                    { id: 'hk', nama: 'Hukum Bisnis', desc: 'Hukum Perusahaan & Internasional', icon: 'book' },
                    { id: 'gz', nama: 'Gizi', desc: 'Kesehatan, Nutrisi & Dietetika', icon: 'activity' },
                    { id: 'si', nama: 'Sistem Informasi', desc: 'Manajemen IT, Audit & Proses Bisnis', icon: 'layout' }
                ],

                toggleSelection(id) {
                    if (this.selected.includes(id)) {
                        // Hapus jika sudah ada
                        this.selected = this.selected.filter(item => item !== id);
                    } else {
                        // Tambah jika belum batas maksimal
                        if (this.selected.length < this.maxSelection) {
                            this.selected.push(id);
                        } else {
                            // Opsional: Beri efek getar/alert jika mencoba memilih lebih dari 3
                            // Di sini kita abaikan saja pemilihannya
                        }
                    }
                },

                lanjutkan() {
                    // Logic untuk pindah halaman dengan membawa data jurusan
                    window.location.href = '/rekomendasi/kuesioner';
                    alert('Melanjutkan ke tes kuesioner dengan jurusan: ' + this.selected.join(', '));
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