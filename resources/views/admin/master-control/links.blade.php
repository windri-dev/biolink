@extends('layouts.admin')

@section('title', 'Audit Seluruh Tautan Platform')

@section('content')
<div class="space-y-6">

    <!-- Header & Breadcrumbs -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('admin.master.index') }}" class="text-[11px] font-mono text-zinc-400 hover:text-white">&larr; Kembali ke Master Kontrol</a>
                <span class="text-zinc-600 font-mono">•</span>
                <span class="text-[10px] font-mono uppercase text-amber-400 font-bold">Global Link Auditor</span>
            </div>
            <h2 class="text-xl font-black text-white tracking-tight">Audit Seluruh Tautan Pengguna</h2>
            <p class="text-xs text-zinc-400">Pantau seluruh link dan URL tujuan yang dibuat di platform untuk mendeteksi domain mencurigakan, spam, atau phishing.</p>
        </div>

        <div>
            <a href="{{ route('admin.master.index') }}" class="px-4 py-2 rounded-xl bg-zinc-800 hover:bg-zinc-700 text-zinc-300 hover:text-white text-xs font-semibold border border-zinc-700 transition-colors inline-flex items-center gap-1.5">
                <i data-lucide="users" class="w-4 h-4 text-sky-400"></i>
                <span>Kelola Pengguna</span>
            </a>
        </div>
    </div>

    <!-- Search Controls -->
    <div class="bg-zinc-900/60 border border-zinc-800 rounded-2xl p-3">
        <form action="{{ route('admin.master.links') }}" method="GET" class="flex items-center gap-2">
            <div class="relative flex-grow">
                <span class="absolute left-3 top-2.5 text-zinc-500">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </span>
                <input type="text" 
                       name="search" 
                       value="{{ $search }}" 
                       placeholder="Cari tautan (judul, URL tujuan, domain seperti bit.ly / t.me, atau @handle)..." 
                       class="w-full bg-zinc-800/80 border border-zinc-700 rounded-xl pl-9 pr-3 py-2 text-xs text-white placeholder-zinc-500 focus:outline-none focus:border-sky-400">
            </div>

            <button type="submit" class="px-4 py-2 rounded-xl bg-zinc-800 hover:bg-zinc-700 text-xs font-bold text-white border border-zinc-700">
                Filter
            </button>
            @if($search)
                <a href="{{ route('admin.master.links') }}" class="px-3 py-2 rounded-xl bg-zinc-800/50 hover:bg-zinc-800 text-xs text-zinc-400 hover:text-white" title="Reset">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Links Table -->
    <div class="bg-zinc-900/80 border border-zinc-800 rounded-3xl overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-zinc-800 bg-zinc-950/60 text-zinc-400 font-semibold uppercase text-[10px] tracking-wider">
                        <th class="p-4 sm:p-5">Judul Tautan</th>
                        <th class="p-4 sm:p-5">URL Tujuan (Destination)</th>
                        <th class="p-4 sm:p-5">Pemilik Profil</th>
                        <th class="p-4 sm:p-5 text-center">Klik</th>
                        <th class="p-4 sm:p-5 text-center">Status</th>
                        <th class="p-4 sm:p-5 text-right">Tindakan Super Admin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800/60 text-zinc-300">
                    @forelse($links as $l)
                        <tr class="hover:bg-zinc-800/30 transition-colors {{ !$l->is_active ? 'bg-zinc-950/40 opacity-75' : '' }}">
                            <!-- Title & Subtitle -->
                            <td class="p-4 sm:p-5 align-top">
                                <div class="font-bold text-white text-sm">{{ $l->title }}</div>
                                @if($l->subtitle)
                                    <div class="text-[11px] text-zinc-400">{{ $l->subtitle }}</div>
                                @endif
                                <div class="text-[9px] font-mono text-zinc-500 mt-1">Dibuat: {{ $l->created_at?->format('d M Y H:i') }}</div>
                            </td>

                            <!-- Destination URL -->
                            <td class="p-4 sm:p-5 align-top max-w-xs sm:max-w-md">
                                <a href="{{ $l->url }}" target="_blank" class="text-xs font-mono text-sky-400 hover:underline break-all inline-flex items-center gap-1">
                                    <span>{{ $l->url }}</span>
                                    <i data-lucide="external-link" class="w-3 h-3 flex-shrink-0 text-zinc-500"></i>
                                </a>
                                @php
                                    $domain = parse_url($l->url, PHP_URL_HOST);
                                @endphp
                                @if($domain)
                                    <div class="text-[10px] font-mono text-zinc-500 mt-0.5">
                                        Host: <span class="text-zinc-300">{{ $domain }}</span>
                                    </div>
                                @endif
                            </td>

                            <!-- Owner -->
                            <td class="p-4 sm:p-5 align-top">
                                <div class="space-y-0.5">
                                    <div class="font-semibold text-white">{{ $l->profile->user->name ?? 'User' }}</div>
                                    <a href="{{ route('public.bio.at', $l->profile->handle ?? 'unknown') }}" target="_blank" class="text-[11px] font-mono text-sky-400 hover:underline">
                                        {{ '@' . ($l->profile->handle ?? 'unknown') }}
                                    </a>
                                </div>
                            </td>

                            <!-- Click Count -->
                            <td class="p-4 sm:p-5 align-top text-center font-mono">
                                <span class="font-bold text-indigo-400">{{ number_format($l->click_count) }}</span>
                            </td>

                            <!-- Status -->
                            <td class="p-4 sm:p-5 align-top text-center">
                                @if($l->is_active)
                                    <span class="text-[10px] font-mono font-bold px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                                        AKTIF
                                    </span>
                                @else
                                    <span class="text-[10px] font-mono font-bold px-2 py-0.5 rounded bg-zinc-800 text-zinc-400 border border-zinc-700">
                                        NONAKTIF
                                    </span>
                                @endif
                            </td>

                            <!-- Action Buttons -->
                            <td class="p-4 sm:p-5 align-top text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <!-- Toggle Link -->
                                    <form action="{{ route('admin.master.link.toggle', $l->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="px-2.5 py-1.5 rounded-lg {{ $l->is_active ? 'bg-zinc-800 hover:bg-zinc-700 text-zinc-300' : 'bg-emerald-500/20 text-emerald-300 hover:bg-emerald-500/30' }} text-[11px] font-semibold border border-zinc-700 transition-colors">
                                            {{ $l->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>

                                    <!-- Delete Link -->
                                    <form action="{{ route('admin.master.link.destroy', $l->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus permanen tautan ini dari profil pengguna?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg bg-zinc-800 hover:bg-rose-500/20 text-zinc-400 hover:text-rose-400 transition-colors" title="Hapus Tautan">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-zinc-500">
                                <i data-lucide="link-2-off" class="w-8 h-8 mx-auto mb-2 opacity-40"></i>
                                <p class="text-xs">Tidak ditemukan tautan dengan kriteria pencarian.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($links->hasPages())
            <div class="p-4 border-t border-zinc-800">
                {{ $links->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
