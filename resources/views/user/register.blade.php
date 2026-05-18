<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Akun - SPMB Adzkia</title>
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
<body class="bg-brand-bg antialiased text-brand-dark min-h-screen flex flex-col" x-data="registerApp()">

    <nav class="w-full bg-white border-b border-gray-100 py-6 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center justify-between max-w-4xl mx-auto relative">
                <div class="absolute top-1/2 left-0 w-full h-0.5 bg-gray-100 -translate-y-1/2 z-0"></div>
                
                <template x-for="step in steps" :key="step.id">
                    <div class="relative z-10 flex flex-col items-center gap-2">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-[13px] transition-all duration-300"
                             :class="currentStep === step.id ? 'bg-brand-blue text-white shadow-lg shadow-brand-blue/30 scale-110' : 'bg-white border-2 border-gray-100 text-gray-400'">
                            <span x-text="step.id"></span>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-widest hidden md:block"
                              :class="currentStep === step.id ? 'text-brand-dark' : 'text-gray-400'"
                              x-text="step.title"></span>
                    </div>
                </template>
            </div>
        </div>
    </nav>

    <main class="flex-1 max-w-7xl mx-auto px-6 py-16 grid grid-cols-1 lg:grid-cols-2 gap-20 items-start">
        
        <div class="space-y-10">
            <div>
                <span class="px-3 py-1 bg-brand-blue-light text-brand-blue rounded-lg text-[11px] font-black uppercase tracking-widest">
                    STEP 01 / 07
                </span>
                <h1 class="text-5xl md:text-6xl font-black text-brand-dark tracking-tight leading-[1.1] mt-6">
                    Mulai Perjalanan <br> <span class="text-brand-blue">Akademik Anda.</span>
                </h1>
                <p class="text-[16px] font-medium text-brand-gray leading-relaxed mt-8 max-w-md">
                    Buat akun Anda untuk memulai proses aplikasi Anda. Kami telah menyusun pengalaman pendaftaran yang disederhanakan untuk generasi cendekiawan berikutnya.
                </p>
            </div>

            <div class="flex items-center gap-4">
                <div class="flex -space-x-3">
                    <img src="https://ui-avatars.com/api/?name=Andi&background=0F172A&color=fff" class="w-10 h-10 rounded-full border-2 border-white">
                    <img src="https://ui-avatars.com/api/?name=Siti&background=2563EB&color=fff" class="w-10 h-10 rounded-full border-2 border-white">
                    <img src="https://ui-avatars.com/api/?name=Budi&background=64748B&color=fff" class="w-10 h-10 rounded-full border-2 border-white">
                </div>
                <p class="text-[13px] font-bold text-brand-gray">
                    <span class="text-brand-dark font-black">2,400+</span> applicants join this yr.
                </p>
            </div>
        </div>

        <div class="bg-white p-10 md:p-12 rounded-[2.5rem] shadow-xl shadow-brand-dark/5 border border-gray-100">
            <div class="mb-10">
                <h2 class="text-2xl font-black text-brand-dark tracking-tight">Student Registration</h2>
                <p class="text-[13px] font-medium text-brand-gray mt-1">Please provide your valid credentials to proceed.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-600 text-sm font-bold rounded-2xl">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter your full name" class="w-full px-6 py-4 bg-gray-50 border-transparent rounded-2xl outline-none focus:ring-2 focus:ring-brand-blue/10 focus:bg-white transition-all font-bold text-[14px]" required>
                </div>

                <div>
                    <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="email@university.edu" class="w-full px-6 py-4 bg-gray-50 border-transparent rounded-2xl outline-none focus:ring-2 focus:ring-brand-blue/10 focus:bg-white transition-all font-bold text-[14px]" required>
                </div>

                <div>
                    <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Phone Number</label>
                    <div class="relative">
                        <span class="absolute left-6 top-1/2 -translate-y-1/2 text-gray-400 font-bold text-[14px]">+62</span>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="812 3456 7890" class="w-full pl-16 pr-6 py-4 bg-gray-50 border-transparent rounded-2xl outline-none focus:ring-2 focus:ring-brand-blue/10 focus:bg-white transition-all font-bold text-[14px]" required>
                    </div>
                </div>

                <div x-data="{ show: false }">
                    <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Create Password</label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" name="password" placeholder="••••••••••••" class="w-full px-6 py-4 bg-gray-50 border-transparent rounded-2xl outline-none focus:ring-2 focus:ring-brand-blue/10 focus:bg-white transition-all font-bold text-[14px]" required>
                        <button type="button" @click="show = !show" class="absolute right-6 top-1/2 -translate-y-1/2 text-gray-400 hover:text-brand-dark transition-colors">
                            <i :data-feather="show ? 'eye-off' : 'eye'" class="w-5 h-5"></i>
                        </button>
                    </div>
                    <p class="text-[10px] font-bold text-gray-400 mt-3 px-1">Must be at least 8 characters with numbers and symbols.</p>
                </div>

                <div class="flex items-center justify-between pt-6">
                    <button type="button" class="flex items-center gap-2 text-[13px] font-black text-gray-400 hover:text-brand-dark transition-colors uppercase tracking-widest">
                        <i data-feather="arrow-left" class="w-4 h-4"></i> Back
                    </button>
                    <button type="submit" class="px-10 py-4 bg-brand-dark text-white rounded-2xl font-black text-[14px] hover:bg-brand-blue shadow-lg shadow-brand-dark/20 transition-all flex items-center gap-3 active:scale-95 group">
                        Next Step <i data-feather="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </div>
            </form>
        </div>
    </main>

    <section class="max-w-7xl mx-auto px-6 pb-24">
        <h3 class="text-2xl font-black text-brand-dark tracking-tight mb-10">Dokumen yang Dibutuhkan</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-md transition-all group">
                <div class="w-12 h-12 bg-brand-blue-light text-brand-blue rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <i data-feather="user" class="w-6 h-6"></i>
                </div>
                <h4 class="font-extrabold text-[15px] text-brand-dark mb-2">Identitas Pribadi</h4>
                <p class="text-[12px] font-medium text-gray-400 leading-relaxed mb-6">Persiapan scan KTP/Paspor dan Kartu Keluarga(KK).</p>
                <span class="px-3 py-1 bg-gray-100 text-gray-500 rounded text-[9px] font-black uppercase tracking-widest">Wajib</span>
            </div>

            <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-md transition-all group">
                <div class="w-12 h-12 bg-blue-50 text-blue-400 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <i data-feather="file-text" class="w-6 h-6"></i>
                </div>
                <h4 class="font-extrabold text-[15px] text-brand-dark mb-2">Riwayat Akademik</h4>
                <p class="text-[12px] font-medium text-gray-400 leading-relaxed mb-6">Scan Rapor Sekolah Menengah Atas (SMA) dari Semester 1-5</p>
                <span class="px-3 py-1 bg-gray-100 text-gray-500 rounded text-[9px] font-black uppercase tracking-widest">Wajib</span>
            </div>

            <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-md transition-all group">
                <div class="w-12 h-12 bg-indigo-50 text-indigo-400 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <i data-feather="award" class="w-6 h-6"></i>
                </div>
                <h4 class="font-extrabold text-[15px] text-brand-dark mb-2">Sertifikat</h4>
                <p class="text-[12px] font-medium text-gray-400 leading-relaxed mb-6">Sertifikat Penghargaan Seni, Olahraga, Akademik, dan Sejenisnya</p>
                <span class="px-3 py-1 bg-brand-blue-light text-brand-blue rounded text-[9px] font-black uppercase tracking-widest">Opsional</span>
            </div>
        </div>
    </section>

    <footer class="w-full bg-white border-t border-gray-100 py-8 px-10 flex flex-col md:flex-row justify-between items-center gap-4">
        <p class="text-[11px] font-bold text-gray-400">© 2026 Universitas Adzkia. All Rights Reserved.</p>
        <div class="flex gap-8 text-[11px] font-bold text-brand-gray">
            <a href="#" class="hover:text-brand-blue transition-colors">Privacy Policy</a>
            <a href="#" class="hover:text-brand-blue transition-colors">Contact Support</a>
            <a href="#" class="hover:text-brand-blue transition-colors">Terms of Service</a>
        </div>
    </footer>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('registerApp', () => ({
                currentStep: 1,
                steps: [
                    { id: 1, title: 'Pendaftaran' },
                    { id: 2, title: 'Biaya Pendaftaran' },
                    { id: 3, title: 'Validasi Pembayaran' },
                    { id: 4, title: 'Biodata' },
                    { id: 5, title: 'Dokumen' },
                    { id: 6, title: 'Ujian' },
                    { id: 7, title: 'Hasil' }
                ]
            }));
        });

        document.addEventListener('DOMContentLoaded', () => {
            feather.replace();
        });
    </script>
</body>
</html>