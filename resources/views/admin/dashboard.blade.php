@extends('layouts.admin')

@section('title', 'Ringkasan Dashboard')

@section('content')
<div class="space-y-6">

    <!-- Welcome Card -->
    <div class="bg-gradient-to-r from-sky-900/30 via-indigo-900/20 to-zinc-900 border border-zinc-800 rounded-2xl p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-white tracking-tight">Selamat Datang, {{ $profile->display_name }}! 👋</h2>
            <p class="text-xs text-zinc-400 mt-1">Halaman bio publik Anda aktif di URL <span class="text-sky-400 font-mono">/@ {{ $profile->clean_handle }}</span></p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.links.index') }}" class="px-4 py-2 rounded-xl bg-sky-500 hover:bg-sky-400 text-white text-xs font-bold transition-all shadow-lg shadow-sky-500/20 inline-flex items-center gap-1.5">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                <span>Tambah Tautan</span>
            </a>
        </div>
    </div>

    <!-- 4 Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-zinc-900/60 border border-zinc-800 rounded-2xl p-4">
            <div class="flex items-center justify-between text-zinc-400 text-xs mb-2">
                <span>Total Tayangan</span>
                <i data-lucide="eye" class="w-4 h-4 text-sky-400"></i>
            </div>
            <div class="text-2xl font-black text-white font-mono">{{ number_format($totalViews) }}</div>
            <div class="text-[11px] text-zinc-500 mt-1">Kunjungan halaman profil</div>
        </div>

        <div class="bg-zinc-900/60 border border-zinc-800 rounded-2xl p-4">
            <div class="flex items-center justify-between text-zinc-400 text-xs mb-2">
                <span>Total Klik Tautan</span>
                <i data-lucide="mouse-pointer-click" class="w-4 h-4 text-emerald-400"></i>
            </div>
            <div class="text-2xl font-black text-white font-mono">{{ number_format($totalClicks) }}</div>
            <div class="text-[11px] text-zinc-500 mt-1">Aksi klik tombol link</div>
        </div>

        <div class="bg-zinc-900/60 border border-zinc-800 rounded-2xl p-4">
            <div class="flex items-center justify-between text-zinc-400 text-xs mb-2">
                <span>Rasio Klik (CTR)</span>
                <i data-lucide="trending-up" class="w-4 h-4 text-amber-400"></i>
            </div>
            <div class="text-2xl font-black text-white font-mono">{{ $clickRate }}%</div>
            <div class="text-[11px] text-zinc-500 mt-1">Persentase klik per view</div>
        </div>

        <div class="bg-zinc-900/60 border border-zinc-800 rounded-2xl p-4">
            <div class="flex items-center justify-between text-zinc-400 text-xs mb-2">
                <span>Tautan Aktif</span>
                <i data-lucide="link" class="w-4 h-4 text-purple-400"></i>
            </div>
            <div class="text-2xl font-black text-white font-mono">{{ $activeLinksCount }}</div>
            <div class="text-[11px] text-zinc-500 mt-1">Tautan tampil di profil</div>
        </div>
    </div>

    <!-- Charts & Leaderboard Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- 7-Day Traffic Trend -->
        <div class="lg:col-span-2 bg-zinc-900/60 border border-zinc-800 rounded-2xl p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-white flex items-center gap-2">
                    <i data-lucide="calendar" class="w-4 h-4 text-sky-400"></i>
                    <span>Aktivitas Kunjungan (7 Hari Terakhir)</span>
                </h3>
            </div>
            
            <div class="h-44 flex items-end justify-between gap-2 pt-6 pb-2 px-2 border-b border-zinc-800">
                @php
                    $maxVal = $recentDays->max('views') ?: 1;
                @endphp
                @foreach($recentDays as $day)
                    @php
                        $heightPercent = max(8, round(($day['views'] / $maxVal) * 100));
                    @endphp
                    <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end group">
                        <span class="text-[10px] font-mono text-zinc-400 opacity-0 group-hover:opacity-100 transition-opacity">{{ $day['views'] }}</span>
                        <div class="w-full bg-sky-500/30 group-hover:bg-sky-400 border border-sky-400/40 rounded-t-lg transition-all" style="height: {{ $heightPercent }}%;"></div>
                        <span class="text-[10px] text-zinc-500 font-mono">{{ $day['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Top Performing Links -->
        <div class="bg-zinc-900/60 border border-zinc-800 rounded-2xl p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-white flex items-center gap-2">
                    <i data-lucide="award" class="w-4 h-4 text-amber-400"></i>
                    <span>Tautan Terpopuler</span>
                </h3>
            </div>

            <div class="space-y-3">
                @forelse($topLinks as $idx => $tLink)
                    <div class="flex items-center justify-between p-2.5 rounded-xl bg-zinc-800/40 border border-zinc-800 text-xs">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <span class="w-5 h-5 rounded-full bg-zinc-800 text-zinc-400 flex items-center justify-center font-bold text-[10px] flex-shrink-0">
                                {{ $idx + 1 }}
                            </span>
                            <span class="font-semibold text-zinc-200 truncate">{{ $tLink->title }}</span>
                        </div>
                        <span class="font-mono text-emerald-400 font-bold ml-2">{{ $tLink->total_clicks }} klik</span>
                    </div>
                @empty
                    <p class="text-xs text-zinc-500 py-6 text-center">Belum ada data klik.</p>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
