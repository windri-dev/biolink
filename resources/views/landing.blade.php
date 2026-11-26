<!DOCTYPE html>
<html lang="id" class="dark scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-site-verification" content="GMlaNYsY0JoaH7udJaVoyV5cg3bF08Jb3Pcx0pdQd1U" />
    <title>BioLink — Platform Link in Bio Gratis & Asisten AI Indonesia</title>

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url('/') }}">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">

    <!-- GEO & Local Search Optimization -->
    <meta name="geo.region" content="ID">
    <meta name="geo.placename" content="Indonesia">
    <meta name="geo.position" content="-6.2088;106.8456">
    <meta name="ICBM" content="-6.2088, 106.8456">
    <meta name="language" content="id-ID">
    <meta name="distribution" content="global">
    <meta name="rating" content="general">
    <meta name="revisit-after" content="2 days">

    <!-- Meta Description & High-Intent SEO Keywords -->
    <meta name="description" content="Platform link in bio modern gratis dengan asisten AI pintar di Indonesia. Buat kartu tautan bento elegan, kumpulkan portofolio, media sosial, dan pandu pengunjung otomatis 24/7. Alternatif Linktree terbaik.">
    <meta name="keywords" content="biolink, link in bio, bio link indonesia, link bio gratis, alternatif linktree indonesia, biolink indonesia, buat link bio, website bio link, kartu nama digital, vcard digital, ai assistant link, linktree clone, portfolio link creator">
    <meta name="author" content="BioLink">

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    <!-- OpenGraph & Twitter Meta -->
    <meta property="og:site_name" content="BioLink">
    <meta property="og:title" content="BioLink — Platform Link in Bio Gratis & Asisten AI Indonesia">
    <meta property="og:description" content="Kumpulkan seluruh portofolio, tautan proyek, dan media sosial Anda dalam satu URL elegan. Dilengkapi Asisten AI pintar yang menyapa dan memandu pengunjung Anda 24/7.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:image" content="{{ asset('Logo.png') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="BioLink — Platform Link in Bio Gratis & AI Assistant">
    <meta name="twitter:description" content="Platform link-in-bio modern dengan kecerdasan buatan, tema kustom tanpa batas, dan analitik real-time.">
    <meta name="twitter:image" content="{{ asset('Logo.png') }}">

    <!-- Schema.org JSON-LD Structured Data for Google Search -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@graph": [
        {
          "@@type": "Organization",
          "@@id": "{{ url('/') }}/#organization",
          "name": "BioLink",
          "url": "{{ url('/') }}",
          "logo": "{{ asset('Logo.png') }}",
          "description": "Platform SaaS Link in Bio Multi-User dengan Asisten AI",
          "areaServed": "ID"
        },
        {
          "@@type": "WebSite",
          "@@id": "{{ url('/') }}/#website",
          "url": "{{ url('/') }}",
          "name": "BioLink",
          "publisher": { "@@id": "{{ url('/') }}/#organization" },
          "description": "Platform Link in Bio Modern dengan Asisten AI untuk Kreator dan Developer",
          "potentialAction": {
            "@@type": "SearchAction",
            "target": {
              "@@type": "EntryPoint",
              "urlTemplate": "{{ url('/') }}/@{search_term_string}"
            },
            "query-input": "required name=search_term_string"
          },
          "inLanguage": "id-ID"
        },
        {
          "@@type": "SoftwareApplication",
          "name": "BioLink",
          "applicationCategory": "BusinessApplication",
          "operatingSystem": "All",
          "offers": {
            "@@type": "Offer",
            "price": "0",
            "priceCurrency": "IDR"
          },
          "featureList": [
            "Bento Grid Link Builder",
            "Custom Themes and CSS",
            "Interactive AI Assistant",
            "vCard Contact Download",
            "High-resolution QR Code Generator",
            "Geolocation Analytics"
          ]
        },
        {
          "@@type": "FAQPage",
          "mainEntity": [
            {
              "@@type": "Question",
              "name": "Apakah BioLink benar-benar gratis?",
              "acceptedAnswer": {
                "@@type": "Answer",
                "text": "Ya! Anda dapat mendaftar, membuat halaman bio kustom, menambahkan tautan tak terbatas, mengatur tema, dan menggunakan seluruh fitur analitik tanpa biaya berlangganan."
              }
            },
            {
              "@@type": "Question",
              "name": "Bagaimana cara kerja Asisten AI Concierge?",
              "acceptedAnswer": {
                "@@type": "Answer",
                "text": "Asisten AI bekerja berdasarkan data pengetahuan yang Anda isi di menu Studio Dasbor. Anda juga bisa menghubungkan API Key Anda sendiri (OpenAI, DeepSeek, Groq, atau Ollama) untuk respon natural."
              }
            },
            {
              "@@type": "Question",
              "name": "Apakah tautan profil ramah SEO di Google?",
              "acceptedAnswer": {
                "@@type": "Answer",
                "text": "Sangat ramah SEO. Setiap profil otomatis dilengkapi Schema.org JSON-LD, XML Sitemap, dan meta tag indeksasi agar cepat terdeteksi dan terindeks di mesin pencari Google."
              }
            }
          ]
        }
      ]
    }
    </script>

    <!-- Google Fonts: Plus Jakarta Sans & DM Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=DM+Mono:wght@500;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
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
        .glow-radial-top {
            background: radial-gradient(circle at 50% 0%, rgba(14, 165, 233, 0.16) 0%, rgba(99, 102, 241, 0.08) 35%, transparent 70%);
        }
        .glow-radial-card {
            background: radial-gradient(circle at 50% 50%, rgba(56, 189, 248, 0.08) 0%, transparent 70%);
        }
        .custom-glass {
            background: rgba(24, 24, 27, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        /* 21st-inspired Design Patterns: Animated Border Beam */
        @property --angle {
            syntax: "<angle>";
            initial-value: 0deg;
            inherits: false;
        }
        @keyframes border-beam-spin {
            from { --angle: 0deg; }
            to { --angle: 360deg; }
        }
        .border-beam-card {
            position: relative;
            overflow: hidden;
        }
        .border-beam-card::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            padding: 1.5px;
            background: linear-gradient(var(--angle, 0deg), transparent 0%, transparent 30%, #38bdf8 50%, #818cf8 70%, transparent 85%, transparent 100%);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask-composite: exclude;
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            animation: border-beam-spin 8s linear infinite;
            pointer-events: none;
        }

        /* 21st-inspired Design Patterns: Cursor Spotlight Halo */
        .spotlight-card {
            position: relative;
            overflow: hidden;
        }
        .spotlight-card::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            background: radial-gradient(350px circle at var(--mouse-x, -999px) var(--mouse-y, -999px), rgba(56, 189, 248, 0.12), transparent 45%);
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .spotlight-card:hover::before {
            opacity: 1;
        }

        /* 21st-inspired Design Patterns: Shimmer Button */
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        .btn-shimmer {
            background-size: 200% auto;
            animation: shimmer 4s linear infinite;
        }

        /* Float Animation for Bento Chips */
        @keyframes float-gentle {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-6px); }
        }
        .animate-float {
            animation: float-gentle 4s ease-in-out infinite;
        }
        .animate-float-delayed {
            animation: float-gentle 5s ease-in-out 2s infinite;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col bg-zinc-950 text-zinc-100 antialiased selection:bg-sky-500 selection:text-white">

    <!-- ========================================================================= -->
    <!-- 1. HEADER & NAVBAR                                                        -->
    <!-- ========================================================================= -->
    <header class="h-16 sm:h-20 border-b border-zinc-800/80 bg-zinc-950/90 backdrop-blur-xl sticky top-0 z-50 px-4 sm:px-12 transition-all">
        <nav class="max-w-7xl mx-auto h-full flex items-center justify-between gap-3">
            
            <!-- Brand Logo -->
            <a href="/" class="flex items-center gap-2.5 font-black text-lg sm:text-xl tracking-tight text-white group flex-shrink-0" aria-label="BioLink Homepage">
                <img src="{{ asset('Logo.png') }}" alt="Logo" class="h-8 sm:h-11 w-auto object-contain transition-transform group-hover:scale-105">
                <span class="flex items-center">
                    <span>BioLink</span>
                    <span class="text-sky-400">.</span>
                </span>
            </a>

            <!-- Desktop Navigation Links -->
            <div class="hidden md:flex items-center gap-8 text-xs font-semibold text-zinc-300">
                <a href="#fitur" class="hover:text-sky-400 transition-colors">Fitur Utama</a>
                <a href="#ai-concierge" class="hover:text-sky-400 transition-colors flex items-center gap-1.5">
                    <span>Asisten AI</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                </a>
                <a href="#tema" class="hover:text-sky-400 transition-colors">Preset Tema</a>
                <a href="#keunggulan" class="hover:text-sky-400 transition-colors">Keunggulan</a>
                <a href="#faq" class="hover:text-sky-400 transition-colors">FAQ</a>
            </div>

            <!-- Action CTA Buttons -->
            <div class="flex items-center gap-2 flex-shrink-0">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="px-3 sm:px-4 py-2 rounded-xl bg-gradient-to-r from-sky-500 to-indigo-600 hover:from-sky-400 hover:to-indigo-500 text-white text-xs font-bold transition-all shadow-lg shadow-sky-500/25 flex items-center gap-1.5">
                        <span>Studio</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:inline-block px-3 py-2 rounded-xl text-zinc-300 hover:text-white text-xs font-bold hover:bg-zinc-800/60 transition-colors">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="px-3 sm:px-4 py-2 rounded-xl bg-white text-zinc-950 hover:bg-zinc-200 text-xs font-black transition-all shadow-md shadow-white/10 flex items-center gap-1.5 whitespace-nowrap">
                        <span>Daftar Gratis</span>
                    </a>
                @endauth

                <!-- Mobile Hamburger Button -->
                <button type="button" 
                        onclick="toggleMobileMenu()" 
                        class="p-2 rounded-xl text-zinc-300 hover:text-white hover:bg-zinc-800 md:hidden transition-colors border border-zinc-800/80" 
                        aria-label="Toggle Navigation Menu">
                    <svg id="hamburgerIcon" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg id="closeMenuIcon" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

        </nav>

        <!-- Mobile Drawer Navigation (Slide Down) -->
        <div id="mobileMenu" class="md:hidden hidden border-t border-zinc-800 bg-zinc-950/95 backdrop-blur-2xl px-6 py-6 space-y-4">
            <div class="flex flex-col space-y-3 text-sm font-semibold text-zinc-300">
                <a href="#fitur" onclick="toggleMobileMenu()" class="py-2 hover:text-sky-400 border-b border-zinc-850">Fitur Utama</a>
                <a href="#ai-concierge" onclick="toggleMobileMenu()" class="py-2 hover:text-sky-400 border-b border-zinc-850 flex items-center justify-between">
                    <span>Asisten AI Concierge</span>
                    <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-400">Aktif</span>
                </a>
                <a href="#tema" onclick="toggleMobileMenu()" class="py-2 hover:text-sky-400 border-b border-zinc-850">Preset Tema</a>
                <a href="#keunggulan" onclick="toggleMobileMenu()" class="py-2 hover:text-sky-400 border-b border-zinc-850">Keunggulan Platform</a>
                <a href="#faq" onclick="toggleMobileMenu()" class="py-2 hover:text-sky-400">Pertanyaan Umum (FAQ)</a>
            </div>

            <div class="pt-4 border-t border-zinc-800 flex flex-col gap-2.5">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="w-full py-3 rounded-xl bg-sky-500 text-white font-bold text-center text-xs shadow-lg shadow-sky-500/20">
                        Buka Studio Dasbor
                    </a>
                @else
                    <a href="{{ route('register') }}" class="w-full py-3 rounded-xl bg-white text-zinc-950 font-black text-center text-xs shadow-md">
                        Daftar Akun Baru &bull; Gratis
                    </a>
                    <a href="{{ route('login') }}" class="w-full py-2.5 rounded-xl bg-zinc-900 border border-zinc-800 text-zinc-300 font-bold text-center text-xs">
                        Masuk ke Akun
                    </a>
                @endauth
            </div>
        </div>
    </header>


    <!-- ========================================================================= -->
    <!-- 2. BODY CONTENT (MAIN SECTIONS)                                           -->
    <!-- ========================================================================= -->
    <main class="flex-grow">

        <!-- SECTION A: 21ST-INSPIRED BENTO PRODUCT HERO -->
        <section class="relative pt-10 sm:pt-20 pb-14 sm:pb-24 px-4 sm:px-12 glow-radial-top max-w-7xl mx-auto w-full">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">
                
                <!-- Left Column: Copywriting & High-Intent Action -->
                <div class="lg:col-span-7 text-center lg:text-left space-y-6">
                    
                    <!-- Launch Pill Badge -->
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-gradient-to-r from-sky-500/10 via-indigo-500/10 to-purple-500/10 border border-sky-400/30 text-sky-300 text-[11px] sm:text-xs font-bold shadow-sm max-w-full">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse flex-shrink-0"></span>
                        <span class="truncate">BioLink v2.0 &bull; Ditenagai Universal AI Engine</span>
                    </div>

                    <!-- Big Impactful Headline -->
                    <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight leading-tight sm:leading-[1.12] [text-wrap:balance]">
                        Satu tautan untuk semua karya Anda,<br>
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-sky-400 via-indigo-400 to-purple-400">
                            kini ditenagai asisten AI pintar.
                        </span>
                    </h1>

                    <!-- Subtitle -->
                    <p class="text-xs sm:text-base text-zinc-300/90 max-w-xl mx-auto lg:mx-0 leading-relaxed">
                        Kumpulkan portofolio, produk demo, media sosial, dan kontak Anda dalam satu halaman profil modern berkecepatan tinggi. Lengkap dengan <strong class="text-white font-semibold">Asisten Obrolan AI</strong> yang menyapa dan menjawab pertanyaan audiens Anda secara otomatis 24/7.
                    </p>

                    <!-- Interactive Handle Claim Box (Responsive Stack on Mobile, Inline on Desktop) -->
                    <form action="{{ route('register') }}" method="GET" class="w-full max-w-lg mx-auto lg:mx-0 bg-zinc-900/90 border border-zinc-700/80 rounded-2xl p-2 shadow-2xl flex flex-col sm:flex-row items-stretch sm:items-center gap-2 focus-within:border-sky-400 focus-within:ring-2 focus-within:ring-sky-500/20 transition-all">
                        <div class="flex items-center flex-grow bg-zinc-950/60 sm:bg-transparent rounded-xl px-2 py-1 sm:p-0">
                            <span class="pl-2 pr-1 text-zinc-500 text-xs font-mono select-none font-semibold">biolink/@</span>
                            <input type="text" 
                                   name="handle" 
                                   placeholder="username-anda" 
                                   required
                                   autocomplete="off"
                                   class="bg-transparent flex-grow text-xs font-mono text-white placeholder-zinc-500 focus:outline-none py-2 px-1 min-w-0">
                        </div>
                        <button type="submit" class="btn-shimmer px-5 py-3 rounded-xl bg-gradient-to-r from-sky-500 to-indigo-600 hover:from-sky-400 hover:to-indigo-500 text-white text-xs font-black transition-all shadow-lg shadow-sky-500/30 whitespace-nowrap flex items-center justify-center gap-1.5 flex-shrink-0">
                            <span>Klaim Bio Gratis</span>
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14m-7-7 7 7-7 7"/></svg>
                        </button>
                    </form>

                    <!-- Micro-Metrics Social Proof Strip -->
                    <div class="pt-2 flex items-center justify-center lg:justify-start gap-4 sm:gap-6 text-zinc-400 text-[11px] font-mono flex-wrap">
                        <span class="flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                            <span>100% Gratis</span>
                        </span>
                        <span class="flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-sky-400"></span>
                            <span>Universal AI Engine</span>
                        </span>
                        <span class="flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-purple-400"></span>
                            <span>Simpan vCard Native</span>
                        </span>
                    </div>

                </div>

                <!-- Right Column: Interactive Live Bento Showcase with Floating Metric Cards -->
                <div class="lg:col-span-5 relative w-full max-w-md mx-auto">
                    
                    <!-- Floating Metric Card 1: Live Clicks (Top-Right Offset on Desktop) -->
                    <div class="hidden sm:flex items-center gap-3 p-3 rounded-2xl bg-zinc-900/90 border border-zinc-700/80 shadow-2xl backdrop-blur-xl absolute -top-5 -right-6 z-20 animate-float text-left">
                        <div class="w-9 h-9 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        </div>
                        <div class="text-[11px]">
                            <span class="font-bold text-white block">Real-Time Clicks</span>
                            <span class="text-emerald-400 font-mono font-bold">+1,840 Minggu Ini</span>
                        </div>
                    </div>

                    <!-- Floating Metric Card 2: AI Status (Bottom-Left Offset on Desktop) -->
                    <div class="hidden sm:flex items-center gap-2.5 p-3 rounded-2xl bg-zinc-900/90 border border-zinc-700/80 shadow-2xl backdrop-blur-xl absolute -bottom-5 -left-6 z-20 animate-float-delayed text-left">
                        <div class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse flex-shrink-0"></div>
                        <div class="text-[11px]">
                            <span class="font-bold text-white block">Aura AI Concierge</span>
                            <span class="text-zinc-400 font-mono text-[10px]">Aktif 24/7 &bull; Siap Menyapa</span>
                        </div>
                    </div>

                    <!-- Theme Switcher Pills Above Mockup -->
                    <div class="flex items-center justify-center gap-1.5 flex-wrap text-xs pb-3">
                        <button type="button" onclick="switchHeroMockupTheme('dark', this)" class="theme-pill px-2.5 py-1 rounded-full text-[10px] font-semibold bg-zinc-800 text-sky-400 border border-sky-500/50 shadow-sm transition-all">Dark Luxury</button>
                        <button type="button" onclick="switchHeroMockupTheme('midnight', this)" class="theme-pill px-2.5 py-1 rounded-full text-[10px] font-semibold bg-zinc-900 text-zinc-400 border border-zinc-800 hover:text-white transition-all">Midnight</button>
                        <button type="button" onclick="switchHeroMockupTheme('emerald', this)" class="theme-pill px-2.5 py-1 rounded-full text-[10px] font-semibold bg-zinc-900 text-zinc-400 border border-zinc-800 hover:text-white transition-all">Emerald</button>
                        <button type="button" onclick="switchHeroMockupTheme('minimal', this)" class="theme-pill px-2.5 py-1 rounded-full text-[10px] font-semibold bg-zinc-900 text-zinc-400 border border-zinc-800 hover:text-white transition-all">Minimal</button>
                    </div>

                    <!-- Live Mockup Visual Showcase -->
                    <div id="heroMockupCard" class="border-beam-card w-full bg-zinc-900/95 border border-zinc-800 rounded-3xl p-6 shadow-2xl backdrop-blur-xl relative group text-left transition-all duration-500">
                        
                        <!-- Avatar & Verified Badge -->
                        <div class="flex flex-col items-center text-center mb-5">
                            <div class="relative w-18 h-18 sm:w-20 sm:h-20 rounded-full p-1 bg-gradient-to-tr from-sky-400 via-indigo-500 to-purple-500 shadow-xl mb-3">
                                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=200&auto=format&fit=crop&q=80" alt="Avatar Profil" class="w-full h-full object-cover rounded-full bg-zinc-950">
                                <span class="absolute bottom-0 right-0 w-5 h-5 rounded-full bg-sky-500 border-2 border-zinc-950 text-white flex items-center justify-center p-0.5 shadow-md" title="Verified Creator">
                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                                </span>
                            </div>

                            <h3 id="mockupName" class="font-black text-lg text-white">Alex Pratama</h3>
                            <p id="mockupHandle" class="text-xs font-mono text-sky-400 font-semibold mb-1">@alexpratama</p>
                            <p id="mockupBio" class="text-[11px] text-zinc-400 max-w-xs mx-auto leading-relaxed">
                                Digital Creator & Full-Stack Developer. Membangun produk web modern, desain antarmuka, & inovasi AI.
                            </p>
                        </div>

                        <!-- Sample Bento Cards inside Mockup -->
                        <div class="space-y-2.5 text-xs">
                            <div class="mockup-link-card p-3 rounded-2xl bg-white/5 border border-white/10 hover:border-sky-400/40 transition-all flex items-center justify-between group/card cursor-pointer">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-xl bg-white/10 flex items-center justify-center text-white flex-shrink-0">
                                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <span class="mockup-link-title font-bold text-white block text-xs truncate">Portofolio Proyek</span>
                                        <span class="mockup-link-desc text-[10px] text-zinc-400 block truncate">Koleksi source code & hasil karya</span>
                                    </div>
                                </div>
                                <span class="text-[9px] bg-sky-500/20 text-sky-300 px-2 py-0.5 rounded-full font-mono font-bold border border-sky-500/30 flex-shrink-0">PROYEK</span>
                            </div>

                            <div class="mockup-link-card p-3 rounded-2xl bg-white/5 border border-white/10 hover:border-emerald-400/40 transition-all flex items-center justify-between group/card cursor-pointer">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <span class="mockup-link-title font-bold text-white block text-xs truncate">Demo Aplikasi & Toko</span>
                                        <span class="mockup-link-desc text-[10px] text-zinc-400 block truncate">Staging butik digital & template modern</span>
                                    </div>
                                </div>
                                <span class="text-[9px] bg-emerald-500/20 text-emerald-300 px-2 py-0.5 rounded-full font-mono font-bold border border-emerald-500/30 flex-shrink-0">DEMO</span>
                            </div>
                        </div>

                        <!-- Mascot Figurine Floating Button Preview with Interactive Chat Drawer -->
                        <div class="mt-3.5 space-y-2">
                            <div onclick="toggleHeroMockupChat()" class="p-2.5 rounded-2xl bg-zinc-950/80 border border-sky-400/30 flex items-center justify-between shadow-lg cursor-pointer hover:border-sky-400/60 transition-all">
                                <div class="flex items-center gap-2 min-w-0 flex-grow pr-1">
                                    <div class="relative flex-shrink-0">
                                        <div class="w-8 h-8 rounded-full p-0.5 bg-gradient-to-tr from-sky-400 via-indigo-500 to-pink-500 overflow-hidden">
                                            <img src="https://api.dicebear.com/7.x/bottts-neutral/svg?seed=AuraBot&backgroundColor=0284c7" alt="Aura Figurine" class="w-full h-full object-cover rounded-full">
                                        </div>
                                        <span class="absolute bottom-0 right-0 w-2 h-2 bg-emerald-400 rounded-full border border-zinc-950 animate-pulse"></span>
                                    </div>
                                    <div class="min-w-0 flex-grow">
                                        <span class="text-[11px] font-bold text-white flex items-center gap-1">
                                            <span>Tanya Aura</span>
                                            <span class="text-[8px] font-mono px-1 py-0.2 bg-sky-500/20 text-sky-300 rounded font-bold">AI</span>
                                        </span>
                                        <p class="text-[10px] text-zinc-400 truncate max-w-[160px] sm:max-w-xs">"Halo! Saya siap memandu tentang karya dan profil ini."</p>
                                    </div>
                                </div>
                                <span id="heroChatToggleText" class="text-[10px] text-sky-400 font-semibold flex-shrink-0 whitespace-nowrap">Coba &rarr;</span>
                            </div>

                            <!-- Interactive Simulated Chat Dialog inside Mockup -->
                            <div id="heroMockupChatBox" class="hidden p-3 rounded-2xl bg-zinc-950 border border-indigo-500/30 text-[11px] space-y-2 animate-fadeIn">
                                <div class="flex items-start gap-2">
                                    <span class="w-5 h-5 rounded-full bg-zinc-800 text-zinc-300 flex items-center justify-center text-[10px] font-bold flex-shrink-0">U</span>
                                    <div class="bg-zinc-800/90 text-zinc-200 px-2.5 py-1.5 rounded-xl rounded-tl-none">
                                        Apa keahlian dan karya yang tersedia?
                                    </div>
                                </div>
                                <div class="flex items-start gap-2">
                                    <div class="w-5 h-5 rounded-full bg-sky-500/20 text-sky-400 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-3 h-3 fill-current" viewBox="0 0 24 24"><path d="M12 2a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2 2 2 0 0 1-2-2V4a2 2 0 0 1 2-2Z"/></svg>
                                    </div>
                                    <div class="bg-sky-500/10 border border-sky-500/20 text-sky-200 px-2.5 py-1.5 rounded-xl rounded-tl-none leading-relaxed">
                                        Alex adalah Digital Creator & Full-Stack Developer yang fokus pada pengembangan aplikasi web modern, UI/UX elegan, serta integrasi AI autonomous agents.
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </section>


        <!-- SECTION B: ASYMMETRICAL BENTO GRID FEATURE SHOWCASE -->
        <section id="fitur" class="py-14 sm:py-24 px-4 sm:px-12 border-t border-zinc-800/80 max-w-7xl mx-auto w-full">
            <div class="text-center mb-10 sm:mb-16 space-y-3">
                <span class="text-xs font-mono uppercase tracking-wider text-sky-400 font-bold block">ARSITEKTUR BENTO MODERN</span>
                <h2 class="text-2xl sm:text-5xl font-black text-white tracking-tight">Semua Fitur Premium, Tanpa Biaya Berlangganan</h2>
                <p class="text-xs sm:text-sm text-zinc-400 max-w-2xl mx-auto">Dirancang untuk kebutuhan creator, software engineer, agensi, dan profesional modern yang membutuhkan kontrol penuh.</p>
            </div>

            <!-- Bento Asymmetric Tiles (Inspired by 21st.dev Bento Architecture) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 sm:gap-6">
                
                <!-- Tile 1 (Large 2-Column Bento Card): Smart AI Assistant Concierge -->
                <div class="md:col-span-2 spotlight-card p-6 sm:p-8 rounded-3xl bg-zinc-900/60 border border-zinc-800 hover:border-sky-500/40 transition-all flex flex-col justify-between group relative overflow-hidden">
                    <div class="space-y-4 relative z-10">
                        <div class="flex items-center justify-between">
                            <div class="w-12 h-12 rounded-2xl bg-sky-500/10 border border-sky-500/20 text-sky-400 flex items-center justify-center group-hover:scale-105 transition-transform">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="11" width="18" height="10" rx="2"></rect>
                                    <circle cx="12" cy="5" r="2"></circle>
                                    <path d="M12 7v4"></path>
                                    <line x1="8" y1="16" x2="8" y2="16"></line>
                                    <line x1="16" y1="16" x2="16" y2="16"></line>
                                </svg>
                            </div>
                            <span class="text-[10px] font-mono px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-400 font-bold border border-emerald-500/20">
                                4 AI ENGINE TERSAMBUNG
                            </span>
                        </div>

                        <h3 class="font-black text-xl sm:text-2xl text-white">Smart AI Concierge 24/7</h3>
                        <p class="text-xs sm:text-sm text-zinc-400 leading-relaxed max-w-xl">
                            Setiap profil dilengkapi dengan asisten AI pintar yang dilatih dari basis pengetahuan Anda (biodata, portofolio, FAQ, dan kontak). Menyapa pengunjung, menjawab pertanyaan, dan mengarahkan audiens ke karya terbaik Anda.
                        </p>

                        <!-- Simulated Interactive Chat Widget Inside Bento Tile -->
                        <div class="pt-2">
                            <div class="p-3.5 rounded-2xl bg-zinc-950/80 border border-zinc-800 text-xs space-y-2.5 font-mono">
                                <div class="flex items-center justify-between text-[11px] text-zinc-500 border-b border-zinc-850 pb-2">
                                    <span>Simulasi Percakapan Pengunjung</span>
                                    <span class="text-emerald-400 font-bold">&bull; Live</span>
                                </div>
                                <div class="flex items-center gap-2 text-zinc-300 text-[11px]">
                                    <span class="text-sky-400 font-bold">User:</span>
                                    <span>"Bisa lihat studi kasus aplikasi e-commerce yang pernah dibuat?"</span>
                                </div>
                                <div class="flex items-center gap-2 text-emerald-400 text-[11px]">
                                    <span class="text-emerald-300 font-bold">AI Concierge:</span>
                                    <span>"Tentu! Anda dapat mengeksplorasi portofolio proyek dan demo butik e-commerce pada kartu tautan di atas."</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-5 flex items-center gap-2 flex-wrap text-[11px] font-semibold text-sky-400 border-t border-zinc-800/80 mt-4">
                        <span class="px-2 py-0.5 rounded-md bg-zinc-800 text-zinc-300">OpenAI GPT-4o</span>
                        <span class="px-2 py-0.5 rounded-md bg-zinc-800 text-zinc-300">DeepSeek Chat</span>
                        <span class="px-2 py-0.5 rounded-md bg-zinc-800 text-zinc-300">Groq LLM</span>
                        <span class="px-2 py-0.5 rounded-md bg-zinc-800 text-zinc-300">Ollama Lokal</span>
                    </div>
                </div>

                <!-- Tile 2: Rate Limiter IP & AI Firewall Shield -->
                <div class="spotlight-card p-6 sm:p-7 rounded-3xl bg-zinc-900/60 border border-zinc-800 hover:border-emerald-500/40 transition-all flex flex-col justify-between group">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                <path d="m9 12 2 2 4-4"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-lg text-white">Rate Limiter IP & AI Shield</h3>
                        <p class="text-xs text-zinc-400 leading-relaxed">
                            Lindungi kunci API Anda dari spam dan pengurasan kuota. Dilengkapi batas pesan per menit, deteksi bot honeypot, dan AI Firewall Anti-Jailbreak.
                        </p>
                    </div>
                    <div class="pt-4 border-t border-zinc-800/60">
                        <span class="text-[11px] font-semibold text-emerald-400 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                            <span>Auto-Ban IP &bull; Honeypot Anti-Bot</span>
                        </span>
                    </div>
                </div>

                <!-- Tile 3: Simpan Kontak vCard 1-Klik Native -->
                <div class="spotlight-card p-6 sm:p-7 rounded-3xl bg-zinc-900/60 border border-zinc-800 hover:border-sky-500/40 transition-all flex flex-col justify-between group">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-2xl bg-sky-500/10 border border-sky-500/20 text-sky-400 flex items-center justify-center group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M16 2v4"></path>
                                <path d="M8 2v4"></path>
                                <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                                <path d="M3 10h18"></path>
                                <circle cx="12" cy="15" r="2"></circle>
                            </svg>
                        </div>
                        <h3 class="font-bold text-lg text-white">Simpan Kontak vCard Native</h3>
                        <p class="text-xs text-zinc-400 leading-relaxed">
                            Pengunjung dapat langsung mengunduh file `.vcf` untuk menyimpan nomor WhatsApp, email, dan jabatan Anda ke kontak smartphone hanya dengan 1 sentuhan.
                        </p>
                    </div>
                    <div class="pt-4 border-t border-zinc-800/60">
                        <span class="text-[11px] font-semibold text-sky-400 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-sky-400"></span>
                            <span>Mobile Native &bull; QR Code Profil</span>
                        </span>
                    </div>
                </div>

                <!-- Tile 4: Analitik Real-Time Privasi -->
                <div class="spotlight-card p-6 sm:p-7 rounded-3xl bg-zinc-900/60 border border-zinc-800 hover:border-amber-500/40 transition-all flex flex-col justify-between group">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="20" x2="12" y2="10"></line>
                                <line x1="18" y1="20" x2="18" y2="4"></line>
                                <line x1="6" y1="20" x2="6" y2="16"></line>
                            </svg>
                        </div>
                        <h3 class="font-bold text-lg text-white">Analitik Tanpa Iklan Pelacak</h3>
                        <p class="text-xs text-zinc-400 leading-relaxed">
                            Pantau jumlah pengunjung profil, link paling populer, dan jenis perangkat audiens secara akurat tanpa melacak identitas pribadi pengunjung (Zero-Tracker).
                        </p>
                    </div>
                    <div class="pt-4 border-t border-zinc-800/60">
                        <span class="text-[11px] font-semibold text-amber-400 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                            <span>100% GDPR Compliant &bull; Export CSV</span>
                        </span>
                    </div>
                </div>

                <!-- Tile 5: Kustomisasi Wallpaper & Figuran Maskot -->
                <div class="spotlight-card p-6 sm:p-7 rounded-3xl bg-zinc-900/60 border border-zinc-800 hover:border-purple-500/40 transition-all flex flex-col justify-between group">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-2xl bg-purple-500/10 border border-purple-500/20 text-purple-400 flex items-center justify-center group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <circle cx="13.5" cy="6.5" r=".5" fill="currentColor"></circle>
                                <circle cx="17.5" cy="10.5" r=".5" fill="currentColor"></circle>
                                <circle cx="8.5" cy="7.5" r=".5" fill="currentColor"></circle>
                                <circle cx="6.5" cy="12.5" r=".5" fill="currentColor"></circle>
                                <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.563-2.512 5.563-5.563C21.996 6.5 17.5 2 12 2Z"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-lg text-white">Preset Tema & Wallpaper Bebas</h3>
                        <p class="text-xs text-zinc-400 leading-relaxed">
                            Pilih gaya visual dari 6 preset elegan atau unggah gambar wallpaper Anda sendiri dengan lapisan pengatur kegelapan (overlay dimmer) yang kontras.
                        </p>
                    </div>
                    <div class="pt-4 border-t border-zinc-800/60">
                        <span class="text-[11px] font-semibold text-purple-400 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-purple-400"></span>
                            <span>Bebas Upload File &bull; Figuran Kustom</span>
                        </span>
                    </div>
                </div>

            </div>
        </section>


        <!-- SECTION C: AI ASSISTANT CONCIERGE HIGHLIGHT -->
        <section id="ai-concierge" class="py-14 sm:py-24 px-4 sm:px-12 border-t border-zinc-800/80 bg-gradient-to-b from-zinc-950 via-zinc-900/40 to-zinc-950">
            <div class="max-w-7xl mx-auto flex flex-col lg:flex-row items-center gap-10 lg:gap-12">
                
                <!-- Left Details -->
                <div class="lg:w-1/2 space-y-6 text-left">
                    <span class="text-xs font-mono uppercase tracking-wider text-sky-400 font-bold block">ASISTEN PINTAR PRIBADI</span>
                    <h2 class="text-2xl sm:text-5xl font-black text-white tracking-tight leading-tight">
                        Asisten AI yang Bekerja Menyapa Audiens Anda 24/7
                    </h2>
                    <p class="text-xs sm:text-sm text-zinc-400 leading-relaxed">
                        Pengunjung situs bio Anda tidak lagi hanya menatap daftar tautan bisu. Mereka dapat berdialog langsung dengan Asisten AI yang Anda berdayakan. AI dapat menjelaskan detail portofolio, membagikan kontak penting, hingga menjawab penawaran kerja sama.
                    </p>

                    <div class="space-y-3 pt-2">
                        <div class="flex items-start gap-3">
                            <span class="w-5 h-5 rounded-full bg-sky-500/20 text-sky-400 flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">&check;</span>
                            <div>
                                <h4 class="font-bold text-xs sm:text-sm text-white">Basis Pengetahuan Kustom</h4>
                                <p class="text-xs text-zinc-400">Atur instruksi sistem, FAQ pribadi, ringkasan CV, dan batasan topik obrolan langsung dari dasbor.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="w-5 h-5 rounded-full bg-sky-500/20 text-sky-400 flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">&check;</span>
                            <div>
                                <h4 class="font-bold text-xs sm:text-sm text-white">Karakter & Figuran Maskot Interaktif</h4>
                                <p class="text-xs text-zinc-400">Pilih dari avatar robot, desainer, figur kartun, atau pasang foto profil Anda sendiri untuk menyapa pengunjung.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="w-5 h-5 rounded-full bg-sky-500/20 text-sky-400 flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">&check;</span>
                            <div>
                                <h4 class="font-bold text-xs sm:text-sm text-white">Multi-LLM Provider API</h4>
                                <p class="text-xs text-zinc-400">Gunakan API OpenAI (GPT-4o), DeepSeek Chat, Groq ultra-cepat, atau koneksikan server Ollama lokal milik Anda.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Visual: Interactive Chat Simulation Bento Card -->
                <div class="lg:w-1/2 w-full">
                    <div class="rounded-3xl border border-zinc-800 bg-zinc-900/80 p-5 sm:p-6 shadow-2xl space-y-4">
                        <div class="flex items-center justify-between border-b border-zinc-800 pb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-sky-400 to-indigo-500 p-0.5">
                                    <img src="https://api.dicebear.com/7.x/bottts-neutral/svg?seed=AuraBot&backgroundColor=0284c7" alt="Aura Figurine" class="w-full h-full object-cover rounded-full">
                                </div>
                                <div>
                                    <h4 class="font-bold text-xs sm:text-sm text-white">Aura Concierge AI</h4>
                                    <p class="text-[10px] text-emerald-400 font-mono">Ditenagai DeepSeek &bull; Responsif &bull; Aktif</p>
                                </div>
                            </div>
                            <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-zinc-800 text-zinc-400">Kecepatan: ~240ms</span>
                        </div>

                        <!-- Chat Bubbles Simulation -->
                        <div class="space-y-3 text-xs">
                            <div class="flex items-start gap-2.5">
                                <div class="w-7 h-7 rounded-full bg-zinc-800 text-zinc-300 flex items-center justify-center text-xs font-bold flex-shrink-0">T</div>
                                <div class="p-3 rounded-2xl rounded-tl-none bg-zinc-800 text-zinc-200 max-w-sm">
                                    Halo! Apakah Anda sedang membuka lowongan konsultasi proyek?
                                </div>
                            </div>

                            <div class="flex items-start gap-2.5">
                                <div class="w-7 h-7 rounded-full bg-sky-500/20 text-sky-400 flex items-center justify-center text-xs font-bold flex-shrink-0">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2 2 2 0 0 1-2-2V4a2 2 0 0 1 2-2Z"/></svg>
                                </div>
                                <div class="p-3 rounded-2xl rounded-tl-none bg-sky-500/10 border border-sky-500/20 text-sky-100 max-w-sm space-y-1.5 leading-relaxed">
                                    <p>Tentu saja! Kami saat ini terbuka untuk konsultasi teknis, kolaborasi proyek kreatif, dan pengembangan aplikasi web modern.</p>
                                    <p class="text-[11px] text-zinc-400">Anda dapat menghubungi langsung via saluran pesan atau mengklik tombol Simpan Kontak di bio.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Action Chips -->
                        <div class="flex items-center gap-2 pt-2 flex-wrap">
                            <button type="button" class="text-[11px] px-3 py-1.5 rounded-full bg-zinc-800/80 hover:bg-zinc-800 text-zinc-300 border border-zinc-700/60 transition-colors">
                                "Apa proyek terbarunya?"
                            </button>
                            <button type="button" class="text-[11px] px-3 py-1.5 rounded-full bg-zinc-800/80 hover:bg-zinc-800 text-zinc-300 border border-zinc-700/60 transition-colors">
                                "Bagaimana cara kerja vCard?"
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </section>


        <!-- SECTION D: PRESET TEMA (THEMES GALLERY) -->
        <section id="tema" class="py-14 sm:py-24 px-4 sm:px-12 border-t border-zinc-800/80 max-w-7xl mx-auto w-full">
            <div class="text-center mb-10 sm:mb-16 space-y-3">
                <span class="text-xs font-mono uppercase tracking-wider text-purple-400 font-bold block">PRESET TEMA SIAP PAKAI</span>
                <h2 class="text-2xl sm:text-5xl font-black text-white tracking-tight">Pilih Gaya yang Sesuai dengan Persona Anda</h2>
                <p class="text-xs sm:text-sm text-zinc-400 max-w-xl mx-auto">Tersedia beragam preset tema dengan palet warna dan efek visual khas yang siap digunakan dalam 1-klik.</p>
            </div>

            <!-- Theme Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <!-- Theme 1: Dark Luxury -->
                <div class="p-5 rounded-3xl bg-zinc-900 border border-zinc-800 hover:border-zinc-600 transition-all space-y-3 group">
                    <div class="h-32 rounded-2xl bg-gradient-to-br from-zinc-950 via-zinc-900 to-zinc-950 border border-zinc-800 flex items-center justify-center p-4">
                        <div class="w-full max-w-[180px] p-2.5 rounded-xl bg-white/5 border border-white/10 text-center">
                            <span class="text-xs font-bold text-white block">Dark Luxury</span>
                            <span class="text-[10px] text-sky-400 font-mono">Modern &bull; Clean</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-sm text-white">Dark Luxury</span>
                        <div class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded-full bg-zinc-950 border border-zinc-700"></span>
                            <span class="w-3 h-3 rounded-full bg-sky-400"></span>
                            <span class="w-3 h-3 rounded-full bg-indigo-500"></span>
                        </div>
                    </div>
                </div>

                <!-- Theme 2: Midnight Indigo -->
                <div class="p-5 rounded-3xl bg-zinc-900 border border-zinc-800 hover:border-indigo-500/50 transition-all space-y-3 group">
                    <div class="h-32 rounded-2xl bg-gradient-to-br from-slate-950 via-indigo-950 to-slate-900 border border-indigo-900/40 flex items-center justify-center p-4">
                        <div class="w-full max-w-[180px] p-2.5 rounded-xl bg-indigo-500/10 border border-indigo-500/25 text-center">
                            <span class="text-xs font-bold text-white block">Midnight Indigo</span>
                            <span class="text-[10px] text-indigo-300 font-mono">Deep Cosmos</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-sm text-white">Midnight Indigo</span>
                        <div class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded-full bg-slate-950 border border-zinc-700"></span>
                            <span class="w-3 h-3 rounded-full bg-indigo-500"></span>
                            <span class="w-3 h-3 rounded-full bg-purple-500"></span>
                        </div>
                    </div>
                </div>

                <!-- Theme 3: Emerald Glass -->
                <div class="p-5 rounded-3xl bg-zinc-900 border border-zinc-800 hover:border-emerald-500/50 transition-all space-y-3 group">
                    <div class="h-32 rounded-2xl bg-gradient-to-br from-emerald-950 via-teal-950 to-zinc-950 border border-emerald-900/40 flex items-center justify-center p-4">
                        <div class="w-full max-w-[180px] p-2.5 rounded-xl bg-emerald-500/10 border border-emerald-500/25 text-center">
                            <span class="text-xs font-bold text-white block">Emerald Glass</span>
                            <span class="text-[10px] text-emerald-300 font-mono">Nature Minimal</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-sm text-white">Emerald Glass</span>
                        <div class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded-full bg-emerald-950 border border-zinc-700"></span>
                            <span class="w-3 h-3 rounded-full bg-emerald-400"></span>
                            <span class="w-3 h-3 rounded-full bg-teal-400"></span>
                        </div>
                    </div>
                </div>

                <!-- Theme 4: Cyberpunk Neon -->
                <div class="p-5 rounded-3xl bg-zinc-900 border border-zinc-800 hover:border-pink-500/50 transition-all space-y-3 group">
                    <div class="h-32 rounded-2xl bg-gradient-to-br from-zinc-950 via-pink-950/40 to-cyan-950/40 border border-pink-900/40 flex items-center justify-center p-4">
                        <div class="w-full max-w-[180px] p-2.5 rounded-xl bg-pink-500/10 border border-pink-500/30 text-center">
                            <span class="text-xs font-bold text-white block">Cyberpunk Neon</span>
                            <span class="text-[10px] text-pink-400 font-mono">Electric Vibe</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-sm text-white">Cyberpunk Neon</span>
                        <div class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded-full bg-pink-500"></span>
                            <span class="w-3 h-3 rounded-full bg-cyan-400"></span>
                            <span class="w-3 h-3 rounded-full bg-yellow-400"></span>
                        </div>
                    </div>
                </div>

                <!-- Theme 5: Sunset Amber -->
                <div class="p-5 rounded-3xl bg-zinc-900 border border-zinc-800 hover:border-amber-500/50 transition-all space-y-3 group">
                    <div class="h-32 rounded-2xl bg-gradient-to-br from-zinc-950 via-amber-950/40 to-rose-950/40 border border-amber-900/40 flex items-center justify-center p-4">
                        <div class="w-full max-w-[180px] p-2.5 rounded-xl bg-amber-500/10 border border-amber-500/30 text-center">
                            <span class="text-xs font-bold text-white block">Sunset Amber</span>
                            <span class="text-[10px] text-amber-300 font-mono">Warm Golden</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-sm text-white">Sunset Amber</span>
                        <div class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                            <span class="w-3 h-3 rounded-full bg-orange-500"></span>
                            <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                        </div>
                    </div>
                </div>

                <!-- Theme 6: Nord Frost -->
                <div class="p-5 rounded-3xl bg-zinc-900 border border-zinc-800 hover:border-sky-400/50 transition-all space-y-3 group">
                    <div class="h-32 rounded-2xl bg-gradient-to-br from-slate-900 via-sky-950 to-slate-950 border border-sky-800/40 flex items-center justify-center p-4">
                        <div class="w-full max-w-[180px] p-2.5 rounded-xl bg-sky-400/10 border border-sky-400/30 text-center">
                            <span class="text-xs font-bold text-white block">Nord Frost</span>
                            <span class="text-[10px] text-sky-300 font-mono">Arctic Modern</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-sm text-white">Nord Frost</span>
                        <div class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded-full bg-slate-800 border border-zinc-700"></span>
                            <span class="w-3 h-3 rounded-full bg-sky-400"></span>
                            <span class="w-3 h-3 rounded-full bg-teal-300"></span>
                        </div>
                    </div>
                </div>

            </div>
        </section>


        <!-- SECTION E: KEUNGGULAN / COMPARISON -->
        <section id="keunggulan" class="py-14 sm:py-24 px-4 sm:px-12 border-t border-zinc-800/80 max-w-6xl mx-auto w-full">
            <div class="text-center mb-10 sm:mb-16 space-y-3">
                <span class="text-xs font-mono uppercase tracking-wider text-emerald-400 font-bold block">PERBANDINGAN</span>
                <h2 class="text-2xl sm:text-5xl font-black text-white tracking-tight">Mengapa Memilih BioLink?</h2>
                <p class="text-xs sm:text-sm text-zinc-400 max-w-xl mx-auto">Lihat bagaimana BioLink memberikan nilai jauh lebih tinggi dibandingkan platform konvensional.</p>
            </div>

            <!-- Mobile Card-Based Feature Comparison (Clean Stacked on Phones) -->
            <div class="md:hidden space-y-3 text-xs">
                @php
                    $comparisons = [
                        ['title' => 'Biaya & Langganan Bulanan', 'biolink' => '100% Gratis Tanpa Langganan', 'other' => '$5 – $24 per bulan'],
                        ['title' => 'Asisten Obrolan AI (Concierge)', 'biolink' => 'Tersedia 24/7 (OpenAI, DeepSeek, Groq)', 'other' => 'Tidak ada (Hanya link statis)'],
                        ['title' => 'Keamanan AI & Limit Anti-Spam IP', 'biolink' => 'Lengkap (Anti-Jailbreak, Rate Limit, Honeypot)', 'other' => 'Tidak ada proteksi'],
                        ['title' => 'Kustomisasi Wallpaper & Figuran', 'biolink' => 'Bebas Upload File & Kostum Maskot', 'other' => 'Terkunci di tier Pro berbayar'],
                        ['title' => 'Privasi Data & Analitik Real-Time', 'biolink' => 'Privasi Penuh, Bebas Iklan Pelacak', 'other' => 'Pelacak iklan pihak ke-3 aktif'],
                        ['title' => 'Simpan Kontak vCard Native', 'biolink' => '1-Klik Download Kontak Ponsel (.vcf)', 'other' => 'Jarang tersedia'],
                    ];
                @endphp

                @foreach($comparisons as $item)
                    <div class="p-4 rounded-2xl bg-zinc-900/80 border border-zinc-800 space-y-2.5">
                        <div class="font-bold text-white text-xs flex items-center justify-between">
                            <span>{{ $item['title'] }}</span>
                            <span class="text-[9px] font-mono px-1.5 py-0.2 rounded bg-sky-500/20 text-sky-300 font-bold">KOMPARASI</span>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-[11px]">
                            <div class="p-2.5 rounded-xl bg-emerald-500/10 border border-emerald-500/25 text-emerald-400 font-bold leading-snug">
                                <span class="text-[9px] font-mono text-emerald-300/80 block uppercase tracking-wider mb-0.5">BioLink AI:</span>
                                <span>&check; {{ $item['biolink'] }}</span>
                            </div>
                            <div class="p-2.5 rounded-xl bg-zinc-800/40 border border-zinc-800 text-zinc-400 leading-snug">
                                <span class="text-[9px] font-mono text-zinc-500 block uppercase tracking-wider mb-0.5">Platform Lain:</span>
                                <span>&cross; {{ $item['other'] }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Desktop 3-Column Table -->
            <div class="hidden md:block overflow-x-auto rounded-3xl border border-zinc-800 bg-zinc-900/60 shadow-xl">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="border-b border-zinc-800 bg-zinc-900">
                            <th class="p-4 sm:p-5 font-bold text-zinc-400">Fitur & Kemampuan</th>
                            <th class="p-4 sm:p-5 font-black text-sky-400 bg-sky-500/10 border-x border-sky-500/20">BioLink AI Platform</th>
                            <th class="p-4 sm:p-5 font-bold text-zinc-500">Platform Konvensional Lain</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-800/60 text-zinc-300">
                        <tr>
                            <td class="p-4 sm:p-5 font-medium">Biaya & Langganan Bulanan</td>
                            <td class="p-4 sm:p-5 font-bold text-emerald-400 bg-sky-500/5 border-x border-sky-500/20">100% Gratis / Tanpa Biaya Bulanan</td>
                            <td class="p-4 sm:p-5 text-zinc-500">$5 – $24 per bulan</td>
                        </tr>
                        <tr>
                            <td class="p-4 sm:p-5 font-medium">Asisten Obrolan AI (Concierge)</td>
                            <td class="p-4 sm:p-5 font-bold text-emerald-400 bg-sky-500/5 border-x border-sky-500/20">Tersedia 24/7 (OpenAI, DeepSeek, Groq)</td>
                            <td class="p-4 sm:p-5 text-zinc-500">Tidak ada (Hanya link statis)</td>
                        </tr>
                        <tr>
                            <td class="p-4 sm:p-5 font-medium">Keamanan AI & Limit Anti-Spam IP</td>
                            <td class="p-4 sm:p-5 font-bold text-emerald-400 bg-sky-500/5 border-x border-sky-500/20">Lengkap (Anti-Jailbreak, Rate Limit IP, Honeypot)</td>
                            <td class="p-4 sm:p-5 text-zinc-500">Tidak ada</td>
                        </tr>
                        <tr>
                            <td class="p-4 sm:p-5 font-medium">Kustomisasi Wallpaper & Figuran</td>
                            <td class="p-4 sm:p-5 font-bold text-emerald-400 bg-sky-500/5 border-x border-sky-500/20">Bebas Upload File, Dimmer, Figuran Kustom</td>
                            <td class="p-4 sm:p-5 text-zinc-500">Terkunci di tier Pro berbayar</td>
                        </tr>
                        <tr>
                            <td class="p-4 sm:p-5 font-medium">Privasi Data & Analitik</td>
                            <td class="p-4 sm:p-5 font-bold text-emerald-400 bg-sky-500/5 border-x border-sky-500/20">Privasi Penuh, Tanpa Tracking Iklan Pihak Ke-3</td>
                            <td class="p-4 sm:p-5 text-zinc-500">Pelacak iklan pihak ke-3 aktif</td>
                        </tr>
                        <tr>
                            <td class="p-4 sm:p-5 font-medium">Simpan Kontak vCard Native</td>
                            <td class="p-4 sm:p-5 font-bold text-emerald-400 bg-sky-500/5 border-x border-sky-500/20">1-Klik Download Kontak Smartphone</td>
                            <td class="p-4 sm:p-5 text-zinc-500">Jarang tersedia</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>


        <!-- SECTION F: PERTANYAAN UMUM (FAQ ACCORDION) -->
        <section id="faq" class="py-14 sm:py-20 px-4 sm:px-12 border-t border-zinc-800/80 max-w-4xl mx-auto w-full">
            <div class="text-center mb-10 sm:mb-16 space-y-3">
                <span class="text-xs font-mono uppercase tracking-wider text-sky-400 font-bold block">FAQ</span>
                <h2 class="text-2xl sm:text-5xl font-black text-white tracking-tight">Pertanyaan yang Sering Diajukan</h2>
                <p class="text-xs sm:text-sm text-zinc-400">Punya pertanyaan seputar cara kerja platform BioLink? Temukan jawabannya di sini.</p>
            </div>

            <div class="space-y-3 text-xs">
                <!-- FAQ 1 -->
                <div class="rounded-2xl border border-zinc-800 bg-zinc-900/60 p-4 sm:p-5 cursor-pointer hover:border-zinc-700 transition-colors" onclick="toggleFaq(this)">
                    <div class="flex items-center justify-between gap-3">
                        <h4 class="font-bold text-xs sm:text-sm text-white">Apakah BioLink benar-benar gratis?</h4>
                        <span class="faq-icon text-zinc-400 text-base font-bold flex-shrink-0">+</span>
                    </div>
                    <p class="faq-answer mt-3 text-zinc-400 leading-relaxed hidden">
                        Ya! Anda dapat mendaftar, membuat halaman bio kustom, menambahkan tautan tak terbatas, mengatur tema, dan menggunakan seluruh fitur analitik tanpa biaya berlangganan.
                    </p>
                </div>

                <!-- FAQ 2 -->
                <div class="rounded-2xl border border-zinc-800 bg-zinc-900/60 p-4 sm:p-5 cursor-pointer hover:border-zinc-700 transition-colors" onclick="toggleFaq(this)">
                    <div class="flex items-center justify-between gap-3">
                        <h4 class="font-bold text-xs sm:text-sm text-white">Bagaimana cara kerja Asisten AI Concierge?</h4>
                        <span class="faq-icon text-zinc-400 text-base font-bold flex-shrink-0">+</span>
                    </div>
                    <p class="faq-answer mt-3 text-zinc-400 leading-relaxed hidden">
                        Asisten AI bekerja berdasarkan data pengetahuan yang Anda isi di menu Studio Dasbor (seperti biodata, portofolio proyek, FAQ, dan cara kontak). Anda juga bisa menghubungkan API Key Anda sendiri (OpenAI, DeepSeek, Groq, atau Ollama) untuk respon yang sangat cerdas dan natural.
                    </p>
                </div>

                <!-- FAQ 3 -->
                <div class="rounded-2xl border border-zinc-800 bg-zinc-900/60 p-4 sm:p-5 cursor-pointer hover:border-zinc-700 transition-colors" onclick="toggleFaq(this)">
                    <div class="flex items-center justify-between gap-3">
                        <h4 class="font-bold text-xs sm:text-sm text-white">Apakah API Key saya aman dari kebocoran atau spam?</h4>
                        <span class="faq-icon text-zinc-400 text-base font-bold flex-shrink-0">+</span>
                    </div>
                    <p class="faq-answer mt-3 text-zinc-400 leading-relaxed hidden">
                        Sangat aman. API Key Anda disimpan di database server dan tidak pernah dikirim ke browser pengunjung. Selain itu, terdapat AI Security Shield dengan batas rate limit per IP, auto-ban untuk pelaku spam, serta AI Firewall yang memblokir serangan prompt injection / jailbreak.
                    </p>
                </div>

                <!-- FAQ 4 -->
                <div class="rounded-2xl border border-zinc-800 bg-zinc-900/60 p-4 sm:p-5 cursor-pointer hover:border-zinc-700 transition-colors" onclick="toggleFaq(this)">
                    <div class="flex items-center justify-between gap-3">
                        <h4 class="font-bold text-xs sm:text-sm text-white">Bisakah saya menggunakan wallpaper gambar kustom saya sendiri?</h4>
                        <span class="faq-icon text-zinc-400 text-base font-bold flex-shrink-0">+</span>
                    </div>
                    <p class="faq-answer mt-3 text-zinc-400 leading-relaxed hidden">
                        Tentu saja! Di menu Tema, Anda bisa mengunggah file gambar wallpaper dari komputer/HP atau memasukkan link URL gambar. Anda juga dapat mengatur tingkat kegelapan lapisan (overlay dimmer) agar teks selalu kontras dan mudah dibaca.
                    </p>
                </div>
            </div>
        </section>


        <!-- SECTION G: FINAL CALL TO ACTION (CTA BANNER) -->
        <section class="py-14 sm:py-20 px-4 sm:px-12 bg-gradient-to-b from-zinc-900/40 via-zinc-950 to-zinc-950 border-t border-zinc-800/80 text-center relative overflow-hidden">
            <div class="max-w-3xl mx-auto space-y-5 sm:space-y-6 relative z-10">
                <span class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-sky-500/10 border border-sky-400/25 text-sky-400 flex items-center justify-center mx-auto mb-2 shadow-lg">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14m-7-7 7 7-7 7"/></svg>
                </span>
                
                <h2 class="text-2xl sm:text-5xl font-black text-white tracking-tight leading-tight">
                    Siap Membawa Link-in-Bio Anda ke Tingkat Berikutnya?
                </h2>
                
                <p class="text-xs sm:text-sm text-zinc-400 max-w-xl mx-auto leading-relaxed px-2">
                    Klaim tautan profil eksklusif Anda sekarang. Buat kartu tautan elegan, pasang karakter AI favorit Anda, dan bagikan karya Anda kepada dunia.
                </p>

                <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4">
                    <a href="{{ route('register') }}" class="btn-shimmer w-full sm:w-auto px-6 sm:px-8 py-3.5 sm:py-4 rounded-2xl bg-gradient-to-r from-sky-500 to-indigo-600 hover:from-sky-400 hover:to-indigo-500 text-white font-black text-xs sm:text-sm transition-all shadow-xl shadow-sky-500/25 inline-flex items-center justify-center gap-2">
                        <span>Buat Halaman Bio Sekarang &bull; Gratis</span>
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14m-7-7 7 7-7 7"/></svg>
                    </a>
                    
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-6 py-3.5 sm:py-4 rounded-2xl bg-zinc-900 hover:bg-zinc-800 border border-zinc-800 text-zinc-300 hover:text-white font-bold text-xs sm:text-sm transition-colors">
                        Masuk ke Studio
                    </a>
                </div>
            </div>
        </section>

    </main>


    <!-- ========================================================================= -->
    <!-- 3. FOOTER (SEMANTIC STRUCTURED FOOTER)                                    -->
    <!-- ========================================================================= -->
    <footer class="border-t border-zinc-800/80 bg-zinc-950 px-4 sm:px-12 pt-12 sm:pt-16 pb-12 text-xs text-zinc-400">
        <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 sm:gap-10 pb-12 border-b border-zinc-850">
            
            <!-- Col 1: Brand & Mission -->
            <div class="sm:col-span-2 space-y-3 sm:space-y-4 text-left">
                <a href="/" class="flex items-center gap-2.5 font-black text-lg text-white">
                    <img src="{{ asset('Logo.png') }}" alt="Logo" class="h-8 w-auto object-contain">
                    <span>BioLink<span class="text-sky-400">.</span></span>
                </a>
                <p class="text-zinc-400 max-w-sm leading-relaxed text-xs">
                    Platform link-in-bio open architecture generasi baru. Menggabungkan kemudahan kartu bento interaktif dengan kecerdasan Asisten AI dan analitik real-time berkecepatan tinggi.
                </p>
                <div class="flex items-center gap-2 text-zinc-500 font-mono text-[11px]">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    <span>All Systems Operational</span>
                </div>
            </div>

            <!-- Col 2: Fitur Platform -->
            <div class="space-y-3 text-left">
                <h4 class="font-bold text-white uppercase tracking-wider text-[11px]">Fitur Platform</h4>
                <ul class="space-y-2 text-zinc-400">
                    <li><a href="#fitur" class="hover:text-white transition-colors">Bento Card Links</a></li>
                    <li><a href="#ai-concierge" class="hover:text-white transition-colors">Smart AI Concierge</a></li>
                    <li><a href="#tema" class="hover:text-white transition-colors">Koleksi 6 Tema</a></li>
                    <li><a href="#fitur" class="hover:text-white transition-colors">Simpan vCard</a></li>
                    <li><a href="#fitur" class="hover:text-white transition-colors">Analitik Privasi</a></li>
                </ul>
            </div>

            <!-- Col 3: Pengembang -->
            <div class="space-y-3 text-left">
                <h4 class="font-bold text-white uppercase tracking-wider text-[11px]">Pengembang</h4>
                <ul class="space-y-2 text-zinc-400">
                    <li><a href="https://github.com/windri-dev/biolink" target="_blank" class="hover:text-white transition-colors flex items-center gap-1">GitHub Repositori</a></li>
                    <li><a href="/login" class="hover:text-white transition-colors">Masuk Studio</a></li>
                    <li><a href="/register" class="hover:text-white transition-colors">Klaim Handle</a></li>
                    <li><a href="/sitemap.xml" class="hover:text-white transition-colors">Sitemap XML</a></li>
                </ul>
            </div>

        </div>

        <!-- Bottom Copyright Row -->
        <div class="max-w-7xl mx-auto pt-8 flex items-center justify-center sm:justify-between text-zinc-500 text-[11px] text-center sm:text-left">
            <p>&copy; {{ date('Y') }} BioLink Platform. Hak cipta dilindungi undang-undang.</p>
        </div>
    </footer>

    <!-- Simple JavaScript for Interactions -->
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const hamburger = document.getElementById('hamburgerIcon');
            const close = document.getElementById('closeMenuIcon');
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                hamburger.classList.add('hidden');
                close.classList.remove('hidden');
            } else {
                menu.classList.add('hidden');
                hamburger.classList.remove('hidden');
                close.classList.add('hidden');
            }
        }

        function toggleFaq(card) {
            const answer = card.querySelector('.faq-answer');
            const icon = card.querySelector('.faq-icon');
            if (answer.classList.contains('hidden')) {
                answer.classList.remove('hidden');
                icon.innerText = '−';
                icon.classList.add('text-sky-400');
            } else {
                answer.classList.add('hidden');
                icon.innerText = '+';
                icon.classList.remove('text-sky-400');
            }
        }

        function toggleHeroMockupChat() {
            const box = document.getElementById('heroMockupChatBox');
            const toggleText = document.getElementById('heroChatToggleText');
            if (box.classList.contains('hidden')) {
                box.classList.remove('hidden');
                toggleText.innerText = 'Tutup ✕';
            } else {
                box.classList.add('hidden');
                toggleText.innerText = 'Coba →';
            }
        }

        function switchHeroMockupTheme(theme, btn) {
            const card = document.getElementById('heroMockupCard');
            const pills = document.querySelectorAll('.theme-pill');
            pills.forEach(p => {
                p.className = 'theme-pill px-2.5 py-1 rounded-full text-[10px] font-semibold bg-zinc-900 text-zinc-400 border border-zinc-800 hover:text-white transition-all';
            });
            btn.className = 'theme-pill px-2.5 py-1 rounded-full text-[10px] font-semibold bg-zinc-800 text-sky-400 border border-sky-500/50 shadow-sm transition-all';

            const name = document.getElementById('mockupName');
            const handle = document.getElementById('mockupHandle');
            const bio = document.getElementById('mockupBio');
            const linkCards = card.querySelectorAll('.mockup-link-card');

            if (theme === 'dark') {
                card.style.background = 'rgba(24, 24, 27, 0.95)';
                card.style.borderColor = 'rgba(63, 63, 70, 0.8)';
                name.style.color = '#ffffff';
                handle.style.color = '#38bdf8';
                bio.style.color = '#a1a1aa';
                linkCards.forEach(c => {
                    c.style.background = 'rgba(255, 255, 255, 0.05)';
                    c.style.borderColor = 'rgba(255, 255, 255, 0.1)';
                });
            } else if (theme === 'midnight') {
                card.style.background = 'linear-gradient(180deg, #0f172a 0%, #020617 100%)';
                card.style.borderColor = 'rgba(99, 102, 241, 0.4)';
                name.style.color = '#ffffff';
                handle.style.color = '#818cf8';
                bio.style.color = '#94a3b8';
                linkCards.forEach(c => {
                    c.style.background = 'rgba(99, 102, 241, 0.1)';
                    c.style.borderColor = 'rgba(99, 102, 241, 0.25)';
                });
            } else if (theme === 'emerald') {
                card.style.background = 'linear-gradient(180deg, #064e3b 0%, #022c22 100%)';
                card.style.borderColor = 'rgba(16, 185, 129, 0.4)';
                name.style.color = '#ffffff';
                handle.style.color = '#34d399';
                bio.style.color = '#a7f3d0';
                linkCards.forEach(c => {
                    c.style.background = 'rgba(16, 185, 129, 0.12)';
                    c.style.borderColor = 'rgba(16, 185, 129, 0.3)';
                });
            } else if (theme === 'minimal') {
                card.style.background = '#f4f4f5';
                card.style.borderColor = '#d4d4d8';
                name.style.color = '#09090b';
                handle.style.color = '#0284c7';
                bio.style.color = '#52525b';
                linkCards.forEach(c => {
                    c.style.background = '#ffffff';
                    c.style.borderColor = '#e4e4e7';
                });
            }
        }

        // 21st-inspired Cursor Spotlight Tracking
        document.addEventListener('DOMContentLoaded', () => {
            const cards = document.querySelectorAll('.spotlight-card');
            cards.forEach(card => {
                card.addEventListener('mousemove', (e) => {
                    const rect = card.getBoundingClientRect();
                    card.style.setProperty('--mouse-x', `${e.clientX - rect.left}px`);
                    card.style.setProperty('--mouse-y', `${e.clientY - rect.top}px`);
                });
            });
        });
    </script>
</body>
</html>
