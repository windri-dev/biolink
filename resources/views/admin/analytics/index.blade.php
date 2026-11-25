@extends('layouts.admin')

@section('title', 'Statistik & Log Kunjungan')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-bold text-white tracking-tight">Statistik & Log Aktivitas</h2>
            <p class="text-xs text-zinc-400">Pantau metrik kunjungan profil, performa tautan, dan interaksi pengunjung dengan AI Anda.</p>
        </div>
    </div>

    <!-- 3 Core Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-zinc-900/60 border border-zinc-800 rounded-2xl p-4">
            <span class="text-xs text-zinc-400">Total Kunjungan Profil</span>
            <div class="text-2xl font-black text-white font-mono mt-1">{{ number_format($totalViews) }}</div>
        </div>

        <div class="bg-zinc-900/60 border border-zinc-800 rounded-2xl p-4">
            <span class="text-xs text-zinc-400">Total Klik Tautan</span>
            <div class="text-2xl font-black text-emerald-400 font-mono mt-1">{{ number_format($totalClicks) }}</div>
        </div>

        <div class="bg-zinc-900/60 border border-zinc-800 rounded-2xl p-4">
            <span class="text-xs text-zinc-400">Percakapan dengan AI</span>
            <div class="text-2xl font-black text-sky-400 font-mono mt-1">{{ number_format($totalAiChats) }}</div>
        </div>
    </div>

    <!-- Traffic Trend Chart (14 Days) -->
    <div class="bg-zinc-900/60 border border-zinc-800 rounded-2xl p-5">
        <h3 class="text-sm font-bold text-white mb-4 flex items-center gap-2">
            <i data-lucide="line-chart" class="w-4 h-4 text-sky-400"></i>
            <span>Tren Tayangan Harian (14 Hari Terakhir)</span>
        </h3>

        <div class="h-44 flex items-end justify-between gap-1.5 pt-6 pb-2 px-2 border-b border-zinc-800">
            @php
                $maxVal = $trafficTrend->max('views') ?: 1;
            @endphp
            @foreach($trafficTrend as $t)
                @php
                    $hPercent = max(6, round(($t['views'] / $maxVal) * 100));
                @endphp
                <div class="flex-1 flex flex-col items-center gap-1.5 h-full justify-end group">
                    <span class="text-[9px] font-mono text-zinc-400 opacity-0 group-hover:opacity-100 transition-opacity">{{ $t['views'] }}</span>
                    <div class="w-full bg-indigo-500/30 group-hover:bg-indigo-400 border border-indigo-400/40 rounded-t transition-all" style="height: {{ $hPercent }}%;"></div>
                    <span class="text-[9px] text-zinc-500 font-mono rotate-45 sm:rotate-0 mt-1">{{ $t['label'] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Performa Tiap Tautan & Perangkat Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Links Performance Table -->
        <div class="lg:col-span-2 bg-zinc-900/60 border border-zinc-800 rounded-2xl p-5">
            <h3 class="text-sm font-bold text-white mb-3 flex items-center gap-2">
                <i data-lucide="mouse-pointer" class="w-4 h-4 text-emerald-400"></i>
                <span>Rincian Klik per Tautan</span>
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-zinc-800 text-zinc-400 text-[11px] font-mono uppercase">
                            <th class="py-2 px-3">Tautan</th>
                            <th class="py-2 px-3">Tipe</th>
                            <th class="py-2 px-3 text-right">Total Klik</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-800/60">
                        @forelse($linksStats as $lStat)
                            <tr class="hover:bg-zinc-800/20">
                                <td class="py-2.5 px-3 font-semibold text-zinc-200 truncate max-w-xs">{{ $lStat->title }}</td>
                                <td class="py-2.5 px-3 text-zinc-400 font-mono text-[11px]">{{ $lStat->type }}</td>
                                <td class="py-2.5 px-3 text-right font-mono font-bold text-emerald-400">{{ $lStat->total_clicks }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-6 text-center text-zinc-500">Belum ada tautan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Devices Share -->
        <div class="bg-zinc-900/60 border border-zinc-800 rounded-2xl p-5 space-y-4">
            <h3 class="text-sm font-bold text-white flex items-center gap-2">
                <i data-lucide="smartphone" class="w-4 h-4 text-purple-400"></i>
                <span>Distribusi Perangkat</span>
            </h3>

            <div class="space-y-3">
                @php
                    $devTotal = array_sum($devices) ?: 1;
                @endphp
                @foreach(['mobile' => 'Ponsel (Mobile)', 'desktop' => 'Komputer (Desktop)', 'tablet' => 'Tablet'] as $dKey => $dLabel)
                    @php
                        $dCount = $devices[$dKey] ?? 0;
                        $dPercent = round(($dCount / $devTotal) * 100);
                    @endphp
                    <div>
                        <div class="flex items-center justify-between text-xs mb-1">
                            <span class="text-zinc-300 font-medium">{{ $dLabel }}</span>
                            <span class="font-mono text-zinc-400">{{ $dCount }} ({{ $dPercent }}%)</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-zinc-800 overflow-hidden">
                            <div class="h-full bg-purple-500 rounded-full" style="width: {{ $dPercent }}%;"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <!-- AI Chat Interaction History Log -->
    <div class="bg-zinc-900/60 border border-zinc-800 rounded-2xl p-5">
        <h3 class="text-sm font-bold text-white mb-3 flex items-center gap-2">
            <i data-lucide="message-square" class="w-4 h-4 text-sky-400"></i>
            <span>Log Obrolan Asisten AI Terbaru (10 Terakhir)</span>
        </h3>

        <div class="space-y-3">
            @forelse($recentChats as $chat)
                <div class="p-3.5 rounded-xl bg-zinc-800/40 border border-zinc-800 text-xs space-y-1.5">
                    <div class="flex items-center justify-between text-[11px] text-zinc-400">
                        <span class="font-bold text-sky-400 flex items-center gap-1">
                            <i data-lucide="user" class="w-3 h-3"></i>
                            <span>Pengunjung ({{ $chat->ip_address ?? 'LAN' }})</span>
                        </span>
                        <span class="font-mono text-[10px] text-zinc-500">{{ $chat->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-zinc-200 font-medium bg-zinc-900/60 p-2 rounded-lg border border-zinc-800">
                        "{{ $chat->user_message }}"
                    </p>
                    <div class="text-[11px] text-zinc-400 pl-2 border-l-2 border-sky-500/40 mt-1">
                        <span class="text-zinc-500 font-mono text-[10px] uppercase">Aura:</span> {{ Str::limit($chat->ai_response, 180) }}
                    </div>
                </div>
            @empty
                <p class="text-xs text-zinc-500 py-6 text-center">Belum ada riwayat obrolan AI.</p>
            @endforelse
        </div>
    </div>

</div>
@endsection
