<!DOCTYPE html>
<html lang="id" class="dark scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioLink — Modern Link-in-Bio Platform with AI Assistant</title>

    <meta name="description" content="Platform link-in-bio modern dengan asisten AI pintar. Kumpulkan semua link penting, portofolio, dan kontak Anda dalam satu URL elegan.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=DM+Mono:wght@500;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #09090b;
            color: #f4f4f5;
            overflow-x: hidden;
        }
        .font-mono {
            font-family: 'DM Mono', monospace;
        }
        .glow-radial {
            background: radial-gradient(circle at 50% 0%, rgba(14, 165, 233, 0.15) 0%, rgba(99, 102, 241, 0.08) 40%, transparent 70%);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col bg-zinc-950 text-zinc-100 antialiased selection:bg-sky-500 selection:text-white">

    <!-- ========================================================================= -->
    <!-- 1. HEADER & NAVBAR (BERSIH & TO THE POINT)                                -->
    <!-- ========================================================================= -->
    <header class="h-20 border-b border-zinc-800/80 bg-zinc-950/80 backdrop-blur-xl sticky top-0 z-50 px-6 sm:px-12">
        <nav class="max-w-6xl mx-auto h-full flex items-center justify-between">
            
            <!-- Logo Brand -->
            <a href="/" class="flex items-center gap-2.5 font-black text-xl tracking-tight text-white group">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-sky-400 to-indigo-600 flex items-center justify-center text-white shadow-lg shadow-sky-500/25 transition-transform group-hover:scale-105">
                    <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
                        <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
                    </svg>
                </div>
                <span class="text-white">BioLink<span class="text-sky-400">.</span></span>
            </a>

            <!-- Nav Links -->
            <div class="hidden sm:flex items-center gap-6 text-xs font-semibold text-zinc-400">
                <a href="#fitur" class="hover:text-white transition-colors">Fitur</a>
                <a href="/@windri" target="_blank" class="hover:text-white transition-colors flex items-center gap-1 text-sky-400">
                    <span>Lihat Contoh Bio</span>
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6m4-3h6v6m-11 5L21 3"/></svg>
                </a>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-xl bg-sky-500 hover:bg-sky-400 text-white text-xs font-bold transition-all shadow-lg shadow-sky-500/25 flex items-center gap-1.5">
                        <span>Studio Dasbor</span>
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14m-7-7 7 7-7 7"/></svg>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-3.5 py-2 rounded-xl text-zinc-300 hover:text-white text-xs font-bold hover:bg-zinc-800 transition-colors">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="px-4 py-2 rounded-xl bg-white text-zinc-950 hover:bg-zinc-200 text-xs font-black transition-all shadow-md flex items-center gap-1">
                        <span>Daftar Gratis</span>
                    </a>
                @endauth
            </div>

        </nav>
    </header>


    <!-- ========================================================================= -->
    <!-- 2. BODY / MAIN (HANYA INFORMASI PENTING)                                  -->
    <!-- ========================================================================= -->
    <main class="flex-grow">

        <!-- HERO SECTION -->
        <section class="relative pt-16 sm:pt-24 pb-20 px-6 sm:px-12 glow-radial flex flex-col items-center text-center">
            
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-sky-500/10 border border-sky-400/25 text-sky-300 text-xs font-bold mb-6">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Platform Link-in-Bio Modern dengan Asisten AI</span>
            </div>

            <!-- Headline -->
            <h1 class="text-4xl sm:text-6xl font-black text-white tracking-tight max-w-3xl leading-[1.15] mb-5">
                Satu tautan untuk semua karya Anda,<br>
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-sky-400 via-indigo-400 to-purple-400">
                    ditenagai asisten AI pintar.
                </span>
            </h1>

            <!-- Subtitle -->
            <p class="text-xs sm:text-sm text-zinc-400 max-w-xl leading-relaxed mb-8">
                Kumpulkan seluruh portofolio, tautan proyek, dan media sosial Anda dalam satu halaman elegan. Lengkap dengan Asisten AI interaktif yang memandu pengunjung 24/7.
            </p>

            <!-- Claim Handle Input -->
            <form action="{{ route('register') }}" method="GET" class="w-full max-w-md bg-zinc-900/90 border border-zinc-700/80 rounded-2xl p-2 shadow-2xl flex items-center gap-2 mb-12 focus-within:border-sky-400 transition-colors">
                <div class="flex items-center pl-3 text-zinc-500 text-xs font-mono font-semibold select-none">
                    <span>biolink/@</span>
                </div>
                <input type="text" 
                       name="handle" 
                       placeholder="username-anda" 
                       required
                       autocomplete="off"
                       class="bg-transparent flex-grow text-xs font-mono text-white placeholder-zinc-500 focus:outline-none py-2 px-1">
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-sky-500 hover:bg-sky-400 text-white text-xs font-black transition-all shadow-lg shadow-sky-500/25 whitespace-nowrap">
                    Klaim Bio
                </button>
            </form>

            <!-- Real Profile Preview Mockup (Contoh Nyata) -->
            <div class="w-full max-w-sm bg-zinc-900/90 border border-zinc-800 rounded-3xl p-6 shadow-2xl backdrop-blur-xl relative text-left mx-auto">
                
                <!-- Profile Header -->
                <div class="flex flex-col items-center text-center mb-4">
                    <div class="relative w-16 h-16 rounded-full p-0.5 bg-gradient-to-tr from-sky-400 to-purple-500 shadow-md mb-2">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=200&auto=format&fit=crop&q=80" alt="Avatar" class="w-full h-full object-cover rounded-full">
                        <span class="absolute bottom-0 right-0 w-5 h-5 bg-sky-500 border-2 border-zinc-950 text-white rounded-full flex items-center justify-center p-0.5 shadow-sm">
                            <svg class="w-2.5 h-2.5 fill-current" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                        </span>
                    </div>

                    <h3 class="font-extrabold text-sm text-white">Windri</h3>
                    <p class="text-[11px] font-mono text-sky-400 mb-1">@windri</p>
                    <p class="text-[10px] text-zinc-400 leading-tight">Senior Full-Stack Software Engineer & Builder.</p>
                </div>

                <!-- Sample Links -->
                <div class="space-y-2 text-xs">
                    <div class="p-3 rounded-xl bg-white/5 border border-white/10 flex items-center justify-between text-zinc-200">
                        <span class="font-bold flex items-center gap-2">
                            <svg class="w-4 h-4 fill-current text-white/80" viewBox="0 0 24 24"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/></svg>
                            <span>GitHub windri-dev</span>
                        </span>
                        <span class="text-[9px] bg-sky-500/20 text-sky-300 px-1.5 py-0.5 rounded font-mono font-bold">OFFICIAL</span>
                    </div>

                    <div class="p-3 rounded-xl bg-white/5 border border-white/10 flex items-center justify-between text-zinc-200">
                        <span class="font-bold flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                            <span>SHOPPE Staging Demo</span>
                        </span>
                        <span class="text-[9px] bg-emerald-500/20 text-emerald-300 px-1.5 py-0.5 rounded font-mono font-bold">LIVE</span>
                    </div>
                </div>

                <!-- Floating AI Mascot Preview -->
                <div class="mt-3.5 p-2.5 rounded-2xl bg-zinc-950/80 border border-sky-400/30 flex items-center justify-between shadow-md">
                    <div class="flex items-center gap-2.5">
                        <div class="relative flex-shrink-0">
                            <div class="w-8 h-8 rounded-full p-0.5 bg-gradient-to-tr from-sky-400 to-indigo-500 overflow-hidden">
                                <img src="https://api.dicebear.com/7.x/bottts-neutral/svg?seed=AuraBot&backgroundColor=0284c7" alt="Aura" class="w-full h-full object-cover rounded-full">
                            </div>
                            <span class="absolute bottom-0 right-0 w-2 h-2 bg-emerald-400 rounded-full border border-zinc-950"></span>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold text-white flex items-center gap-1">
                                Tanya Aura <span class="text-[8px] font-mono px-1 bg-sky-500/20 text-sky-300 rounded">AI</span>
                            </span>
                            <p class="text-[9px] text-zinc-400">"Siap memandu tentang profil Windri."</p>
                        </div>
                    </div>
                    <a href="/@windri" target="_blank" class="text-[10px] text-sky-400 font-bold hover:underline">Coba &rarr;</a>
                </div>

            </div>
        </section>


        <!-- FITUR PENTING SAJA (4 PILAR UTAMA) -->
        <section id="fitur" class="py-20 px-6 sm:px-12 border-t border-zinc-800/80 max-w-5xl mx-auto w-full">
            <div class="text-center mb-12 space-y-2">
                <span class="text-xs font-mono uppercase tracking-wider text-sky-400 font-bold block">FITUR UTAMA</span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-white tracking-tight">Semua yang Penting Ada di Sini</h2>
                <p class="text-xs sm:text-sm text-zinc-400">Dirancang ringkas, cepat, dan tanpa fitur yang membingungkan.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                
                <!-- Pilar 1: AI Assistant & Keamanan -->
                <div class="p-6 rounded-2xl bg-zinc-900/60 border border-zinc-800 hover:border-sky-500/40 transition-colors space-y-2.5">
                    <div class="w-10 h-10 rounded-xl bg-sky-500/10 border border-sky-500/20 text-sky-400 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="10" rx="2"></rect>
                            <circle cx="12" cy="5" r="2"></circle>
                            <path d="M12 7v4"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-base text-white">Asisten AI Pribadi & Keamanan</h3>
                    <p class="text-xs text-zinc-400 leading-relaxed">
                        AI dilatih dari data profil Anda untuk menjawab pertanyaan pengunjung. Dilengkapi batas spam IP dan AI Firewall anti-jailbreak.
                    </p>
                </div>

                <!-- Pilar 2: Tema & Kustomisasi Wallpaper -->
                <div class="p-6 rounded-2xl bg-zinc-900/60 border border-zinc-800 hover:border-purple-500/40 transition-colors space-y-2.5">
                    <div class="w-10 h-10 rounded-xl bg-purple-500/10 border border-purple-500/20 text-purple-400 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="m14.622 17.897-1.077 1.077a2.474 2.474 0 0 1-3.5 0L7.87 16.8a2.474 2.474 0 0 1 0-3.5l1.077-1.077"/>
                            <path d="m14 14 6-6"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-base text-white">Kustomisasi Tema & Wallpaper</h3>
                    <p class="text-xs text-zinc-400 leading-relaxed">
                        Gunakan preset tema elegan atau unggah wallpaper foto Anda sendiri dengan lapisan kegelapan agar teks selalu jelas terbaca.
                    </p>
                </div>

                <!-- Pilar 3: Simpan Kontak vCard 1-Klik -->
                <div class="p-6 rounded-2xl bg-zinc-900/60 border border-zinc-800 hover:border-emerald-500/40 transition-colors space-y-2.5">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                            <path d="M3 10h18"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-base text-white">Simpan Kontak vCard & QR Code</h3>
                    <p class="text-xs text-zinc-400 leading-relaxed">
                        Pengunjung dapat langsung menyimpan nomor telepon, email, dan detail kontak Anda ke buku telepon smartphone dalam 1 klik.
                    </p>
                </div>

                <!-- Pilar 4: Analitik Real-Time Privasi Tinggi -->
                <div class="p-6 rounded-2xl bg-zinc-900/60 border border-zinc-800 hover:border-amber-500/40 transition-colors space-y-2.5">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="20" x2="12" y2="10"></line>
                            <line x1="18" y1="20" x2="18" y2="4"></line>
                            <line x1="6" y1="20" x2="6" y2="16"></line>
                        </svg>
                    </div>
                    <h3 class="font-bold text-base text-white">Statistik & Analitik Pengunjung</h3>
                    <p class="text-xs text-zinc-400 leading-relaxed">
                        Ketahui tautan yang paling sering diklik dan jenis perangkat audiens Anda secara akurat tanpa pelacak iklan yang melanggar privasi.
                    </p>
                </div>

            </div>
        </section>


        <!-- CTA SECTION (RINGKAS & TO THE POINT) -->
        <section class="py-16 px-6 sm:px-12 border-t border-zinc-800/80 text-center bg-zinc-900/30">
            <div class="max-w-xl mx-auto space-y-5">
                <h2 class="text-2xl sm:text-4xl font-extrabold text-white tracking-tight">Siap Membuat Halaman Bio Anda?</h2>
                <p class="text-xs sm:text-sm text-zinc-400">Daftar sekarang gratis, klaim tautan nama Anda, dan buat halaman bio profesional dalam 2 menit.</p>
                <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-sky-500 hover:bg-sky-400 text-white font-extrabold text-xs transition-all shadow-lg shadow-sky-500/20">
                        Buat Bio Sekarang &bull; Gratis
                    </a>
                    <a href="/@windri" target="_blank" class="w-full sm:w-auto px-5 py-3 rounded-xl bg-zinc-800 hover:bg-zinc-700 text-zinc-300 font-bold text-xs transition-colors">
                        Lihat Contoh Profil
                    </a>
                </div>
            </div>
        </section>

    </main>


    <!-- ========================================================================= -->
    <!-- 3. FOOTER (MINIMALIS & ELEGAN)                                            -->
    <!-- ========================================================================= -->
    <footer class="border-t border-zinc-800/80 bg-zinc-950 px-6 sm:px-12 py-8 text-xs text-zinc-500">
        <div class="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left">
            <div class="flex items-center gap-2">
                <span class="font-bold text-zinc-300">BioLink.</span>
                <span>&bull;</span>
                <span>Platform Link-in-Bio AI</span>
            </div>
            <div>
                Dibuat oleh <a href="https://github.com/windri-dev" target="_blank" class="text-zinc-300 hover:text-white underline font-semibold">windri-dev</a> &bull; &copy; {{ date('Y') }}
            </div>
        </div>
    </footer>

</body>
</html>
