@extends('layouts.admin')

@section('title', 'Kelola Tautan Bio')

@section('content')
<div class="space-y-6">

    <!-- Top Action Bar -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-bold text-white tracking-tight">Kelola Tautan & Konten</h2>
            <p class="text-xs text-zinc-400">Atur kartu tautan, modular bento grid, pembatas kategori, dan video embed yang tampil di halaman profil Anda.</p>
        </div>
        <button onclick="openAddModal()" class="px-4 py-2 rounded-xl bg-sky-500 hover:bg-sky-400 text-white text-xs font-bold transition-all shadow-lg shadow-sky-500/20 inline-flex items-center gap-1.5">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Tambah Tautan Baru</span>
        </button>
    </div>

    <!-- Split-Screen Editor & Live Mockup Preview Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- Left Column: Links Management List (7 Cols) -->
        <div class="lg:col-span-7 space-y-3">
            <div class="flex items-center justify-between px-1 text-[11px] text-zinc-400 font-medium">
                <span class="flex items-center gap-1.5">
                    <i data-lucide="arrow-up-down" class="w-3.5 h-3.5 text-sky-400"></i>
                    <span>Tahan & geser icon grip atau klik panah untuk mengatur urutan tautan</span>
                </span>
                <span class="font-mono text-zinc-500">{{ count($links) + ($profile->hasConfiguredCv() ? 1 : 0) }} Item Konten</span>
            </div>

            <!-- Professional Curriculum Vitae (CV) Card -->
            @if($profile->hasConfiguredCv())
                <div id="cvCardInLinks" class="bg-gradient-to-r from-sky-500/10 via-zinc-900/90 to-zinc-900/90 border {{ $profile->enable_cv ? 'border-sky-500/40' : 'border-zinc-800' }} rounded-2xl p-3.5 sm:p-4 flex items-center justify-between gap-3 sm:gap-4 transition-all hover:border-sky-400/50 shadow-md relative overflow-hidden group">
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 {{ $profile->enable_cv ? 'bg-gradient-to-b from-sky-400 to-indigo-500' : 'bg-zinc-700' }}" id="cvCardBar"></div>

                    <div class="flex items-center gap-2.5 sm:gap-3.5 min-w-0 pl-1">
                        <!-- Icon Indicator -->
                        <div class="w-10 h-10 rounded-xl bg-sky-500/20 border border-sky-400/30 flex items-center justify-center flex-shrink-0 text-sky-400 shadow-sm">
                            <i data-lucide="file-badge" class="w-5 h-5"></i>
                        </div>

                        <div class="min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-bold text-sm text-white truncate">
                                    {{ $profile->cv_headline ?: 'Curriculum Vitae & Riwayat Karir' }}
                                </span>
                                <span class="text-[9px] font-mono font-bold uppercase px-2 py-0.5 rounded-full bg-sky-500/20 text-sky-300 border border-sky-400/30">
                                    RESUME CV
                                </span>
                                <span id="cvActiveBadge" class="text-[9px] font-mono font-bold uppercase px-2 py-0.5 rounded-full flex items-center gap-1 {{ $profile->enable_cv ? 'bg-emerald-500/15 text-emerald-400 border border-emerald-500/30' : 'bg-zinc-800 text-zinc-500 border border-zinc-700' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $profile->enable_cv ? 'bg-emerald-400 animate-pulse' : 'bg-zinc-500' }}" id="cvActiveDot"></span>
                                    <span id="cvActiveText">{{ $profile->enable_cv ? 'Aktif di Bio' : 'Nonaktif' }}</span>
                                </span>
                            </div>
                            <p class="text-xs text-zinc-400 truncate mt-0.5 font-mono text-[11px]">
                                {{ route('public.cv', $profile->clean_handle) }}
                            </p>
                        </div>
                    </div>

                    <!-- Action Controls -->
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <!-- Fast Toggle Aktif / Nonaktif -->
                        <button type="button" 
                                id="cvToggleBtn"
                                onclick="toggleCvStatus(this)" 
                                class="px-2.5 py-1.5 rounded-lg text-xs font-semibold border transition-all {{ $profile->enable_cv ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30 hover:bg-emerald-500/20' : 'bg-zinc-800 text-zinc-400 border-zinc-700 hover:bg-zinc-700' }}"
                                title="Klik untuk mengaktifkan / menonaktifkan tampilan CV di Bio">
                            {{ $profile->enable_cv ? 'Aktif' : 'Mati' }}
                        </button>

                        <!-- Edit Button (Direct to CV Builder) -->
                        <a href="{{ route('admin.cv.index') }}" 
                           class="p-2 rounded-lg bg-zinc-800 hover:bg-zinc-700 text-zinc-300 hover:text-white border border-zinc-700 transition-colors flex items-center gap-1 text-xs font-semibold"
                           title="Buka CV Builder untuk edit riwayat & keahlian">
                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                            <span class="hidden sm:inline">Kelola CV</span>
                        </a>

                        <!-- External Preview -->
                        <a href="{{ route('public.cv', $profile->clean_handle) }}" 
                           target="_blank" 
                           class="p-2 rounded-lg bg-zinc-800 hover:bg-zinc-700 text-zinc-300 hover:text-white border border-zinc-700 transition-colors"
                           title="Lihat Halaman CV Publik">
                            <i data-lucide="external-link" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>
            @endif

            <div class="space-y-3" id="linksContainer">
                @forelse($links as $link)
                    <div class="bg-zinc-900/70 border border-zinc-800 rounded-2xl p-3.5 sm:p-4 flex items-center justify-between gap-3 sm:gap-4 transition-all hover:border-zinc-700 select-none group" data-id="{{ $link->id }}">
                        <div class="flex items-center gap-2.5 sm:gap-3.5 min-w-0">
                            <!-- Drag Handle & Up/Down Arrows -->
                            <div class="flex items-center gap-1 flex-shrink-0">
                                <div class="drag-handle p-1.5 rounded-lg text-zinc-500 hover:text-white hover:bg-zinc-800 cursor-grab active:cursor-grabbing transition-colors" title="Geser (Drag & Drop) untuk mengatur urutan">
                                    <i data-lucide="grip-vertical" class="w-4 h-4"></i>
                                </div>
                                <div class="flex flex-col -space-y-0.5">
                                    <button type="button" onclick="moveLinkUp(this)" class="p-0.5 rounded text-zinc-500 hover:text-sky-400 hover:bg-zinc-800 transition-colors" title="Pindahkan ke atas">
                                        <i data-lucide="chevron-up" class="w-3.5 h-3.5"></i>
                                    </button>
                                    <button type="button" onclick="moveLinkDown(this)" class="p-0.5 rounded text-zinc-500 hover:text-sky-400 hover:bg-zinc-800 transition-colors" title="Pindahkan ke bawah">
                                        <i data-lucide="chevron-down" class="w-3.5 h-3.5"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Icon Indicator -->
                            <div class="w-10 h-10 rounded-xl bg-zinc-800 border border-zinc-700/80 flex items-center justify-center flex-shrink-0 text-zinc-300">
                            @if($link->type === 'header')
                                <svg class="w-5 h-5 text-purple-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M6 12h12"/><path d="M6 20V4"/><path d="M18 20V4"/>
                                </svg>
                            @elseif($link->type === 'embed_youtube')
                                <svg class="w-5 h-5 text-red-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17"/><polygon points="10 15 15 12 10 9 10 15"/>
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-sky-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
                                </svg>
                            @endif
                        </div>

                        <div class="min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-bold text-sm text-white truncate">{{ $link->title }}</span>
                                @if($link->card_size === 'half')
                                    <span class="text-[9px] font-bold uppercase px-1.5 py-0.2 rounded bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 font-mono">
                                        Bento 50%
                                    </span>
                                @endif
                                @if($link->badge_text)
                                    <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full bg-zinc-800 text-zinc-300 border border-zinc-700">
                                        {{ $link->badge_text }}
                                    </span>
                                @endif
                                @if(!$link->is_active)
                                    <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full bg-rose-500/10 text-rose-400 border border-rose-500/20">
                                        Nonaktif
                                    </span>
                                @endif
                            </div>
                            <p class="text-xs text-zinc-400 truncate mt-0.5 font-mono text-[11px]">
                                {{ $link->url ?: 'Pembatas Kategori (Header)' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 flex-shrink-0">
                        <span class="text-xs text-zinc-500 font-mono hidden sm:inline mr-2">
                            {{ $link->total_clicks }} klik
                        </span>

                        <!-- Active Toggle Button -->
                        <button onclick="toggleLinkActive({{ $link->id }}, this)" 
                                class="px-2.5 py-1.5 rounded-lg text-xs font-semibold border transition-colors {{ $link->is_active ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30 hover:bg-emerald-500/20' : 'bg-zinc-800 text-zinc-400 border-zinc-700 hover:bg-zinc-700' }}">
                            {{ $link->is_active ? 'Aktif' : 'Mati' }}
                        </button>

                        <!-- Edit Button -->
                        <button type="button"
                                data-link="{{ json_encode($link) }}"
                                onclick="openEditModal(this)"
                                class="p-2 rounded-lg bg-zinc-800 hover:bg-zinc-700 text-zinc-300 hover:text-white transition-colors" title="Edit Tautan">
                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                        </button>

                        <!-- Delete Form -->
                        <form action="{{ route('admin.links.destroy', $link->id) }}" method="POST" onsubmit="return confirm('Hapus tautan ini secara permanen?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 rounded-lg bg-zinc-800 hover:bg-rose-500/20 text-zinc-400 hover:text-rose-400 transition-colors" title="Hapus">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-zinc-900/40 border border-dashed border-zinc-800 rounded-2xl p-12 text-center text-zinc-500">
                    <i data-lucide="link" class="w-8 h-8 mx-auto mb-2 opacity-50"></i>
                    <p class="text-sm">Belum ada tautan. Klik tombol di atas untuk menambahkan!</p>
                </div>
            @endforelse
            </div>
        </div>

        <!-- Right Column: Live Mobile Mockup Preview (5 Cols - Sticky) -->
        <div class="lg:col-span-5 hidden lg:block sticky top-24">
            <div class="bg-zinc-900/60 border border-zinc-800 rounded-3xl p-5 flex flex-col items-center">
                
                <div class="w-full flex items-center justify-between pb-3 border-b border-zinc-800 mb-4 text-xs">
                    <span class="font-bold text-white flex items-center gap-1.5">
                        <i data-lucide="smartphone" class="w-4 h-4 text-sky-400"></i>
                        <span>Live Mobile Preview</span>
                    </span>
                    <button onclick="refreshPreview()" class="p-1.5 rounded-lg bg-zinc-800 hover:bg-zinc-700 text-zinc-400 hover:text-white transition-colors" title="Muat Ulang Preview">
                        <i data-lucide="refresh-cw" class="w-3.5 h-3.5"></i>
                    </button>
                </div>

                <!-- Realistic Smartphone Bezel Mockup -->
                <div class="relative w-[310px] h-[610px] rounded-[48px] bg-zinc-950 border-[10px] border-zinc-800 shadow-2xl overflow-hidden ring-1 ring-white/10">
                    
                    <!-- Dynamic Island / Speaker Pill -->
                    <div class="absolute top-2 left-1/2 -translate-x-1/2 w-24 h-5 bg-zinc-900 rounded-full z-20 flex items-center justify-center">
                        <div class="w-2.5 h-2.5 rounded-full bg-zinc-950 ml-auto mr-3 border border-zinc-800"></div>
                    </div>

                    <!-- Live Bio Page Iframe -->
                    <iframe id="previewIframe" 
                            src="{{ route('public.bio.at', $profile->clean_handle) }}" 
                            class="w-full h-full border-0 select-none" 
                            title="Bio Preview">
                    </iframe>
                </div>

                <div class="mt-3 flex items-center gap-2 text-[11px] text-zinc-500">
                    <span>Diperbarui otomatis secara realtime</span>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- Modal Tambah Tautan -->
<div id="addModal" class="fixed inset-0 bg-black/75 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-zinc-900 border border-zinc-800 rounded-2xl max-w-lg w-full p-6 space-y-4 shadow-2xl">
        <div class="flex items-center justify-between border-b border-zinc-800 pb-3">
            <h3 class="text-sm font-bold text-white">Tambah Tautan / Konten Baru</h3>
            <button onclick="closeAddModal()" class="text-zinc-400 hover:text-white"><i data-lucide="x" class="w-4 h-4"></i></button>
        </div>

        <form action="{{ route('admin.links.store') }}" method="POST" class="space-y-3.5 text-xs">
            @csrf
            <div>
                <label class="block text-zinc-300 font-semibold mb-1">Tipe Konten</label>
                <select name="type" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
                    <option value="link">Tautan Standar (Web/Katalog/Kontak)</option>
                    <option value="header">Pembatas / Judul Kategori (Header)</option>
                    <option value="embed_youtube">Embed Video YouTube</option>
                </select>
            </div>

            <div>
                <label class="block text-zinc-300 font-semibold mb-1">Judul Tautan *</label>
                <input type="text" name="title" required placeholder="Contoh: GitHub windri-dev" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
            </div>

            <div>
                <label class="block text-zinc-300 font-semibold mb-1">Subjudul / Deskripsi Singkat</label>
                <input type="text" name="subtitle" placeholder="Contoh: Kumpulan repositori open-source" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
            </div>

            <div>
                <label class="block text-zinc-300 font-semibold mb-1">URL Tujuan</label>
                <input type="url" name="url" placeholder="https://..." class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-zinc-300 font-semibold mb-1">Ukuran Kartu (Layout)</label>
                    <select name="card_size" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
                        <option value="full">Lebar Penuh (100%)</option>
                        <option value="half">Bento Grid (50% Berdampingan)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-zinc-300 font-semibold mb-1">Ikon Tautan</label>
                    <select name="icon" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
                        <option value="link">Tautan Umum (Link)</option>
                        <option value="github">GitHub</option>
                        <option value="shopping-bag">Toko / Belanja</option>
                        <option value="sparkles">Bintang / Kreatif</option>
                        <option value="send">Telegram / Kirim</option>
                        <option value="code">Kode / Developer</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-zinc-300 font-semibold mb-1">Teks Badge (Opsional)</label>
                    <input type="text" name="badge_text" placeholder="NEW, HOT, STAGING..." class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
                </div>
                <div>
                    <label class="block text-zinc-300 font-semibold mb-1">Warna Badge</label>
                    <select name="badge_color" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
                        <option value="emerald">Emerald (Hijau)</option>
                        <option value="sky">Sky (Biru)</option>
                        <option value="amber">Amber (Kuning/Emas)</option>
                        <option value="purple">Purple (Ungu)</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-4 pt-2">
                <label class="flex items-center gap-2 text-zinc-300 cursor-pointer">
                    <input type="checkbox" name="is_highlighted" value="1" class="rounded bg-zinc-800 border-zinc-700 text-sky-500">
                    <span>Animasi Sorotan (Glow/Pulse)</span>
                </label>
                <label class="flex items-center gap-2 text-zinc-300 cursor-pointer">
                    <input type="checkbox" name="open_in_new_tab" value="1" checked class="rounded bg-zinc-800 border-zinc-700 text-sky-500">
                    <span>Buka di Tab Baru</span>
                </label>
            </div>

            <div class="flex justify-end gap-2 pt-3 border-t border-zinc-800">
                <button type="button" onclick="closeAddModal()" class="px-4 py-2 rounded-xl bg-zinc-800 hover:bg-zinc-700 text-zinc-300">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-sky-500 hover:bg-sky-400 text-white font-bold">Simpan Tautan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Tautan -->
<div id="editModal" class="fixed inset-0 bg-black/75 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-zinc-900 border border-zinc-800 rounded-2xl max-w-lg w-full p-6 space-y-4 shadow-2xl">
        <div class="flex items-center justify-between border-b border-zinc-800 pb-3">
            <h3 class="text-sm font-bold text-white">Edit Tautan</h3>
            <button onclick="closeEditModal()" class="text-zinc-400 hover:text-white"><i data-lucide="x" class="w-4 h-4"></i></button>
        </div>

        <form id="editForm" method="POST" class="space-y-3.5 text-xs">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-zinc-300 font-semibold mb-1">Tipe Konten</label>
                <select id="editType" name="type" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
                    <option value="link">Tautan Standar</option>
                    <option value="header">Pembatas / Judul Kategori (Header)</option>
                    <option value="embed_youtube">Embed Video YouTube</option>
                </select>
            </div>

            <div>
                <label class="block text-zinc-300 font-semibold mb-1">Judul Tautan *</label>
                <input type="text" id="editTitle" name="title" required class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
            </div>

            <div>
                <label class="block text-zinc-300 font-semibold mb-1">Subjudul / Deskripsi Singkat</label>
                <input type="text" id="editSubtitle" name="subtitle" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
            </div>

            <div>
                <label class="block text-zinc-300 font-semibold mb-1">URL Tujuan</label>
                <input type="url" id="editUrl" name="url" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-zinc-300 font-semibold mb-1">Ukuran Kartu</label>
                    <select id="editCardSize" name="card_size" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
                        <option value="full">Lebar Penuh (100%)</option>
                        <option value="half">Bento Grid (50% Berdampingan)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-zinc-300 font-semibold mb-1">Ikon Tautan</label>
                    <select id="editIcon" name="icon" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
                        <option value="link">Tautan Umum (Link)</option>
                        <option value="github">GitHub</option>
                        <option value="shopping-bag">Toko / Belanja</option>
                        <option value="sparkles">Bintang / Kreatif</option>
                        <option value="send">Telegram / Kirim</option>
                        <option value="code">Kode / Developer</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-zinc-300 font-semibold mb-1">Teks Badge</label>
                    <input type="text" id="editBadgeText" name="badge_text" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
                </div>
                <div>
                    <label class="block text-zinc-300 font-semibold mb-1">Warna Badge</label>
                    <select id="editBadgeColor" name="badge_color" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
                        <option value="emerald">Emerald (Hijau)</option>
                        <option value="sky">Sky (Biru)</option>
                        <option value="amber">Amber (Kuning/Emas)</option>
                        <option value="purple">Purple (Ungu)</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-4 pt-2">
                <label class="flex items-center gap-2 text-zinc-300 cursor-pointer">
                    <input type="checkbox" id="editHighlighted" name="is_highlighted" value="1" class="rounded bg-zinc-800 border-zinc-700 text-sky-500">
                    <span>Animasi Sorotan (Glow/Pulse)</span>
                </label>
                <label class="flex items-center gap-2 text-zinc-300 cursor-pointer">
                    <input type="checkbox" id="editOpenInNewTab" name="open_in_new_tab" value="1" class="rounded bg-zinc-800 border-zinc-700 text-sky-500">
                    <span>Buka di Tab Baru</span>
                </label>
            </div>

            <div class="flex justify-end gap-2 pt-3 border-t border-zinc-800">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 rounded-xl bg-zinc-800 hover:bg-zinc-700 text-zinc-300">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-sky-500 hover:bg-sky-400 text-white font-bold">Perbarui</button>
            </div>
        </form>
    </div>
</div>

<script>
    function refreshPreview() {
        const iframe = document.getElementById('previewIframe');
        if (iframe) iframe.src = iframe.src;
    }

    function openAddModal() {
        document.getElementById('addModal').classList.remove('hidden');
    }
    function closeAddModal() {
        document.getElementById('addModal').classList.add('hidden');
    }

    function openEditModal(btn) {
        try {
            const link = JSON.parse(btn.getAttribute('data-link'));
            const form = document.getElementById('editForm');
            form.action = `/admin/links/${link.id}`;

            document.getElementById('editType').value = link.type || 'link';
            document.getElementById('editTitle').value = link.title || '';
            document.getElementById('editSubtitle').value = link.subtitle || '';
            document.getElementById('editUrl').value = link.url || '';
            document.getElementById('editCardSize').value = link.card_size || 'full';
            document.getElementById('editIcon').value = link.icon || 'link';
            document.getElementById('editBadgeText').value = link.badge_text || '';
            document.getElementById('editBadgeColor').value = link.badge_color || 'emerald';
            document.getElementById('editHighlighted').checked = !!link.is_highlighted;
            document.getElementById('editOpenInNewTab').checked = !!link.open_in_new_tab;

            document.getElementById('editModal').classList.remove('hidden');
        } catch (e) {
            console.error('Failed to parse link data:', e);
        }
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    async function toggleLinkActive(id, btn) {
        try {
            const res = await fetch(`/admin/links/${id}/toggle`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            const data = await res.json();
            if (data.success) {
                if (data.is_active) {
                    btn.className = 'px-2.5 py-1.5 rounded-lg text-xs font-semibold border transition-colors bg-emerald-500/10 text-emerald-400 border-emerald-500/30 hover:bg-emerald-500/20';
                    btn.innerText = 'Aktif';
                } else {
                    btn.className = 'px-2.5 py-1.5 rounded-lg text-xs font-semibold border transition-colors bg-zinc-800 text-zinc-400 border-zinc-700 hover:bg-zinc-700';
                    btn.innerText = 'Mati';
                }
                refreshPreview();
            }
        } catch (err) {
            alert('Gagal mengubah status tautan');
        }
    }

    // Initialize Drag & Drop Sortable
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('linksContainer');
        if (container && typeof Sortable !== 'undefined') {
            new Sortable(container, {
                handle: '.drag-handle',
                animation: 200,
                ghostClass: 'bg-sky-500/10',
                chosenClass: 'border-sky-500/50',
                dragClass: 'shadow-2xl',
                onEnd: function() {
                    saveLinksOrder();
                }
            });
        }
    });

    // Move Link 1 step Up
    function moveLinkUp(btn) {
        const card = btn.closest('[data-id]');
        const prev = card.previousElementSibling;
        if (prev && prev.hasAttribute('data-id')) {
            card.parentNode.insertBefore(card, prev);
            saveLinksOrder();
        }
    }

    // Move Link 1 step Down
    function moveLinkDown(btn) {
        const card = btn.closest('[data-id]');
        const next = card.nextElementSibling;
        if (next && next.hasAttribute('data-id')) {
            card.parentNode.insertBefore(next, card);
            saveLinksOrder();
        }
    }

    // Persist new link order to server via AJAX
    async function saveLinksOrder() {
        const container = document.getElementById('linksContainer');
        const cards = container.querySelectorAll('[data-id]');
        const order = Array.from(cards).map(c => parseInt(c.getAttribute('data-id')));

        try {
            const res = await fetch('{{ route('admin.links.reorder') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ order })
            });
            const data = await res.json();
            if (data.success) {
                showReorderToast();
                refreshPreview();
            }
        } catch (err) {
            console.error('Failed to save order:', err);
        }
    }

    // Fast Toggle CV Status from Links page
    async function toggleCvStatus(btn) {
        btn.disabled = true;
        try {
            const res = await fetch('{{ route('admin.cv.toggle') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            const data = await res.json();
            if (data.success) {
                const isActive = Boolean(data.enable_cv);
                const badge = document.getElementById('cvActiveBadge');
                const text = document.getElementById('cvActiveText');
                const dot = document.getElementById('cvActiveDot');
                const bar = document.getElementById('cvCardBar');
                const card = document.getElementById('cvCardInLinks');

                if (isActive) {
                    btn.className = 'px-2.5 py-1.5 rounded-lg text-xs font-semibold border transition-all bg-emerald-500/10 text-emerald-400 border-emerald-500/30 hover:bg-emerald-500/20';
                    btn.innerText = 'Aktif';
                    if (badge) badge.className = 'text-[9px] font-mono font-bold uppercase px-2 py-0.5 rounded-full flex items-center gap-1 bg-emerald-500/15 text-emerald-400 border border-emerald-500/30';
                    if (text) text.innerText = 'Aktif di Bio';
                    if (dot) dot.className = 'w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse';
                    if (bar) bar.className = 'absolute left-0 top-0 bottom-0 w-1.5 bg-gradient-to-b from-sky-400 to-indigo-500';
                    if (card) {
                        card.classList.remove('border-zinc-800');
                        card.classList.add('border-sky-500/40');
                    }
                } else {
                    btn.className = 'px-2.5 py-1.5 rounded-lg text-xs font-semibold border transition-all bg-zinc-800 text-zinc-400 border-zinc-700 hover:bg-zinc-700';
                    btn.innerText = 'Mati';
                    if (badge) badge.className = 'text-[9px] font-mono font-bold uppercase px-2 py-0.5 rounded-full flex items-center gap-1 bg-zinc-800 text-zinc-500 border border-zinc-700';
                    if (text) text.innerText = 'Nonaktif';
                    if (dot) dot.className = 'w-1.5 h-1.5 rounded-full bg-zinc-500';
                    if (bar) bar.className = 'absolute left-0 top-0 bottom-0 w-1.5 bg-zinc-700';
                    if (card) {
                        card.classList.remove('border-sky-500/40');
                        card.classList.add('border-zinc-800');
                    }
                }

                refreshPreview();
            }
        } catch (err) {
            console.error('Error toggling CV:', err);
            alert('Gagal mengubah status CV.');
        } finally {
            btn.disabled = false;
        }
    }

    // Display floating toast message
    function showReorderToast() {
        const toast = document.getElementById('reorderToast');
        if (!toast) return;
        toast.classList.remove('translate-y-20', 'opacity-0');
        setTimeout(() => {
            toast.classList.add('translate-y-20', 'opacity-0');
        }, 2200);
    }
</script>

<!-- Floating Toast Notification -->
<div id="reorderToast" class="fixed bottom-6 right-6 z-50 bg-emerald-500 text-white px-4 py-2.5 rounded-2xl shadow-2xl backdrop-blur-md text-xs font-bold flex items-center gap-2 transform translate-y-20 opacity-0 transition-all duration-300 pointer-events-none">
    <i data-lucide="check-circle" class="w-4 h-4"></i>
    <span>Urutan tautan berhasil disimpan!</span>
</div>

<!-- SortableJS CDN -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
@endsection
