<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biaya Pendaftaran - SPMB Adzkia</title>
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
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-adzkia-bg antialiased text-adzkia-dark min-h-screen flex flex-col" x-data="paymentApp()">

    <nav class="w-full bg-white py-8 border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-6">
            <div class="flex items-center justify-between relative">
                <div class="absolute top-5 left-0 w-full h-0.5 bg-gray-100 z-0"></div>
                <div class="absolute top-5 left-0 h-0.5 bg-adzkia-blue z-0 transition-all duration-500" style="width: 16.6%;"></div>
                
                <template x-for="step in steps" :key="step.id">
                    <div class="relative z-10 flex flex-col items-center gap-3 w-20">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-extrabold text-[13px] transition-all duration-300"
                             :class="{
                                 'bg-adzkia-blue text-white': step.id < currentStep,
                                 'bg-adzkia-red text-white shadow-lg shadow-red-600/30 scale-110 ring-4 ring-red-50': step.id === currentStep,
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
                              :class="step.id === currentStep ? 'text-adzkia-blue' : 'text-gray-400'"
                              x-text="step.title"></span>
                    </div>
                </template>
            </div>
        </div>
    </nav>

    <main class="flex-1 max-w-3xl mx-auto w-full px-6 py-12">
        <div class="bg-white p-8 md:p-12 rounded-[2.5rem] shadow-xl shadow-adzkia-dark/5 border border-gray-100">
            
            <div class="mb-10 border-b border-gray-100 pb-8">
                <h1 class="text-3xl font-black text-adzkia-blue tracking-tight mb-4">Biaya Pendaftaran</h1>
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 bg-adzkia-badge-bg text-adzkia-blue rounded-md text-[10px] font-black uppercase tracking-widest">S1 Informatika</span>
                    <span class="px-3 py-1 bg-gray-100 text-gray-500 rounded-md text-[10px] font-black uppercase tracking-widest">Jalur Reguler</span>
                </div>
            </div>

            <div class="bg-[#F8FAFC] rounded-2xl p-6 md:p-8 mb-10 border border-gray-100 space-y-4">
                <div class="flex justify-between items-center text-[14px] font-bold text-gray-500">
                    <span>Biaya Pendaftaran</span>
                    <span class="text-adzkia-dark">Rp 250.000</span>
                </div>
                <div class="w-full h-px bg-gray-200"></div>
                <div class="flex justify-between items-center">
                    <span class="text-[14px] font-bold text-gray-500">Total Pembayaran</span>
                    <span class="text-2xl font-black text-adzkia-dark">Rp 250.000</span>
                </div>
            </div>

            <div class="mb-10">
                <h3 class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-4">Pilih Metode Pembayaran</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    
                    <button @click="method = 'bank'" 
                            class="p-4 rounded-2xl border-2 flex items-center gap-3 transition-all duration-200"
                            :class="method === 'bank' ? 'border-adzkia-blue bg-blue-50/30 shadow-md ring-2 ring-adzkia-blue/10' : 'border-gray-100 bg-white hover:border-adzkia-blue'">
                        <i data-feather="monitor" class="w-5 h-5 text-adzkia-dark"></i>
                        <span class="text-[13px] font-extrabold text-adzkia-dark">Bank Transfer</span>
                    </button>

                    <button @click="method = 'va'" 
                            class="p-4 rounded-2xl border-2 flex items-center justify-between transition-all duration-200 relative"
                            :class="method === 'va' ? 'border-adzkia-blue bg-blue-50/30 shadow-md ring-2 ring-adzkia-blue/10' : 'border-gray-100 bg-white hover:border-adzkia-blue'">
                        <div class="flex items-center gap-3">
                            <i data-feather="credit-card" class="w-5 h-5 text-adzkia-dark"></i>
                            <span class="text-[13px] font-extrabold text-adzkia-dark">Virtual Account</span>
                        </div>
                        <div x-show="method === 'va'" class="text-adzkia-blue">
                            <i data-feather="check-circle" class="w-4 h-4"></i>
                        </div>
                    </button>

                    <button @click="method = 'ewallet'" 
                            class="p-4 rounded-2xl border-2 flex items-center gap-3 transition-all duration-200"
                            :class="method === 'ewallet' ? 'border-adzkia-blue bg-blue-50/30 shadow-md ring-2 ring-adzkia-blue/10' : 'border-gray-100 bg-white hover:border-adzkia-blue'">
                        <i data-feather="smartphone" class="w-5 h-5 text-adzkia-dark"></i>
                        <span class="text-[13px] font-extrabold text-adzkia-dark">E-Wallet</span>
                    </button>

                </div>
            </div>

            <div x-show="method === 'va'" x-collapse x-cloak>
                <div class="bg-gray-50 rounded-2xl p-6 md:p-8 border border-gray-100 mb-10">
                    
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center border border-gray-100 overflow-hidden">
                            <div class="w-full h-full bg-blue-900 flex items-center justify-center text-white text-[10px] font-black">MANDIRI</div>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Bank Penerima</p>
                            <h4 class="text-[15px] font-extrabold text-adzkia-dark">Bank Mandiri</h4>
                        </div>
                    </div>

                    <div class="mb-6">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Nomor Virtual Account</p>
                        <div class="flex items-center justify-between">
                            <h2 class="text-2xl md:text-3xl font-black text-adzkia-dark tracking-widest">8829 1029 3847 221</h2>
                            <button @click="copyVA('882910293847221')" class="flex items-center gap-1.5 text-[13px] font-black text-adzkia-red hover:text-red-700 transition-colors">
                                <i data-feather="copy" class="w-4 h-4"></i> 
                                <span x-text="copied ? 'Tersalin!' : 'Salin'"></span>
                            </button>
                        </div>
                    </div>

                    <div class="mb-8">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Nama Rekening</p>
                        <h4 class="text-[15px] font-extrabold text-adzkia-dark">SPMB ADMISSION</h4>
                    </div>

                    <div class="bg-red-50/80 border border-red-100 rounded-2xl p-5 flex gap-4 items-start">
                        <i data-feather="info" class="w-5 h-5 text-adzkia-red shrink-0 mt-0.5"></i>
                        <p class="text-[13px] font-medium text-red-900 leading-relaxed">
                            <span class="font-extrabold">Penting:</span> <br>
                            Batas waktu pembayaran: <span class="font-extrabold">Oct 20, 2026 (23:59 WIB)</span>. Gunakan kode unik yang diberikan untuk mempercepat proses validasi otomatis.
                        </p>
                    </div>

                </div>
            </div>

            <div x-show="method === 'bank'" x-collapse x-cloak>
                <div class="bg-gray-50 rounded-2xl p-8 border border-gray-100 mb-10 text-center">
                    <p class="text-[14px] font-bold text-gray-500">Silakan transfer manual ke nomor rekening yang akan ditampilkan selanjutnya.</p>
                </div>
            </div>
            
            <div x-show="method === 'ewallet'" x-collapse x-cloak>
                <div class="bg-gray-50 rounded-2xl p-8 border border-gray-100 mb-10 text-center">
                    <p class="text-[14px] font-bold text-gray-500">Scan QRIS melalui aplikasi e-wallet pilihan Anda (GoPay, OVO, Dana, dll).</p>
                </div>
            </div>

            <div class="flex flex-col items-center gap-4">
                <button @click="bayarSekarang()" class="w-full py-4 bg-adzkia-red text-white rounded-2xl font-black text-[15px] hover:bg-red-700 shadow-lg shadow-red-600/20 transition-all active:scale-[0.98]">
                    Bayar Sekarang
                </button>
                <a href="/register" class="text-[13px] font-extrabold text-gray-500 hover:text-adzkia-blue transition-colors py-2">
                    Kembali
                </a>
            </div>

        </div>
    </main>

    <footer class="w-full bg-adzkia-bg py-8 flex flex-col md:flex-row justify-center md:justify-between items-center gap-4 px-10 border-t border-gray-100">
        <p class="text-[11px] font-bold text-gray-400">© 2026 Universitas Adzkia. All Rights Reserved.</p>
        <div class="flex gap-8 text-[11px] font-bold text-gray-500">
            <a href="#" class="hover:text-adzkia-blue transition-colors">Privacy Policy</a>
            <a href="#" class="hover:text-adzkia-blue transition-colors">Contact Support</a>
            <a href="#" class="hover:text-adzkia-blue transition-colors">Terms of Service</a>
        </div>
    </footer>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('paymentApp', () => ({
                currentStep: 2,
                method: 'va', // Default terpilih: Virtual Account
                copied: false,
                
                steps: [
                    { id: 1, title: 'Pendaftaran' },
                    { id: 2, title: 'Biaya Pendaftaran' },
                    { id: 3, title: 'Validasi Pembayaran' },
                    { id: 4, title: 'Biodata' },
                    { id: 5, title: 'Dokumen' },
                    { id: 6, title: 'Ujian' },
                    { id: 7, title: 'Hasil' }
                ],

                copyVA(text) {
                    navigator.clipboard.writeText(text).then(() => {
                        this.copied = true;
                        setTimeout(() => {
                            this.copied = false;
                        }, 2000); // Tulisan kembali menjadi "Salin" setelah 2 detik
                    });
                },

                bayarSekarang() {
                    // Logic ketika klik bayar, bisa diarahkan ke halaman validasi/upload
                    alert("Melanjutkan ke Step 3: Validasi Pembayaran...");
                    window.location.href = '/validasi-pembayaran';
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