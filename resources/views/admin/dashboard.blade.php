@extends('layouts.admin')

@section('title', 'Dasbor Creator')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">

    <!-- ========================================================================= -->
    <!-- 1. CREATOR HERO BENTO HEADER                                              -->
    <!-- ========================================================================= -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-zinc-900/90 via-zinc-900/60 to-zinc-950 border border-zinc-800 p-6 sm:p-8 backdrop-blur-xl shadow-2xl">
        <!-- Ambient Radial Glow -->
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-sky-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <!-- Left: Creator Info -->
            <div class="flex items-start sm:items-center gap-4">
                <div class="relative flex-shrink-0">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl p-0.5 bg-gradient-to-tr from-sky-400 via-indigo-500 to-purple-500 shadow-xl overflow-hidden">
                        <img src="{{ $profile->avatar_url ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=200' }}" 
                             alt="{{ $profile->display_name }}" 
                             class="w-full h-full object-cover rounded-2xl bg-zinc-950">
                    </div>
                    <span class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full bg-emerald-500 border-2 border-zinc-950 ring-2 ring-emerald-500/30" title="Profil Publik Aktif"></span>
                </div>

                <div class="space-y-1 min-w-0">
                    <div class="flex items-center gap-2 flex-wrap">
                        <h1 class="text-xl sm:text-2xl font-black text-white tracking-tight truncate">
                            {{ $profile->display_name }}
                        </h1>
                        @if($profile->is_verified)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-sky-500/15 text-sky-400 border border-sky-500/30 text-[10px] font-bold">
                                <i data-lucide="badge-check" class="w-3.5 h-3.5 fill-current"></i>
                                <span>{{ $profile->verified_title ?: 'Verified' }}</span>
                            </span>
                        @endif
                        <span class="px-2 py-0.5 rounded bg-zinc-800/80 text-zinc-400 border border-zinc-700/80 text-[10px] font-mono font-semibold">
                            Tema: {{ $profile->theme?->name ?: 'Dark Luxury' }}
                        </span>
                    </div>

                    <p class="text-xs text-zinc-400 max-w-xl truncate">
                        {{ $profile->tagline ?: ($profile->bio ?: 'Kelola tautan penting, portofolio, dan interaksi AI Anda dari satu pusat kontrol.') }}
                    </p>

                    <!-- Handle & Copy Action -->
                    <div class="flex items-center gap-2 pt-1 flex-wrap">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-zinc-950/70 border border-zinc-800 text-xs font-mono text-zinc-300">
                            <span class="text-sky-400">biolink/</span><span>{{ '@' . $profile->clean_handle }}</span>
                        </div>
                        <button type="button" 
                                onclick="copyPublicBioUrl('{{ url('/@' . $profile->clean_handle) }}', this)" 
                                class="px-2.5 py-1 rounded-xl bg-zinc-800/80 hover:bg-zinc-700 text-zinc-300 hover:text-white border border-zinc-700 text-xs font-semibold inline-flex items-center gap-1.5 transition-colors">
                            <i data-lucide="copy" class="w-3.5 h-3.5 text-zinc-400"></i>
                            <span>Salin URL</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right: Fast Actions Toolbar -->
            <div class="flex items-center gap-2.5 flex-wrap self-start lg:self-center">
                <a href="{{ route('public.bio.at', $profile->clean_handle) }}" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="px-4 py-2.5 rounded-xl bg-zinc-800/80 hover:bg-zinc-700 text-white text-xs font-bold transition-all border border-zinc-700 inline-flex items-center gap-2 shadow-sm">
                    <i data-lucide="external-link" class="w-4 h-4 text-sky-400"></i>
                    <span>Buka Bio</span>
                </a>

                <a href="{{ route('admin.links.index') }}" 
                   class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-sky-500 to-indigo-600 hover:from-sky-400 hover:to-indigo-500 text-white text-xs font-bold transition-all shadow-lg shadow-sky-500/25 inline-flex items-center gap-2 hover:scale-[1.02]">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    <span>Tambah Tautan Baru</span>
                </a>
            </div>
        </div>

        <!-- Profile Completeness Progress Strip -->
        <div class="mt-6 pt-5 border-t border-zinc-800/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
            <div class="flex items-center gap-2.5">
                <span class="text-zinc-400 font-medium">Kelengkapan Profil:</span>
                <div class="w-36 h-2 rounded-full bg-zinc-800 overflow-hidden relative">
                    <div class="h-full bg-gradient-to-r from-sky-400 to-emerald-400 rounded-full transition-all duration-700" style="width: {{ $profileCompleteness }}%;"></div>
                </div>
                <span class="font-mono font-bold text-sky-400">{{ $profileCompleteness }}%</span>
            </div>

            <div class="flex items-center gap-3 text-zinc-400 text-[11px] flex-wrap">
                <a href="{{ route('admin.profile.index') }}" class="hover:text-white transition-colors flex items-center gap-1">
                    <i data-lucide="user-cog" class="w-3.5 h-3.5 text-zinc-500"></i>
                    <span>Edit Profil</span>
                </a>
                <span>&bull;</span>
                <a href="{{ route('admin.themes.index') }}" class="hover:text-white transition-colors flex items-center gap-1">
                    <i data-lucide="palette" class="w-3.5 h-3.5 text-zinc-500"></i>
                    <span>Ganti Tema</span>
                </a>
                <span>&bull;</span>
                <a href="{{ route('admin.ai-knowledge.index') }}" class="hover:text-white transition-colors flex items-center gap-1">
                    <i data-lucide="brain" class="w-3.5 h-3.5 text-zinc-500"></i>
                    <span>Otak AI ({{ $aiKnowledgeCount }} Pengetahuan)</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- 2. SECURITY NOTICE (2FA ENCOURAGEMENT CARD)                               -->
    <!-- ========================================================================= -->
    @if(!auth()->user()->hasTwoFactorEnabled())
        <div class="bg-gradient-to-r from-amber-950/40 via-zinc-900 to-zinc-900 border border-amber-500/30 rounded-2xl p-4 sm:p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 shadow-lg">
            <div class="flex items-start sm:items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-500/15 border border-amber-500/30 text-amber-400 flex items-center justify-center flex-shrink-0">
                    <i data-lucide="shield-alert" class="w-5 h-5"></i>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-white flex items-center gap-2">
                        <span>Tingkatkan Keamanan Akun (2FA Belum Aktif)</span>
                        <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-amber-500/20 text-amber-300 font-bold border border-amber-500/40">Sangat Disarankan</span>
                    </h4>
                    <p class="text-xs text-zinc-400 mt-0.5">Lindungi halaman bio link dan data profil Anda dengan Autentikasi Dua Faktor (Google Authenticator / Authy) agar terhindar dari akses tidak sah.</p>
                </div>
            </div>
            <a href="{{ route('admin.security.2fa.index') }}" class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-400 text-zinc-950 text-xs font-bold transition-all shadow-md shadow-amber-500/20 inline-flex items-center gap-1.5 flex-shrink-0">
                <i data-lucide="shield-check" class="w-4 h-4"></i>
                <span>Aktifkan 2FA Sekarang</span>
            </a>
        </div>
    @endif

    <!-- ========================================================================= -->
    <!-- 3. FOUR CORE BENTO METRIC CARDS                                           -->
    <!-- ========================================================================= -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

        <!-- Card 1: Total Views -->
        <div class="spotlight-card bg-zinc-900/70 border border-zinc-800 hover:border-zinc-700/80 rounded-3xl p-5 relative overflow-hidden transition-all duration-300 shadow-xl group">
            <div class="flex items-center justify-between text-zinc-400 text-xs mb-3">
                <span class="font-semibold text-zinc-300">Total Kunjungan</span>
                <div class="w-8 h-8 rounded-xl bg-sky-500/10 border border-sky-500/20 text-sky-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i data-lucide="eye" class="w-4 h-4"></i>
                </div>
            </div>

            <div class="flex items-baseline justify-between gap-2">
                <span class="text-3xl font-black text-white font-mono tracking-tight">{{ number_format($totalViews) }}</span>
                @if($viewsDelta > 0)
                    <span class="text-[11px] font-mono font-bold text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded-full border border-emerald-500/20 flex items-center gap-0.5">
                        <i data-lucide="arrow-up-right" class="w-3 h-3"></i>
                        <span>+{{ $viewsDelta }}%</span>
                    </span>
                @elseif($viewsDelta < 0)
                    <span class="text-[11px] font-mono font-bold text-rose-400 bg-rose-500/10 px-2 py-0.5 rounded-full border border-rose-500/20 flex items-center gap-0.5">
                        <i data-lucide="arrow-down-right" class="w-3 h-3"></i>
                        <span>{{ $viewsDelta }}%</span>
                    </span>
                @else
                    <span class="text-[11px] font-mono text-zinc-500 bg-zinc-800 px-2 py-0.5 rounded-full">Tetap</span>
                @endif
            </div>

            <div class="flex items-center justify-between text-[11px] text-zinc-500 mt-3 pt-3 border-t border-zinc-800/80 font-mono">
                <span>Hari ini: <strong class="text-zinc-300">{{ number_format($todayViews) }}</strong></span>
                <span class="text-zinc-400">Total seumur hidup</span>
            </div>
        </div>

        <!-- Card 2: Total Clicks -->
        <div class="spotlight-card bg-zinc-900/70 border border-zinc-800 hover:border-zinc-700/80 rounded-3xl p-5 relative overflow-hidden transition-all duration-300 shadow-xl group">
            <div class="flex items-center justify-between text-zinc-400 text-xs mb-3">
                <span class="font-semibold text-zinc-300">Total Klik Tautan</span>
                <div class="w-8 h-8 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i data-lucide="mouse-pointer-click" class="w-4 h-4"></i>
                </div>
            </div>

            <div class="flex items-baseline justify-between gap-2">
                <span class="text-3xl font-black text-white font-mono tracking-tight">{{ number_format($totalClicks) }}</span>
                <span class="text-[11px] font-mono font-bold text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded-full border border-emerald-500/20">
                    Aksi Pengunjung
                </span>
            </div>

            <div class="flex items-center justify-between text-[11px] text-zinc-500 mt-3 pt-3 border-t border-zinc-800/80 font-mono">
                <span>Rata-rata: <strong class="text-zinc-300">{{ $activeLinksCount > 0 ? round($totalClicks / $activeLinksCount) : 0 }}</strong> / link</span>
                <span class="text-emerald-400">Interaksi Aktif</span>
            </div>
        </div>

        <!-- Card 3: Click-Through Rate (CTR) -->
        <div class="spotlight-card bg-zinc-900/70 border border-zinc-800 hover:border-zinc-700/80 rounded-3xl p-5 relative overflow-hidden transition-all duration-300 shadow-xl group">
            <div class="flex items-center justify-between text-zinc-400 text-xs mb-3">
                <span class="font-semibold text-zinc-300">Rasio Interaksi (CTR)</span>
                <div class="w-8 h-8 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i data-lucide="trending-up" class="w-4 h-4"></i>
                </div>
            </div>

            <div class="flex items-baseline justify-between gap-2">
                <span class="text-3xl font-black text-white font-mono tracking-tight">{{ $clickRate }}%</span>
                @if($clickRate >= 10)
                    <span class="text-[11px] font-mono font-bold text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded-full border border-emerald-500/20">
                        Sangat Tinggi
                    </span>
                @elseif($clickRate >= 4)
                    <span class="text-[11px] font-mono font-bold text-sky-400 bg-sky-500/10 px-2 py-0.5 rounded-full border border-sky-500/20">
                        Sehat
                    </span>
                @else
                    <span class="text-[11px] font-mono text-zinc-500 bg-zinc-800 px-2 py-0.5 rounded-full">
                        Normal
                    </span>
                @endif
            </div>

            <div class="flex items-center justify-between text-[11px] text-zinc-500 mt-3 pt-3 border-t border-zinc-800/80 font-mono">
                <span>Konversi klik per view</span>
                <span class="text-sky-400">Benchmark: &gt;5%</span>
            </div>
        </div>

        <!-- Card 4: AI Concierge Assistant -->
        <div class="spotlight-card bg-zinc-900/70 border border-zinc-800 hover:border-zinc-700/80 rounded-3xl p-5 relative overflow-hidden transition-all duration-300 shadow-xl group">
            <div class="flex items-center justify-between text-zinc-400 text-xs mb-3">
                <span class="font-semibold text-zinc-300">Asisten Pintar AI</span>
                <div class="w-8 h-8 rounded-xl bg-purple-500/10 border border-purple-500/20 text-purple-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i data-lucide="bot" class="w-4 h-4"></i>
                </div>
            </div>

            <div class="flex items-baseline justify-between gap-2">
                <span class="text-xl font-black text-white tracking-tight truncate">{{ $profile->ai_assistant_name ?: 'Aura' }}</span>
                @if($profile->ai_assistant_enabled)
                    <span class="text-[10px] font-mono font-bold text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded-full border border-emerald-500/20 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>Aktif 24/7</span>
                    </span>
                @else
                    <span class="text-[10px] font-mono text-zinc-500 bg-zinc-800 px-2 py-0.5 rounded-full">
                        Nonaktif
                    </span>
                @endif
            </div>

            <div class="flex items-center justify-between text-[11px] text-zinc-500 mt-3 pt-3 border-t border-zinc-800/80 font-mono">
                <span>{{ $aiKnowledgeCount }} Fakta Pengetahuan</span>
                <a href="{{ route('admin.ai-knowledge.index') }}" class="text-purple-400 hover:underline">Kelola &rarr;</a>
            </div>
        </div>

    </div>

    <!-- ========================================================================= -->
    <!-- 4. ANALYTICS BENTO SECTION (SVG SMOOTH SPLINE & TOP PERFORMING CARDS)     -->
    <!-- ========================================================================= -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Bento Left (2 Cols): 7-Day Traffic Area Chart with SVG Curve -->
        <div class="lg:col-span-2 bg-zinc-900/70 border border-zinc-800 rounded-3xl p-6 sm:p-7 space-y-6 shadow-xl relative overflow-hidden">
            <!-- Header Row -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h3 class="text-sm font-bold text-white flex items-center gap-2">
                        <i data-lucide="activity" class="w-4 h-4 text-sky-400"></i>
                        <span>Tren Kunjungan Profil (7 Hari Terakhir)</span>
                    </h3>
                    <p class="text-[11px] text-zinc-400">Pantau fluktuasi tayangan halaman bio secara real-time.</p>
                </div>

                <div class="flex items-center gap-2">
                    <span class="text-[11px] font-mono px-2.5 py-1 rounded-xl bg-zinc-800 text-zinc-300 border border-zinc-700/80">
                        7 Hari Terakhir
                    </span>
                    <a href="{{ route('admin.analytics.index') }}" class="text-xs font-semibold text-sky-400 hover:text-sky-300 transition-colors flex items-center gap-1">
                        <span>Detail Lengkap</span>
                        <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </div>

            <!-- SVG Smooth Area Spline Chart (Custom Styled Without External Heavy Libraries) -->
            <div class="relative w-full pt-2">
                <div class="w-full h-44 sm:h-52">
                    <svg viewBox="0 0 500 140" class="w-full h-full overflow-visible" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="chartGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" stop-color="#38bdf8" stop-opacity="0.35"/>
                                <stop offset="50%" stop-color="#6366f1" stop-opacity="0.15"/>
                                <stop offset="100%" stop-color="#38bdf8" stop-opacity="0"/>
                            </linearGradient>
                            <linearGradient id="strokeGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                <stop offset="0%" stop-color="#38bdf8"/>
                                <stop offset="100%" stop-color="#818cf8"/>
                            </linearGradient>
                            <filter id="glow" x="-20%" y="-20%" width="140%" height="140%">
                                <feGaussianBlur stdDeviation="3" result="coloredBlur"/>
                                <feMerge>
                                    <feMergeNode in="coloredBlur"/>
                                    <feMergeNode in="SourceGraphic"/>
                                </feMerge>
                            </filter>
                        </defs>

                        <!-- Background Subtle Horizontal Grid Lines -->
                        <line x1="15" y1="20" x2="485" y2="20" stroke="#27272a" stroke-width="1" stroke-dasharray="4 4" />
                        <line x1="15" y1="65" x2="485" y2="65" stroke="#27272a" stroke-width="1" stroke-dasharray="4 4" />
                        <line x1="15" y1="110" x2="485" y2="110" stroke="#27272a" stroke-width="1" stroke-dasharray="4 4" />

                        <!-- Area Fill Under Path -->
                        <path d="{{ $svgAreaPath }}" fill="url(#chartGradient)"/>

                        <!-- Stroke Line Curve -->
                        @php
                            $linePath = "M " . implode(' L ', array_map(fn($p) => "{$p['x']},{$p['y']}", $chartPoints));
                        @endphp
                        <path d="{{ $linePath }}" fill="none" stroke="url(#strokeGradient)" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" filter="url(#glow)"/>

                        <!-- Interactive Nodes / Points -->
                        @foreach($chartPoints as $pt)
                            <g class="group cursor-pointer">
                                <!-- Hover Target Halo -->
                                <circle cx="{{ $pt['x'] }}" cy="{{ $pt['y'] }}" r="9" fill="#38bdf8" fill-opacity="0.1" class="opacity-0 group-hover:opacity-100 transition-opacity" />
                                <circle cx="{{ $pt['x'] }}" cy="{{ $pt['y'] }}" r="4" fill="#09090b" stroke="#38bdf8" stroke-width="2.5" class="transition-transform group-hover:scale-125" />
                            </g>
                        @endforeach
                    </svg>
                </div>

                <!-- X-Axis Labels Row -->
                <div class="flex items-center justify-between pt-3 border-t border-zinc-800/80 text-[11px] font-mono text-zinc-500">
                    @foreach($recentDays as $day)
                        <div class="text-center">
                            <span class="block text-zinc-300 font-semibold">{{ $day['label'] }}</span>
                            <span class="text-[9px] text-zinc-500">{{ $day['full_date'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Device Breakdown Mini Bar -->
            <div class="pt-2 border-t border-zinc-800/60 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <span class="text-xs text-zinc-400 font-medium">Distribusi Perangkat:</span>
                
                <div class="flex items-center gap-4 text-xs font-mono">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-sky-400"></span>
                        <span class="text-zinc-300">Mobile ({{ $devices['mobile']['percentage'] }}%)</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-indigo-400"></span>
                        <span class="text-zinc-300">Desktop ({{ $devices['desktop']['percentage'] }}%)</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span>
                        <span class="text-zinc-300">Tablet ({{ $devices['tablet']['percentage'] }}%)</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bento Right (1 Col): Top Performing Links Leaderboard -->
        <div class="bg-zinc-900/70 border border-zinc-800 rounded-3xl p-6 sm:p-7 space-y-5 shadow-xl flex flex-col justify-between">
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-bold text-white flex items-center gap-2">
                            <i data-lucide="award" class="w-4 h-4 text-amber-400"></i>
                            <span>Tautan Terpopuler</span>
                        </h3>
                        <p class="text-[11px] text-zinc-400">Tautan dengan jumlah klik terbanyak.</p>
                    </div>
                    <a href="{{ route('admin.links.index') }}" class="text-xs text-sky-400 hover:underline">Kelola &rarr;</a>
                </div>

                <div class="space-y-3 pt-1">
                    @forelse($topLinks as $idx => $link)
                        <div class="p-3 rounded-2xl bg-zinc-800/40 border border-zinc-800 hover:border-zinc-700/80 transition-all space-y-2">
                            <div class="flex items-center justify-between gap-2 text-xs">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="w-5 h-5 rounded-lg {{ $idx === 0 ? 'bg-amber-500/20 text-amber-400 border border-amber-500/30 font-black' : 'bg-zinc-800 text-zinc-400' }} flex items-center justify-center text-[10px] flex-shrink-0 font-mono">
                                        {{ $idx + 1 }}
                                    </span>
                                    <span class="font-bold text-zinc-200 truncate">{{ $link->title }}</span>
                                </div>
                                <span class="font-mono text-emerald-400 font-bold text-xs flex-shrink-0">{{ number_format($link->total_clicks) }} klik</span>
                            </div>

                            <!-- Click Share Progress Bar -->
                            <div class="w-full bg-zinc-800 rounded-full h-1.5 overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-sky-400 to-emerald-400 rounded-full" style="width: {{ $link->percentage }}%;"></div>
                            </div>
                        </div>
                    @empty
                        <div class="py-10 text-center space-y-2">
                            <div class="w-10 h-10 rounded-2xl bg-zinc-800 text-zinc-500 flex items-center justify-center mx-auto">
                                <i data-lucide="link" class="w-5 h-5"></i>
                            </div>
                            <p class="text-xs text-zinc-500">Belum ada aktivitas klik tercatat.</p>
                            <a href="{{ route('admin.links.index') }}" class="text-xs font-bold text-sky-400 hover:underline inline-block">Mulai Tambah Tautan &rarr;</a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Bottom Quick Link -->
            <div class="pt-4 border-t border-zinc-800/80">
                <a href="{{ route('admin.links.index') }}" class="w-full py-2.5 rounded-xl bg-zinc-800/80 hover:bg-zinc-700 text-white text-xs font-bold transition-colors inline-flex items-center justify-center gap-2 border border-zinc-700">
                    <i data-lucide="list" class="w-4 h-4 text-sky-400"></i>
                    <span>Buka Manajer Tautan ({{ $activeLinksCount }} Aktif)</span>
                </a>
            </div>
        </div>

    </div>

    <!-- ========================================================================= -->
    <!-- 4.5. CURRICULUM VITAE (CV) & RESUME SHOWCASE WITH LIVE PREVIEW            -->
    <!-- ========================================================================= -->
    <div class="rounded-3xl bg-gradient-to-br from-zinc-900/90 via-zinc-900/60 to-zinc-950 border border-zinc-800 p-6 sm:p-7 shadow-2xl relative overflow-hidden">
        <div class="absolute -top-16 -right-16 w-80 h-80 bg-sky-500/5 rounded-full blur-3xl pointer-events-none"></div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <!-- Left Info & Control Column (lg:col-span-6) -->
            <div class="lg:col-span-6 space-y-5">
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-mono font-bold uppercase tracking-wider text-sky-400 bg-sky-500/10 px-2.5 py-0.5 rounded-full border border-sky-500/20">
                            Fitur Karir Profesional
                        </span>
                        @if($profile->enable_cv)
                            <span class="text-[11px] font-mono font-bold px-2 py-0.5 rounded-full bg-emerald-500/15 text-emerald-400 border border-emerald-500/30 flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                <span>CV Aktif (Publik)</span>
                            </span>
                        @else
                            <span class="text-[11px] font-mono font-bold px-2 py-0.5 rounded-full bg-zinc-800 text-zinc-400 border border-zinc-700">
                                CV Nonaktif (Tersembunyi)
                            </span>
                        @endif
                    </div>

                    <h3 class="text-xl font-black text-white tracking-tight flex items-center gap-2">
                        <i data-lucide="file-badge" class="w-5 h-5 text-sky-400"></i>
                        <span>Curriculum Vitae (CV) Digital</span>
                    </h3>

                    <p class="text-xs text-zinc-400 leading-relaxed">
                        Tampilkan riwayat karir, pencapaian, dan keahlian teknis Anda dalam format resume berstandar industri. Recruiter dapat langsung mencetak atau menyimpannya sebagai file PDF resmi.
                    </p>
                </div>

                <!-- Stats Metric Chips -->
                <div class="grid grid-cols-3 gap-3">
                    <div class="p-3 rounded-2xl bg-zinc-950/60 border border-zinc-800/80 text-center">
                        <span class="block text-lg font-black text-white font-mono">{{ count($profile->cv_experiences ?? []) }}</span>
                        <span class="text-[10px] text-zinc-400 font-medium">Pengalaman</span>
                    </div>
                    <div class="p-3 rounded-2xl bg-zinc-950/60 border border-zinc-800/80 text-center">
                        <span class="block text-lg font-black text-white font-mono">{{ count($profile->cv_educations ?? []) }}</span>
                        <span class="text-[10px] text-zinc-400 font-medium">Pendidikan</span>
                    </div>
                    <div class="p-3 rounded-2xl bg-zinc-950/60 border border-zinc-800/80 text-center">
                        <span class="block text-lg font-black text-white font-mono">{{ count($profile->cv_skills ?? []) }}</span>
                        <span class="text-[10px] text-zinc-400 font-medium">Kategori Skill</span>
                    </div>
                </div>

                <!-- 1-Click Toggle Form & Actions -->
                <div class="flex items-center flex-wrap gap-3 pt-1">
                    <form action="{{ route('admin.cv.toggle') }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2 shadow-md {{ $profile->enable_cv ? 'bg-zinc-800 hover:bg-zinc-700 text-zinc-300 hover:text-white border border-zinc-700' : 'bg-emerald-500 hover:bg-emerald-400 text-white shadow-emerald-500/20' }}">
                            <i data-lucide="{{ $profile->enable_cv ? 'eye-off' : 'eye' }}" class="w-4 h-4"></i>
                            <span>{{ $profile->enable_cv ? 'Nonaktifkan CV' : 'Aktifkan CV Sekarang' }}</span>
                        </button>
                    </form>

                    <a href="{{ route('admin.cv.index') }}" 
                       class="px-4 py-2.5 rounded-xl text-xs font-bold bg-sky-500/10 hover:bg-sky-500/20 text-sky-300 border border-sky-500/30 transition-all flex items-center gap-1.5 shadow-sm">
                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                        <span>Edit & Atur Data CV</span>
                    </a>

                    <a href="{{ route('public.cv', $profile->clean_handle) }}" 
                       target="_blank" 
                       class="px-4 py-2.5 rounded-xl text-xs font-bold bg-white/5 hover:bg-white/10 text-white border border-white/10 transition-all flex items-center gap-1.5 shadow-sm">
                        <i data-lucide="external-link" class="w-4 h-4 text-sky-400"></i>
                        <span>Buka Halaman CV</span>
                    </a>
                </div>
            </div>

            <!-- Right: Live Result Preview Card ("Hasil Pada CV Itu Sendiri") (lg:col-span-6) -->
            <div class="lg:col-span-6 bg-zinc-950/80 border border-zinc-800 rounded-2xl p-5 shadow-inner space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-zinc-800/80">
                    <div class="flex items-center gap-2">
                        <div class="w-2.5 h-2.5 rounded-full {{ $profile->enable_cv ? 'bg-emerald-400 animate-pulse' : 'bg-zinc-600' }}"></div>
                        <span class="text-xs font-bold text-zinc-200">Hasil Pratinjau CV (Live View)</span>
                    </div>
                    <span class="text-[10px] font-mono text-zinc-500 uppercase tracking-wider">
                        /@ {{ $profile->clean_handle }}/cv
                    </span>
                </div>

                <!-- Mini Resume Card Output -->
                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <img src="{{ $profile->avatar_url ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100' }}" 
                             alt="{{ $profile->display_name }}" 
                             class="w-12 h-12 rounded-xl object-cover border border-white/10 flex-shrink-0">
                        <div class="min-w-0">
                            <h4 class="text-sm font-bold text-white flex items-center gap-1.5 truncate">
                                <span>{{ $profile->display_name }}</span>
                                @if($profile->is_verified)
                                    <svg class="w-3.5 h-3.5 text-sky-400 fill-current inline flex-shrink-0" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                                @endif
                            </h4>
                            <p class="text-xs font-semibold text-sky-400 truncate">
                                {{ $profile->cv_headline ?: $profile->tagline ?: 'Professional Engineer' }}
                            </p>
                            @if($profile->location)
                                <p class="text-[11px] text-zinc-400 flex items-center gap-1 mt-0.5">
                                    <i data-lucide="map-pin" class="w-3 h-3 text-rose-400"></i>
                                    <span>{{ $profile->location }}</span>
                                </p>
                            @endif
                        </div>
                    </div>

                    @if($profile->cv_summary || $profile->bio)
                        <p class="text-xs text-zinc-300/90 line-clamp-2 leading-relaxed bg-white/5 p-2.5 rounded-xl border border-white/5 font-normal">
                            {{ $profile->cv_summary ?: $profile->bio }}
                        </p>
                    @endif

                    @php
                        $firstExp = !empty($profile->cv_experiences) ? $profile->cv_experiences[0] : null;
                    @endphp
                    @if($firstExp)
                        <div class="pt-1">
                            <span class="text-[10px] font-mono font-bold uppercase text-zinc-400 block mb-1">Posisi Terbaru:</span>
                            <div class="flex items-center justify-between text-xs p-2 rounded-xl bg-zinc-900 border border-zinc-800">
                                <div class="min-w-0">
                                    <strong class="text-white block truncate">{{ $firstExp['role'] ?? 'Role' }}</strong>
                                    <span class="text-zinc-400 text-[11px] truncate block">{{ $firstExp['company'] ?? 'Company' }}</span>
                                </div>
                                <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-sky-500/10 text-sky-300 border border-sky-500/20 whitespace-nowrap ml-2">
                                    {{ $firstExp['period'] ?? '' }}
                                </span>
                            </div>
                        </div>
                    @endif

                    @if(!empty($profile->cv_skills))
                        <div class="pt-1">
                            <span class="text-[10px] font-mono font-bold uppercase text-zinc-400 block mb-1.5">Cuplikan Keahlian:</span>
                            <div class="flex flex-wrap gap-1">
                                @php
                                    $allSkills = [];
                                    foreach ($profile->cv_skills as $c => $sList) {
                                        $allSkills = array_merge($allSkills, (array)$sList);
                                    }
                                    $previewSkills = array_slice($allSkills, 0, 6);
                                @endphp
                                @foreach($previewSkills as $sk)
                                    <span class="text-[10px] px-2 py-0.5 rounded-md bg-white/5 text-zinc-300 border border-white/10 font-mono">
                                        {{ $sk }}
                                    </span>
                                @endforeach
                                @if(count($allSkills) > 6)
                                    <span class="text-[10px] px-1.5 py-0.5 text-zinc-500 font-mono">+{{ count($allSkills) - 6 }} lainnya</span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- 5. SECONDARY BENTO ROW: QUICK ACTIONS & PLATFORM STATUS                   -->
    <!-- ========================================================================= -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Bento Card: AI Concierge Fast Setup -->
        <div class="bg-gradient-to-br from-purple-950/20 via-zinc-900/60 to-zinc-900 border border-purple-500/20 rounded-3xl p-6 space-y-4 shadow-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-purple-500/15 border border-purple-500/30 text-purple-400 flex items-center justify-center">
                        <i data-lucide="sparkles" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-white">Asisten AI Cerdas</h4>
                        <span class="text-[10px] text-zinc-400">Latih asisten pribadi Anda</span>
                    </div>
                </div>
                <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-purple-500/20 text-purple-300 font-bold">
                    {{ $aiKnowledgeCount }} Fakta
                </span>
            </div>

            <p class="text-xs text-zinc-400 leading-relaxed">
                Asisten AI <strong>{{ $profile->ai_assistant_name }}</strong> siap menjawab pertanyaan pengunjung tentang proyek, kontak WhatsApp, dan portofolio Anda.
            </p>

            <div class="pt-2">
                <a href="{{ route('admin.ai-knowledge.index') }}" class="w-full py-2 rounded-xl bg-purple-600/20 hover:bg-purple-600/30 text-purple-300 text-xs font-bold border border-purple-500/30 inline-flex items-center justify-center gap-2 transition-colors">
                    <i data-lucide="brain-circuit" class="w-3.5 h-3.5"></i>
                    <span>Buka Otak AI & Tambah Fakta</span>
                </a>
            </div>
        </div>

        <!-- Bento Card: Tema & Tampilan Visual -->
        <div class="bg-zinc-900/70 border border-zinc-800 rounded-3xl p-6 space-y-4 shadow-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-indigo-500/15 border border-indigo-500/30 text-indigo-400 flex items-center justify-center">
                        <i data-lucide="palette" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-white">Visual & Tema</h4>
                        <span class="text-[10px] text-zinc-400">Sesuaikan estetika profil</span>
                    </div>
                </div>
                <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-zinc-800 text-zinc-300 border border-zinc-700">
                    {{ $profile->theme?->name ?: 'Dark Luxury' }}
                </span>
            </div>

            <p class="text-xs text-zinc-400 leading-relaxed">
                Pilih dari 6 tema estetis bawaan atau unggah gambar latar belakang kustom Anda sendiri untuk mencerminkan personal branding Anda.
            </p>

            <div class="pt-2">
                <a href="{{ route('admin.themes.index') }}" class="w-full py-2 rounded-xl bg-zinc-800 hover:bg-zinc-700 text-white text-xs font-bold border border-zinc-700 inline-flex items-center justify-center gap-2 transition-colors">
                    <i data-lucide="paintbrush" class="w-3.5 h-3.5 text-sky-400"></i>
                    <span>Kustomisasi Tampilan</span>
                </a>
            </div>
        </div>

        <!-- Bento Card: Keamanan & vCard Download -->
        <div class="bg-zinc-900/70 border border-zinc-800 rounded-3xl p-6 space-y-4 shadow-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-400 flex items-center justify-center">
                        <i data-lucide="shield-check" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-white">Proteksi Akun</h4>
                        <span class="text-[10px] text-zinc-400">Keamanan & Ekspor Data</span>
                    </div>
                </div>
                @if(auth()->user()->hasTwoFactorEnabled())
                    <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-300 font-bold border border-emerald-500/30">2FA Aktif</span>
                @else
                    <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-amber-500/20 text-amber-300 font-bold border border-amber-500/30">2FA Off</span>
                @endif
            </div>

            <p class="text-xs text-zinc-400 leading-relaxed">
                Fitur vCard kontak otomatis aktif di profil. Pastikan 2FA Authenticator selalu terpasang untuk menjaga data analitik dan link Anda.
            </p>

            <div class="pt-2 flex items-center gap-2">
                <a href="{{ route('admin.security.2fa.index') }}" class="flex-1 py-2 rounded-xl bg-zinc-800 hover:bg-zinc-700 text-white text-xs font-bold border border-zinc-700 inline-flex items-center justify-center gap-1.5 transition-colors">
                    <i data-lucide="lock" class="w-3.5 h-3.5 text-emerald-400"></i>
                    <span>Keamanan 2FA</span>
                </a>
                <a href="{{ route('admin.export.json') }}" class="px-3 py-2 rounded-xl bg-zinc-800 hover:bg-zinc-700 text-zinc-300 hover:text-white text-xs font-bold border border-zinc-700 transition-colors" title="Cadangkan Data (JSON)">
                    <i data-lucide="download" class="w-3.5 h-3.5"></i>
                </a>
            </div>
        </div>

    </div>

</div>

<!-- Simple Toast Notification Script -->
<script>
    function copyPublicBioUrl(url, btn) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(url).then(() => {
                const originalHtml = btn.innerHTML;
                btn.innerHTML = `<i data-lucide="check" class="w-3.5 h-3.5 text-emerald-400"></i><span class="text-emerald-400 font-bold">Disalin!</span>`;
                if (window.lucide) lucide.createIcons();
                setTimeout(() => {
                    btn.innerHTML = originalHtml;
                    if (window.lucide) lucide.createIcons();
                }, 2000);
            });
        }
    }
</script>
@endsection
