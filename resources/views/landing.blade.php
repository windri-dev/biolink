<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioLink — Modern Link-in-Bio Platform</title>

    <meta name="description" content="Platform link-in-bio modern dengan asisten AI pintar. Buat halaman profil, kumpulkan semua link penting, dan pandu pengunjung secara otomatis.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=DM+Mono:wght@500;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #09090b;
            color: #f4f4f5;
            overflow-x: hidden;
        }
        .glow-radial {
            background: radial-gradient(circle at 50% 0%, rgba(56, 189, 248, 0.15) 0%, rgba(99, 102, 241, 0.08) 40%, transparent 70%);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col bg-zinc-950 text-zinc-100 antialiased selection:bg-sky-500 selection:text-white">

    <!-- Top Navigation Bar -->
    <header class="h-20 border-b border-zinc-800/80 bg-zinc-950/80 backdrop-blur-xl sticky top-0 z-40 px-6 sm:px-12 flex items-center justify-between">
        <a href="/" class="flex items-center gap-2.5 font-black text-xl tracking-tight text-white group">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-sky-400 to-indigo-600 flex items-center justify-center text-white shadow-lg shadow-sky-500/25 transition-transform group-hover:scale-105">
                <i data-lucide="link-2" class="w-5 h-5"></i>
            </div>
            <span>BioLink<span class="text-sky-400">.</span></span>
        </a>

        <div class="hidden md:flex items-center gap-8 text-xs font-semibold text-zinc-400">
            <a href="#features" class="hover:text-white transition-colors">Fitur Unggulan</a>
            <a href="#ai-assistant" class="hover:text-white transition-colors">Asisten AI</a>
            <a href="#themes" class="hover:text-white transition-colors">Koleksi Tema</a>
            <a href="#comparison" class="hover:text-white transition-colors">Keunggulan</a>
        </div>

        <div class="flex items-center gap-3">
            @auth
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-xl bg-sky-500 hover:bg-sky-400 text-white text-xs font-bold transition-all shadow-lg shadow-sky-500/25 inline-flex items-center gap-1.5">
                    <span>Buka Studio Dasbor</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </a>
            @else
                <a href="{{ route('login') }}" class="px-3.5 py-2 rounded-xl text-zinc-300 hover:text-white text-xs font-semibold hover:bg-zinc-800/60 transition-colors">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="px-4 py-2 rounded-xl bg-white text-zinc-950 hover:bg-zinc-200 text-xs font-extrabold transition-all shadow-md inline-flex items-center gap-1">
                    <span>Daftar Gratis</span>
                </a>
            @endauth
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative pt-20 pb-24 px-6 sm:px-12 glow-radial flex flex-col items-center text-center">
        
        <!-- Launch Badge -->
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-sky-500/10 border border-sky-500/25 text-sky-400 text-xs font-bold mb-8">
            <span class="w-2 h-2 rounded-full bg-sky-400 animate-pulse"></span>
            <span>Platform Bio Link Multi-User Generasi Baru</span>
        </div>

        <!-- Hero Headline -->
        <h1 class="text-4xl sm:text-6xl lg:text-7xl font-black text-white tracking-tight max-w-4xl leading-[1.1] mb-6">
            Your link-in-bio,<br>
            <span class="bg-clip-text text-transparent bg-gradient-to-r from-sky-400 via-indigo-400 to-purple-400">
                now with a brain.
            </span>
        </h1>

        <!-- Hero Subtitle -->
        <p class="text-sm sm:text-base text-zinc-400 max-w-2xl leading-relaxed mb-10">
            Kumpulkan semua tautan penting, portofolio, dan media sosial Anda dalam satu URL elegan. Dilengkapi dengan <strong class="text-zinc-200">Asisten AI interaktif</strong> yang menyapa dan menjawab pertanyaan pengunjung tentang profil Anda secara otomatis 24/7.
        </p>

        <!-- Interactive Claim Handle Box -->
        <form action="{{ route('register') }}" method="GET" class="w-full max-w-md bg-zinc-900/90 border border-zinc-700/80 rounded-2xl p-2 shadow-2xl flex items-center gap-2 mb-12 focus-within:border-sky-500 transition-colors">
            <div class="flex items-center pl-3 text-zinc-500 text-xs font-mono select-none">
                <span>biolink.local/@</span>
            </div>
            <input type="text" 
                   name="handle" 
                   placeholder="username-anda" 
                   required
                   class="bg-transparent flex-grow text-xs font-mono text-white placeholder-zinc-500 focus:outline-none py-2">
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-sky-500 hover:bg-sky-400 text-white text-xs font-bold transition-all shadow-lg shadow-sky-500/20 whitespace-nowrap">
                Klaim Tautan
            </button>
        </form>

        <!-- Visual Hero Preview Mockup -->
        <div class="w-full max-w-md bg-zinc-900/80 border border-zinc-800 rounded-3xl p-6 shadow-2xl backdrop-blur-xl relative group">
            <div class="w-20 h-20 rounded-full p-1 bg-gradient-to-tr from-sky-400 via-indigo-500 to-purple-500 mx-auto mb-3 shadow-lg">
                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=200" alt="Avatar" class="w-full h-full object-cover rounded-full bg-zinc-950">
            </div>

            <div class="flex items-center justify-center gap-1.5 mb-1">
                <h3 class="font-extrabold text-base text-white">Windri</h3>
                <span class="w-4 h-4 bg-sky-500 text-white rounded-full flex items-center justify-center p-0.5 shadow-sm">
                    <svg class="w-2.5 h-2.5 fill-current" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                </span>
            </div>
            <p class="text-xs font-mono text-sky-400 mb-2">@windri</p>
            <p class="text-xs text-zinc-400 max-w-xs mx-auto mb-4 leading-relaxed">
                Senior Full-Stack Software Engineer & Builder. Focusing on distributed systems, modern Laravel, and AI agents.
            </p>

            <div class="space-y-2 text-xs">
                <div class="p-3 rounded-xl bg-white/5 border border-white/10 flex items-center justify-between text-zinc-200">
                    <span class="font-bold flex items-center gap-2">
                        <i data-lucide="github" class="w-4 h-4 text-zinc-300"></i>
                        <span>GitHub windri-dev</span>
                    </span>
                    <span class="text-[9px] bg-sky-500/20 text-sky-300 px-1.5 py-0.5 rounded font-mono font-bold">OFFICIAL</span>
                </div>
                <div class="p-3 rounded-xl bg-white/5 border border-white/10 flex items-center justify-between text-zinc-200">
                    <span class="font-bold flex items-center gap-2">
                        <i data-lucide="shopping-bag" class="w-4 h-4 text-emerald-400"></i>
                        <span>SHOPPE Staging Demo</span>
                    </span>
                    <span class="text-[9px] bg-emerald-500/20 text-emerald-300 px-1.5 py-0.5 rounded font-mono font-bold">LIVE</span>
                </div>
            </div>

            <!-- Simulated Floating AI Bubble -->
            <div class="mt-4 p-3 rounded-2xl bg-gradient-to-r from-sky-500/20 to-indigo-500/20 border border-sky-400/30 text-left flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-sky-500 text-white flex items-center justify-center flex-shrink-0">
                    <i data-lucide="bot" class="w-4 h-4"></i>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-sky-300 flex items-center gap-1">Aura • AI Assistant</span>
                    <p class="text-[11px] text-zinc-300">"Halo! Saya asisten AI Windri. Ada yang bisa saya bantu?"</p>
                </div>
            </div>
        </div>

    </section>

    <!-- Features Grid -->
    <section id="features" class="py-20 px-6 sm:px-12 border-t border-zinc-800/80 max-w-6xl mx-auto w-full">
        <div class="text-center mb-16 space-y-3">
            <h2 class="text-2xl sm:text-4xl font-extrabold text-white tracking-tight">Semua yang Anda Butuhkan dalam 1 Aplikasi</h2>
            <p class="text-xs sm:text-sm text-zinc-400 max-w-xl mx-auto">Dirancang untuk kecepatan tinggi, tanpa biaya berlangganan, dan kebebasan mengelola data sepenuhnya.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-6 rounded-2xl bg-zinc-900/60 border border-zinc-800 space-y-3">
                <div class="w-10 h-10 rounded-xl bg-sky-500/10 border border-sky-500/20 text-sky-400 flex items-center justify-center">
                    <i data-lucide="bot" class="w-5 h-5"></i>
                </div>
                <h3 class="font-bold text-base text-white">Smart AI Concierge</h3>
                <p class="text-xs text-zinc-400 leading-relaxed">
                    Setiap pengguna memiliki Asisten AI sendiri yang dilatih dari basis pengetahuan (FAQ, biografi, kontak) untuk memandu audiens.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-zinc-900/60 border border-zinc-800 space-y-3">
                <div class="w-10 h-10 rounded-xl bg-purple-500/10 border border-purple-500/20 text-purple-400 flex items-center justify-center">
                    <i data-lucide="palette" class="w-5 h-5"></i>
                </div>
                <h3 class="font-bold text-base text-white">Koleksi 6 Tema Preset</h3>
                <p class="text-xs text-zinc-400 leading-relaxed">
                    Pilih dari 6 tema elegan (Dark Luxury, Emerald, Cyberpunk, Sunset, Minimalist Cream) atau rancang tema kustom dengan CSS sendiri.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-zinc-900/60 border border-zinc-800 space-y-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center">
                    <i data-lucide="bar-chart-3" class="w-5 h-5"></i>
                </div>
                <h3 class="font-bold text-base text-white">Analitik Tanpa Tracker Iklan</h3>
                <p class="text-xs text-zinc-400 leading-relaxed">
                    Pantau jumlah penayangan profil, tautan paling populer, dan jenis perangkat pengunjung dengan privasi terjaga.
                </p>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="py-20 px-6 sm:px-12 bg-gradient-to-b from-zinc-900/40 to-zinc-950 border-t border-zinc-800/80 text-center">
        <div class="max-w-2xl mx-auto space-y-6">
            <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">Siap Meluncurkan Halaman Bio Anda?</h2>
            <p class="text-xs sm:text-sm text-zinc-400">Daftarkan akun gratis, klaim username unik Anda, dan mulai kumpulkan tautan penting Anda dalam hitungan menit.</p>
            <div>
                <a href="{{ route('register') }}" class="px-8 py-3.5 rounded-2xl bg-sky-500 hover:bg-sky-400 text-white font-extrabold text-sm transition-all shadow-xl shadow-sky-500/30 inline-flex items-center gap-2">
                    <span>Buat Halaman Bio Sekarang &bull; Gratis</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-10 px-6 sm:px-12 border-t border-zinc-800/80 text-xs text-zinc-500 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-2">
            <span class="font-bold text-zinc-400">BioLink Platform</span>
            <span>&bull;</span>
            <span>Built with Laravel 11/12 & MySQL</span>
        </div>
        <div>
            Dikelola oleh <a href="https://github.com/windri-dev/biolink" target="_blank" class="text-zinc-300 hover:text-white underline">@windri-dev</a>
        </div>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
