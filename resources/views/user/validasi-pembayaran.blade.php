<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi Pembayaran - Dasbor SPMB Adzkia</title>
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
                        'adzkia-badge-bg': '#eff6ff',
                    }
                }
            }
        }
    </script>
    <style> [x-cloak] { display: none !important; } </style>
</head>
<body class="bg-gray-50 antialiased text-adzkia-dark min-h-screen flex flex-col" x-data="uploadApp()">

    {{-- NAVBAR DASHBOARD USER (Konsisten) --}}
    <nav class="bg-white border-b border-gray-200 py-4 px-6 md:px-10 flex justify-between items-center sticky top-0 z-30">
        <a href="{{ route('dashboard.user') }}" class="flex items-center gap-3 group">
            <img src="{{ asset('images/logo-adzkia.png') }}" alt="Logo" class="h-10 w-auto group-hover:scale-105 transition-transform">
            <div class="hidden md:flex flex-col">
                <span class="text-[16px] font-black text-adzkia-blue leading-none">Dasbor</span>
                <span class="text-[12px] font-bold text-adzkia-red">Calon Mahasiswa</span>
            </div>
        </a>
        
        <div class="flex items-center gap-4 md:gap-6">
            <a href="{{ route('dashboard.user') }}" class="flex items-center gap-2 text-[12px] md:text-[13px] font-bold text-gray-500 hover:text-adzkia-blue transition-colors bg-gray-50 px-4 py-2 rounded-lg">
                <i data-feather="arrow-left" class="w-4 h-4"></i> Kembali ke Dasbor
            </a>
            <div class="hidden md:block w-px h-6 bg-gray-200"></div>
            <div class="flex items-center gap-3">
                <div class="text-right hidden md:block">
                    <p class="text-[13px] font-extrabold text-adzkia-dark">{{ session('nama_pendaftar') }}</p>
                    <p class="text-[11px] font-bold text-gray-400">ID: {{ $pendaftar->no_pendaftaran ?? 'ID Kosong' }}</p>
                </div>
                <img src="https://ui-avatars.com/api/?name={{ urlencode(session('nama_pendaftar')) }}&background=1e293b&color=fff" class="w-10 h-10 rounded-full border-2 border-gray-100">
            </div>
        </div>
    </nav>

    {{-- STEP PROGRESS TRACKER (Konsisten) --}}
    <div class="w-full bg-white py-6 border-b border-gray-100 z-20">
        <div class="max-w-5xl mx-auto px-6">
            <div class="flex items-center justify-between relative">
                <div class="absolute top-1/2 left-0 w-full h-0.5 bg-gray-100 -translate-y-1/2 z-0"></div>
                <!-- Garis progres biru untuk Step 3 (sekitar 33%) -->
                <div class="absolute top-1/2 left-0 h-0.5 bg-adzkia-blue -translate-y-1/2 z-0 transition-all duration-500" style="width: 33.33%;"></div>
                
                <template x-for="step in steps" :key="step.id">
                    <div class="relative z-10 flex flex-col items-center gap-2">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-[13px] transition-all duration-300"
                             :class="currentStep === step.id ? 'bg-adzkia-blue text-white shadow-lg shadow-adzkia-blue/30 scale-110' : (step.id < currentStep ? 'bg-green-500 text-white border-2 border-green-500' : 'bg-white border-2 border-gray-100 text-gray-400')">
                            <span x-show="step.id < currentStep"><i data-feather="check" class="w-4 h-4"></i></span>
                            <span x-show="step.id >= currentStep" x-text="step.id"></span>
                        </div>
                        <span class="text-[9px] font-black uppercase tracking-widest hidden md:block" 
                              :class="currentStep === step.id ? 'text-adzkia-blue' : (step.id < currentStep ? 'text-green-500' : 'text-gray-400')" 
                              x-text="step.title"></span>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <main class="flex-1 max-w-4xl mx-auto w-full px-6 py-12">
        <div class="bg-white p-8 md:p-12 rounded-[2.5rem] shadow-sm border border-gray-100">
            
            <div class="mb-8 text-center md:text-left">
                <span class="inline-block px-3 py-1 bg-adzkia-badge-bg text-adzkia-blue rounded-lg text-[11px] font-black uppercase tracking-widest mb-3">STEP 03 / 07</span>
                <h1 class="text-3xl font-black text-adzkia-dark tracking-tight mb-4">Validasi Pembayaran</h1>
    
                @if($pendaftar->status_pembayaran == 'Menunggu Validasi')
                    <div class="bg-amber-50 border border-amber-200 text-amber-700 p-4 rounded-xl font-bold mb-4 flex gap-3 items-start text-left">
                        <i data-feather="clock" class="w-5 h-5 shrink-0 mt-0.5"></i>
                        <span>Bukti pembayaran sedang diperiksa oleh Admin. Mohon tunggu maksimal 1x24 jam hari kerja.</span>
                    </div>
                @elseif($pendaftar->status_pembayaran == 'Terverifikasi')
                    <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-xl font-bold mb-4 flex gap-3 items-center text-left">
                        <i data-feather="check-circle" class="w-5 h-5 shrink-0"></i>
                        <span>Pembayaran Berhasil! Anda sudah bisa lanjut ke tahap pengisian biodata.</span>
                        <a href="{{ route('pendaftaran.biodata') }}" class="underline hover:text-green-800 transition-colors ml-auto text-sm shrink-0">Lanjut Biodata &rarr;</a>
                    </div>
                @endif
            </div>

            @if($pendaftar->status_pembayaran != 'Terverifikasi')
            <div class="bg-amber-50 border border-amber-100 rounded-2xl p-5 flex gap-4 items-start mb-8">
                <div class="w-6 h-6 rounded-full bg-amber-500 text-white flex items-center justify-center shrink-0 mt-0.5">
                    <i data-feather="info" class="w-4 h-4"></i>
                </div>
                <div>
                    <h4 class="text-[13px] font-black text-amber-900 mb-1">Menunggu Upload Bukti Pembayaran</h4>
                    <p class="text-[12px] font-medium text-amber-700/80 leading-relaxed">
                        Silakan unggah dokumen bukti transfer Anda untuk memproses validasi.
                    </p>
                </div>
            </div>

            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-4 mb-8">
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Program Studi</p>
                    <h4 class="text-[14px] font-extrabold text-adzkia-dark">{{ $pendaftar->pilihan_jurusan_1 ?? '-' }}</h4>
                </div>
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Jalur Pendaftaran</p>
                    <h4 class="text-[14px] font-extrabold text-adzkia-dark">{{ $pendaftar->jalur_pendaftaran ?? '-' }}</h4>
                </div>
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Total Bayar</p>
                    <h4 class="text-[14px] font-extrabold text-adzkia-dark">Rp {{ number_format($pendaftar->nominal_biaya ?? 0, 0, ',', '.') }}</h4>
                </div>
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Metode Pembayaran</p>
                    <h4 class="text-[14px] font-extrabold text-adzkia-dark">{{ $pendaftar->metode_pembayaran ?? '-' }}</h4>
                </div>
            </div>

            <div class="mb-8">
                <div class="relative w-full h-40 rounded-2xl border-2 border-dashed transition-all duration-300 flex flex-col items-center justify-center cursor-pointer group overflow-hidden"
                      :class="isDragging ? 'border-adzkia-blue bg-blue-50/50 scale-[1.02]' : 'border-gray-300 bg-white hover:border-adzkia-blue hover:bg-blue-50/30'"
                      @dragover.prevent="isDragging = true"
                      @dragleave.prevent="isDragging = false"
                      @drop.prevent="handleDrop($event)"
                      @click="$refs.fileInput.click()">
                    
                    <input type="file" x-ref="fileInput" @change="handleFileSelect($event)" class="hidden" accept=".jpg,.jpeg,.png,.pdf">
                    
                    <div class="flex flex-col items-center justify-center p-6 text-center pointer-events-none" x-show="!fileName">
                        <div class="w-12 h-12 rounded-xl bg-gray-100 text-gray-400 flex items-center justify-center mb-4 group-hover:text-adzkia-blue group-hover:scale-110 transition-all">
                            <i data-feather="upload" class="w-6 h-6"></i>
                        </div>
                        <h4 class="text-[14px] font-extrabold text-adzkia-dark mb-1 group-hover:text-adzkia-blue transition-colors">Klik atau drag & drop bukti pembayaran di sini</h4>
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">JPG, PNG, PDF, MAKS 2MB</p>
                    </div>

                    <div class="flex flex-col items-center justify-center p-6 text-center pointer-events-none w-full h-full bg-adzkia-badge-bg" x-show="fileName" x-cloak>
                        <div class="w-12 h-12 rounded-xl bg-adzkia-blue text-white flex items-center justify-center mb-3">
                            <i data-feather="file" class="w-6 h-6"></i>
                        </div>
                        <h4 class="text-[14px] font-extrabold text-adzkia-blue line-clamp-1 px-4" x-text="fileName"></h4>
                        <p class="text-[11px] font-bold text-adzkia-blue/70 uppercase tracking-widest mt-1">Ganti File</p>
                    </div>
                </div>
            </div>

            <div class="space-y-3 mb-10 border-b border-gray-100 pb-8">
                <div class="flex items-start gap-3">
                    <i data-feather="check-circle" class="w-4 h-4 text-gray-400 shrink-0 mt-0.5"></i>
                    <p class="text-[12px] font-medium text-gray-500">Pastikan nominal transfer sesuai dengan tagihan hingga 3 digit terakhir.</p>
                </div>
                <div class="flex items-start gap-3">
                    <i data-feather="check-circle" class="w-4 h-4 text-gray-400 shrink-0 mt-0.5"></i>
                    <p class="text-[12px] font-medium text-gray-500">Bukti pembayaran harus terlihat jelas, tidak terpotong, dan tidak blur.</p>
                </div>
                <div class="flex items-start gap-3">
                    <i data-feather="check-circle" class="w-4 h-4 text-gray-400 shrink-0 mt-0.5"></i>
                    <p class="text-[12px] font-medium text-gray-500">Format file didukung: .jpg, .png, atau .pdf dengan ukuran maksimal 2MB.</p>
                </div>
            </div>

            <div class="flex flex-col md:flex-row items-center justify-between gap-6 mb-8">
                <div class="flex items-center gap-2 text-[11px] font-bold text-gray-400 w-full md:w-auto">
                    <i data-feather="clock" class="w-3.5 h-3.5"></i> Estimasi waktu verifikasi: 1x24 jam
                </div>
                <p class="text-[11px] font-bold text-gray-400 w-full md:w-auto md:text-right">
                    Butuh bantuan? <a href="#" class="text-adzkia-dark hover:text-adzkia-blue underline underline-offset-2">Hubungi Admin</a>
                </p>
            </div>

            <form action="{{ route('user.upload-bukti') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Memanfaatkan sinkronisasi dari Alpine $refs ke input form asli saat upload form di-submit -->
                <input type="file" name="bukti_pembayaran" x-ref="formFileInput" class="hidden" accept=".jpg,.jpeg,.png,.pdf">

                <div class="flex flex-col items-center gap-4">
                    <button type="submit" 
                            :disabled="!fileName"
                            class="w-full py-4 rounded-2xl font-black text-[15px] transition-all active:scale-[0.98] shadow-lg flex items-center justify-center gap-2"
                            :class="fileName ? 'bg-adzkia-red text-white hover:bg-red-700 shadow-red-600/20' : 'bg-gray-200 text-gray-400 cursor-not-allowed'">
                        Upload Sekarang <i data-feather="upload-cloud" class="w-4 h-4" x-show="fileName"></i>
                    </button>
    
                    <a href="/pembayaran" class="text-[13px] font-extrabold text-gray-500 hover:text-adzkia-blue transition-colors py-2">
                        Kembali ke Pilihan Metode
                    </a>
                </div>
            </form>
            @endif

        </div>
    </main>

    <footer class="w-full bg-adzkia-bg py-8 flex flex-col md:flex-row justify-center md:justify-between items-center gap-4 px-10">
        <p class="text-[11px] font-bold text-gray-400">© 2026 Universitas Adzkia. All Rights Reserved.</p>
        <div class="flex gap-8 text-[11px] font-bold text-gray-500">
            <a href="#" class="hover:text-adzkia-blue transition-colors">Privacy Policy</a>
            <a href="#" class="hover:text-adzkia-blue transition-colors">Contact Support</a>
        </div>
    </footer>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('uploadApp', () => ({
                currentStep: 3,
                isDragging: false,
                fileName: null,
                steps: [
                    { id: 1, title: 'Pendaftaran' }, { id: 2, title: 'Biaya' },
                    { id: 3, title: 'Validasi' }, { id: 4, title: 'Biodata' },
                    { id: 5, title: 'Konfirmasi' }, { id: 6, title: 'Cek Admin' },
                    { id: 7, title: 'Hasil' }
                ],
                handleDrop(e) {
                    this.isDragging = false;
                    if (e.dataTransfer.files.length > 0) {
                        this.fileName = e.dataTransfer.files[0].name;
                        // Sinkronkan file yang didrop ke input tersembunyi milik form submission
                        this.$refs.formFileInput.files = e.dataTransfer.files;
                        this.$refs.fileInput.files = e.dataTransfer.files;
                        this.refreshIcon();
                    }
                },
                handleFileSelect(e) {
                    if (e.target.files.length > 0) {
                        this.fileName = e.target.files[0].name;
                        // Sinkronkan ke input tersembunyi form
                        this.$refs.formFileInput.files = e.target.files;
                        this.refreshIcon();
                    }
                },
                refreshIcon() {
                    this.$nextTick(() => {
                        if(window.feather) feather.replace();
                    });
                }
            }));
        });
        document.addEventListener('DOMContentLoaded', () => {
            feather.replace();
        });
    </script>
</body>
</html>