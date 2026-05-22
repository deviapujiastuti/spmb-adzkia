<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi Pembayaran - SPMB Adzkia</title>
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
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-brand-bg antialiased text-brand-dark min-h-screen flex flex-col" x-data="uploadApp()">

    <nav class="w-full bg-white py-8 border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-6">
            <div class="flex items-center justify-between relative">
                <div class="absolute top-5 left-0 w-full h-0.5 bg-gray-100 z-0"></div>
                <div class="absolute top-5 left-0 h-0.5 bg-brand-dark z-0 transition-all duration-500" style="width: 33.33%;"></div>
                
                <template x-for="step in steps" :key="step.id">
                    <div class="relative z-10 flex flex-col items-center gap-3 w-20">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-extrabold text-[13px] transition-all duration-300"
                             :class="{
                                 'bg-brand-dark text-white': step.id < currentStep,
                                 'bg-brand-blue text-white shadow-lg shadow-brand-blue/30 scale-110 ring-4 ring-brand-blue-light': step.id === currentStep,
                                 'bg-white border-2 border-gray-200 text-gray-300': step.id > currentStep
                             }">
                            <template x-if="step.id < currentStep">
                                <i data-feather="check" class="w-5 h-5"></i>
                            </template>
                            <template x-if="step.id >= currentStep">
                                <span x-text="step.id"></span>
                            </template>
                        </div>
                        <span class="text-[9px] font-black uppercase tracking-widest text-center"
                              :class="step.id === currentStep ? 'text-brand-dark' : 'text-gray-400'"
                              x-text="step.title"></span>
                    </div>
                </template>
            </div>
        </div>
    </nav>

    <main class="flex-1 max-w-4xl mx-auto w-full px-6 py-12">
        <div class="bg-white p-8 md:p-12 rounded-[2.5rem] shadow-xl shadow-brand-dark/5 border border-gray-100">
            
            <div class="mb-8">
                <h1 class="text-3xl font-black text-brand-dark tracking-tight mb-4">Validasi Pembayaran</h1>
    
                    @if($pendaftar->status_pembayaran == 'Menunggu Validasi')
                        <div class="bg-amber-50 border border-amber-200 text-amber-700 p-4 rounded-xl font-bold mb-4">
                            Bukti pembayaran sedang diperiksa oleh Admin. Mohon tunggu 1x24 jam.
                        </div>
                    @elseif($pendaftar->status_pembayaran == 'Terverifikasi')
                        <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-xl font-bold mb-4">
                            Pembayaran Berhasil! Anda sudah bisa lanjut ke tahap berikutnya.
                        <a href="{{ route('pendaftaran.biodata') }}" class="underline ml-2">Klik di sini</a>
                        </div>
                    @endif
            </div>

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
                    <h4 class="text-[14px] font-extrabold text-brand-dark">{{ $pendaftar->pilihan_jurusan_1 }}</h4>
                </div>
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Jalur Pendaftaran</p>
                    <h4 class="text-[14px] font-extrabold text-brand-dark">{{ $pendaftar->jalur_pendaftaran }}</h4>
                </div>
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Total Bayar</p>
                    <h4 class="text-[14px] font-extrabold text-brand-dark">Rp {{ number_format($pendaftar->nominal_biaya ?? 0, 0, ',', '.') }}</h4>
                </div>
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Metode Pembayaran</p>
                    <h4 class="text-[14px] font-extrabold text-brand-dark">{{ $pendaftar->metode_pembayaran }}</h4>
                </div>
            </div>

            <div class="mb-8">
                <div class="relative w-full h-40 rounded-2xl border-2 border-dashed transition-all duration-300 flex flex-col items-center justify-center cursor-pointer group overflow-hidden"
                      :class="isDragging ? 'border-brand-blue bg-brand-blue-light scale-[1.02]' : 'border-gray-300 bg-white hover:border-gray-400 hover:bg-gray-50'"
                      @dragover.prevent="isDragging = true"
                      @dragleave.prevent="isDragging = false"
                      @drop.prevent="handleDrop($event)"
                      @click="$refs.fileInput.click()">
                    
                    <input type="file" x-ref="fileInput" @change="handleFileSelect($event)" class="hidden" accept=".jpg,.jpeg,.png,.pdf">
                    
                    <div class="flex flex-col items-center justify-center p-6 text-center pointer-events-none" x-show="!fileName">
                        <div class="w-12 h-12 rounded-xl bg-gray-100 text-gray-400 flex items-center justify-center mb-4 group-hover:text-brand-dark group-hover:scale-110 transition-all">
                            <i data-feather="upload" class="w-6 h-6"></i>
                        </div>
                        <h4 class="text-[14px] font-extrabold text-brand-dark mb-1">Klik atau drag & drop bukti pembayaran di sini</h4>
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">JPG, PNG, PDF, MAKS 2MB</p>
                    </div>

                    <div class="flex flex-col items-center justify-center p-6 text-center pointer-events-none w-full h-full bg-brand-blue-light" x-show="fileName" x-cloak>
                        <div class="w-12 h-12 rounded-xl bg-brand-blue text-white flex items-center justify-center mb-3">
                            <i data-feather="file" class="w-6 h-6"></i>
                        </div>
                        <h4 class="text-[14px] font-extrabold text-brand-blue line-clamp-1 px-4" x-text="fileName"></h4>
                        <p class="text-[11px] font-bold text-brand-blue/70 uppercase tracking-widest mt-1">Ganti File</p>
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
                    Butuh bantuan? <a href="#" class="text-brand-dark hover:text-brand-blue underline underline-offset-2">Hubungi Admin</a>
                </p>
            </div>

            <form action="{{ route('user.upload-bukti') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <input type="file" 
                    name="bukti_bayar" 
                    x-ref="fileInput" 
                    @change="handleFileSelect($event)" 
                    class="hidden" 
                    accept=".jpg,.jpeg,.png">

                    <div class="flex flex-col items-center gap-4">
                        <button type="submit" 
                                :disabled="!fileName"
                                class="w-full py-4 rounded-2xl font-black text-[15px] transition-all active:scale-[0.98] shadow-lg"
                                :class="fileName ? 'bg-brand-dark text-white hover:bg-brand-blue shadow-brand-dark/20' : 'bg-gray-200 text-gray-400 cursor-not-allowed'">
                            Upload Sekarang
                        </button>
        
                        <a href="/pembayaran" class="text-[13px] font-extrabold text-gray-500 hover:text-brand-dark transition-colors py-2">
                        Kembali
                        </a>
                    </div>
                </form>
        </div>
    </main>

    <footer class="w-full bg-brand-bg py-8 flex flex-col md:flex-row justify-center md:justify-between items-center gap-4 px-10">
        <p class="text-[11px] font-bold text-gray-400">© 2026 Universitas Adzkia. All Rights Reserved.</p>
        <div class="flex gap-8 text-[11px] font-bold text-brand-gray">
            <a href="#" class="hover:text-brand-blue transition-colors">Privacy Policy</a>
            <a href="#" class="hover:text-brand-blue transition-colors">Contact Support</a>
            <a href="#" class="hover:text-brand-blue transition-colors">Terms of Service</a>
        </div>
    </footer>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('uploadApp', () => ({
                currentStep: 3,
                isDragging: false,
                fileName: null,
                steps: [
                    { id: 1, title: 'Pendaftaran' },
                    { id: 2, title: 'Biaya Pendaftaran' },
                    { id: 3, title: 'Validasi Pembayaran' },
                    { id: 4, title: 'Biodata' },
                    { id: 5, title: 'Dokumen' },
                    { id: 6, title: 'Ujian' },
                    { id: 7, title: 'Hasil' }
                ],
                handleDrop(e) {
                    this.isDragging = false;
                    if (e.dataTransfer.files.length > 0) {
                        this.fileName = e.dataTransfer.files[0].name;
                        this.refreshIcon();
                    }
                },
                handleFileSelect(e) {
                    if (e.target.files.length > 0) {
                        this.fileName = e.target.files[0].name;
                        this.refreshIcon();
                    }
                },
                uploadSekarang() {
                    if (!this.fileName) {
                        alert('Silakan pilih atau tarik file bukti pembayaran terlebih dahulu!');
                        return;
                    }
                    alert('Bukti berhasil diunggah! Mohon tunggu validasi admin.');
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