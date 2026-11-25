@extends('layouts.admin')

@section('title', 'Profil & Media Sosial')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div>
        <h2 class="text-lg font-bold text-white tracking-tight">Pengaturan Profil & Media Sosial</h2>
        <p class="text-xs text-zinc-400">Sesuaikan informasi identitas, foto profil, dan akun media sosial yang tampil di halaman bio Anda.</p>
    </div>

    <!-- Main Profile Form -->
    <div class="bg-zinc-900/70 border border-zinc-800 rounded-2xl p-6 space-y-6">
        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5 text-xs">
            @csrf

            <!-- Avatar & Basic Row -->
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 border-b border-zinc-800 pb-6">
                <!-- Avatar Preview -->
                <div class="relative group">
                    <img id="avatarPreview" 
                         src="{{ $profile->avatar_url ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=300' }}" 
                         alt="{{ $profile->display_name }}" 
                         class="w-24 h-24 rounded-full object-cover border-2 border-zinc-700 bg-zinc-800">
                    <label for="avatar_file" class="absolute bottom-0 right-0 p-2 rounded-full bg-sky-500 hover:bg-sky-400 text-white cursor-pointer shadow-lg transition-transform hover:scale-110" title="Ganti Foto">
                        <i data-lucide="camera" class="w-3.5 h-3.5"></i>
                        <input type="file" id="avatar_file" name="avatar_file" accept="image/*" class="hidden" onchange="previewAvatar(this)">
                    </label>
                </div>

                <div class="space-y-1 text-center sm:text-left flex-grow">
                    <h3 class="text-sm font-bold text-white">Foto Profil</h3>
                    <p class="text-xs text-zinc-400">Format yang didukung: JPG, PNG, atau WEBP. Rekomendasi ukuran persegi 400x400 px.</p>
                    <div class="pt-2">
                        <input type="url" name="avatar_url" value="{{ $profile->avatar_url }}" placeholder="Atau tempel URL gambar eksternal di sini..." class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
                    </div>
                </div>
            </div>

            <!-- Identity Fields -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-zinc-300 font-semibold mb-1">Nama Tampilan *</label>
                    <input type="text" name="display_name" value="{{ $profile->display_name }}" required class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
                </div>
                <div>
                    <label class="block text-zinc-300 font-semibold mb-1">Handle / Username Publik *</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-zinc-500 font-mono">@</span>
                        <input type="text" name="handle" value="{{ $profile->clean_handle }}" required class="w-full bg-zinc-800 border border-zinc-700 rounded-xl py-2 pl-7 pr-3 text-white font-mono focus:outline-none focus:border-sky-400">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-zinc-300 font-semibold mb-1">Tagline Profesi</label>
                    <input type="text" name="tagline" value="{{ $profile->tagline }}" placeholder="Contoh: Senior Full-Stack Software Engineer" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
                </div>
                <div>
                    <label class="block text-zinc-300 font-semibold mb-1">Lokasi Domisili</label>
                    <input type="text" name="location" value="{{ $profile->location }}" placeholder="Contoh: Jakarta, Indonesia" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
                </div>
            </div>

            <div>
                <label class="block text-zinc-300 font-semibold mb-1">Bio Deskripsi Singkat</label>
                <textarea name="bio" rows="3" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">{{ $profile->bio }}</textarea>
            </div>

            <!-- Verified Badge & Features Toggle -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 border-t border-zinc-800 pt-5">
                <label class="flex items-start gap-3 p-3 rounded-xl bg-zinc-800/40 border border-zinc-800 cursor-pointer">
                    <input type="checkbox" name="is_verified" value="1" {{ $profile->is_verified ? 'checked' : '' }} class="mt-0.5 rounded bg-zinc-800 border-zinc-700 text-sky-500">
                    <div>
                        <span class="font-bold text-white block">Tampilkan Verified Badge</span>
                        <span class="text-[11px] text-zinc-400">Menampilkan lencana centang biru resmi di samping foto profil.</span>
                    </div>
                </label>

                <label class="flex items-start gap-3 p-3 rounded-xl bg-zinc-800/40 border border-zinc-800 cursor-pointer">
                    <input type="checkbox" name="show_share_button" value="1" {{ $profile->show_share_button ? 'checked' : '' }} class="mt-0.5 rounded bg-zinc-800 border-zinc-700 text-sky-500">
                    <div>
                        <span class="font-bold text-white block">Tombol Share Halaman</span>
                        <span class="text-[11px] text-zinc-400">Memungkinkan pengunjung menyalin URL bio atau membagikan ke aplikasi lain.</span>
                    </div>
                </label>
            </div>

            <!-- AI Assistant Settings -->
            <div class="border-t border-zinc-800 pt-5 space-y-3">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-bold text-white flex items-center gap-1.5">
                            <i data-lucide="bot" class="w-4 h-4 text-sky-400"></i>
                            <span>Asisten Pintar AI (Floating Chat Widget)</span>
                        </h4>
                        <p class="text-[11px] text-zinc-400">Widget AI mengambang di pojok kanan bawah yang otomatis memandu pengunjung Anda.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="ai_assistant_enabled" value="1" {{ $profile->ai_assistant_enabled ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-zinc-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-zinc-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-sky-500"></div>
                    </label>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <div>
                        <label class="block text-zinc-300 font-semibold mb-1">Nama Asisten AI</label>
                        <input type="text" name="ai_assistant_name" value="{{ $profile->ai_assistant_name }}" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
                    </div>
                    <div>
                        <label class="block text-zinc-300 font-semibold mb-1">Pesan Salam Awal (Greeting)</label>
                        <input type="text" name="ai_greeting_message" value="{{ $profile->ai_greeting_message }}" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-zinc-800">
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-sky-500 hover:bg-sky-400 text-white font-bold transition-all shadow-lg shadow-sky-500/20">
                    Simpan Perubahan Profil
                </button>
            </div>
        </form>
    </div>

    <!-- Social Media Accounts Management Section -->
    <div class="bg-zinc-900/70 border border-zinc-800 rounded-3xl p-6 space-y-5 shadow-xl">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-zinc-800">
            <div>
                <h3 class="text-sm font-bold text-white flex items-center gap-2">
                    <i data-lucide="share-2" class="w-4 h-4 text-emerald-400"></i>
                    <span>Akun Media Sosial & Kanal Komunikasi</span>
                </h3>
                <p class="text-xs text-zinc-400 mt-0.5">Kelola tautan media sosial dan kontak bio Anda. Tambah akun sesuka Anda, nonaktifkan jika tidak ingin ditampilkan di bio, atau hapus kapan saja.</p>
            </div>
            <button type="button" onclick="openAddSocialModal()" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs transition-all shadow-lg shadow-emerald-600/20 inline-flex items-center gap-1.5 self-start sm:self-auto flex-shrink-0">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Tambah Media Sosial</span>
            </button>
        </div>

        <!-- Social Links List -->
        <div class="space-y-3">
            @forelse($socialLinks as $soc)
                <div class="p-3.5 rounded-2xl bg-zinc-800/40 border border-zinc-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:border-zinc-700/80 transition-all">
                    <div class="flex items-center gap-3 min-w-0">
                        <!-- Platform SVG Icon -->
                        <div class="w-10 h-10 rounded-xl bg-zinc-800 border border-zinc-700/80 flex items-center justify-center flex-shrink-0 text-white shadow-sm">
                            @if($soc->platform === 'github')
                                <svg class="w-5 h-5 fill-current text-white" viewBox="0 0 24 24"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/></svg>
                            @elseif($soc->platform === 'instagram')
                                <svg class="w-5 h-5 text-pink-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
                            @elseif($soc->platform === 'tiktok')
                                <svg class="w-5 h-5 fill-current text-white" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.24 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                            @elseif($soc->platform === 'telegram')
                                <svg class="w-5 h-5 text-sky-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                            @elseif($soc->platform === 'whatsapp')
                                <svg class="w-5 h-5 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 21 1.9-5.7a8.5 8.5 0 1 1 3.8 3.8z"/></svg>
                            @elseif($soc->platform === 'youtube')
                                <svg class="w-5 h-5 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17"/><polygon points="10 15 15 12 10 9 10 15"/></svg>
                            @elseif($soc->platform === 'twitter' || $soc->platform === 'x' || $soc->platform === 'threads')
                                <svg class="w-5 h-5 fill-current text-white" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            @elseif($soc->platform === 'linkedin')
                                <svg class="w-5 h-5 text-blue-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/></svg>
                            @elseif($soc->platform === 'email')
                                <svg class="w-5 h-5 text-amber-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                            @else
                                <svg class="w-5 h-5 text-zinc-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
                            @endif
                        </div>

                        <div class="min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="text-xs font-bold text-white">{{ $soc->label ?: ucfirst($soc->platform) }}</span>
                                <span class="text-[9px] font-mono px-2 py-0.5 rounded bg-zinc-800 text-zinc-400 uppercase border border-zinc-700/60">
                                    {{ $soc->platform }}
                                </span>
                                @if($soc->is_active)
                                    <span id="socBadgeActive_{{ $soc->id }}" class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                        Aktif di Bio
                                    </span>
                                @else
                                    <span id="socBadgeActive_{{ $soc->id }}" class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-zinc-800 text-zinc-500 border border-zinc-700">
                                        Nonaktif (Disembunyikan)
                                    </span>
                                @endif
                            </div>
                            <a href="{{ $soc->url }}" target="_blank" rel="noopener noreferrer" class="text-[11px] text-zinc-400 hover:text-sky-400 font-mono truncate block mt-0.5 max-w-sm">
                                {{ $soc->url }}
                            </a>
                        </div>
                    </div>

                    <!-- Action Buttons: Toggle, Edit, Delete -->
                    <div class="flex items-center gap-2 flex-shrink-0 self-end sm:self-center">
                        <!-- Toggle Active/Inactive Button -->
                        <button type="button" 
                                id="socToggleBtn_{{ $soc->id }}"
                                onclick="toggleSocialLink({{ $soc->id }}, this)" 
                                class="px-3 py-1.5 rounded-xl text-xs font-bold border transition-all {{ $soc->is_active ? 'bg-emerald-500/10 text-emerald-300 border-emerald-500/30 hover:bg-emerald-500/20' : 'bg-zinc-800 text-zinc-400 border-zinc-700 hover:bg-zinc-700' }}"
                                title="Klik untuk mengaktifkan / menonaktifkan">
                            {{ $soc->is_active ? 'Aktif' : 'Nonaktif' }}
                        </button>

                        <!-- Edit Button -->
                        <button type="button"
                                data-social="{{ json_encode($soc) }}"
                                onclick="openEditSocialModal(this)"
                                class="p-2 rounded-xl bg-zinc-800 hover:bg-zinc-700 text-zinc-300 hover:text-white border border-zinc-700 transition-colors"
                                title="Edit Akun Ini">
                            <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                        </button>

                        <!-- Delete Form -->
                        <form action="{{ route('admin.profile.socials.destroy', $soc->id) }}" method="POST" onsubmit="return confirm('Hapus akun media sosial \'{{ $soc->label ?: $soc->platform }}\'?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 rounded-xl bg-zinc-800 hover:bg-rose-500/20 text-zinc-400 hover:text-rose-400 border border-zinc-700 hover:border-rose-500/30 transition-colors" title="Hapus Akun">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-8 rounded-2xl bg-zinc-800/20 border border-dashed border-zinc-800 text-center space-y-3">
                    <div class="w-10 h-10 rounded-full bg-zinc-800/80 text-zinc-500 flex items-center justify-center mx-auto">
                        <i data-lucide="share-2" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-zinc-300">Belum ada akun media sosial yang ditambahkan.</p>
                        <p class="text-[11px] text-zinc-500">Tambahkan akun Instagram, WhatsApp, TikTok, GitHub, atau Telegram Anda sekarang.</p>
                    </div>
                    <button type="button" onclick="openAddSocialModal()" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs transition-all inline-flex items-center gap-1.5 shadow-sm">
                        <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                        <span>Tambah Akun Pertama</span>
                    </button>
                </div>
            @endforelse
        </div>
    </div>

</div>

<!-- Modal Tambah Media Sosial -->
<div id="addSocialModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-zinc-900 border border-zinc-800 rounded-3xl max-w-md w-full p-6 space-y-4 shadow-2xl">
        <div class="flex items-center justify-between border-b border-zinc-800 pb-3">
            <h3 class="text-sm font-bold text-white flex items-center gap-2">
                <i data-lucide="plus-circle" class="w-4 h-4 text-emerald-400"></i>
                <span>Tambah Akun Media Sosial</span>
            </h3>
            <button onclick="closeAddSocialModal()" class="text-zinc-400 hover:text-white">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <form action="{{ route('admin.profile.socials.store') }}" method="POST" class="space-y-3.5 text-xs">
            @csrf

            <!-- Platform Selector -->
            <div>
                <label class="block text-zinc-300 font-semibold mb-1">Pilih Platform *</label>
                <select name="platform" id="addSocPlatform" onchange="autoSuggestSocialUrl(this.value)" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-emerald-400">
                    <option value="instagram">Instagram</option>
                    <option value="tiktok">TikTok</option>
                    <option value="whatsapp">WhatsApp</option>
                    <option value="telegram">Telegram</option>
                    <option value="github">GitHub</option>
                    <option value="youtube">YouTube</option>
                    <option value="twitter">X / Twitter</option>
                    <option value="linkedin">LinkedIn</option>
                    <option value="discord">Discord</option>
                    <option value="facebook">Facebook</option>
                    <option value="threads">Threads</option>
                    <option value="spotify">Spotify</option>
                    <option value="email">Email</option>
                    <option value="website">Situs Web / Custom</option>
                </select>
            </div>

            <!-- URL Input -->
            <div>
                <label class="block text-zinc-300 font-semibold mb-1">URL Profil / Nomor / Link *</label>
                <input type="text" 
                       name="url" 
                       id="addSocUrl" 
                       required 
                       placeholder="https://instagram.com/username" 
                       class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white font-mono focus:outline-none focus:border-emerald-400">
                <span class="text-[10px] text-zinc-500 mt-1 block">Contoh WA: <code>https://wa.me/6281234567890</code> &bull; Email: <code>mailto:nama@email.com</code></span>
            </div>

            <!-- Label Input -->
            <div>
                <label class="block text-zinc-300 font-semibold mb-1">Label Tampilan (Opsional)</label>
                <input type="text" 
                       name="label" 
                       id="addSocLabel"
                       placeholder="Kosongkan untuk memakai nama platform bawaan" 
                       class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-emerald-400">
            </div>

            <!-- Is Active Checkbox -->
            <div class="pt-1">
                <label class="flex items-center gap-2 text-zinc-300 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" checked class="rounded bg-zinc-800 border-zinc-700 text-emerald-500 focus:ring-0">
                    <span class="text-xs font-semibold">Tampilkan langsung di halaman bio (Aktif)</span>
                </label>
            </div>

            <!-- Submit -->
            <div class="flex justify-end gap-2 pt-3 border-t border-zinc-800">
                <button type="button" onclick="closeAddSocialModal()" class="px-4 py-2 rounded-xl bg-zinc-800 hover:bg-zinc-700 text-zinc-300">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold shadow-md shadow-emerald-600/20">Simpan Akun</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Media Sosial -->
<div id="editSocialModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-zinc-900 border border-zinc-800 rounded-3xl max-w-md w-full p-6 space-y-4 shadow-2xl">
        <div class="flex items-center justify-between border-b border-zinc-800 pb-3">
            <h3 class="text-sm font-bold text-white flex items-center gap-2">
                <i data-lucide="edit-3" class="w-4 h-4 text-sky-400"></i>
                <span>Edit Akun Media Sosial</span>
            </h3>
            <button onclick="closeEditSocialModal()" class="text-zinc-400 hover:text-white">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <form id="editSocialForm" method="POST" class="space-y-3.5 text-xs">
            @csrf
            @method('PUT')

            <!-- Platform Selector -->
            <div>
                <label class="block text-zinc-300 font-semibold mb-1">Platform *</label>
                <select name="platform" id="editSocPlatform" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
                    <option value="instagram">Instagram</option>
                    <option value="tiktok">TikTok</option>
                    <option value="whatsapp">WhatsApp</option>
                    <option value="telegram">Telegram</option>
                    <option value="github">GitHub</option>
                    <option value="youtube">YouTube</option>
                    <option value="twitter">X / Twitter</option>
                    <option value="linkedin">LinkedIn</option>
                    <option value="discord">Discord</option>
                    <option value="facebook">Facebook</option>
                    <option value="threads">Threads</option>
                    <option value="spotify">Spotify</option>
                    <option value="email">Email</option>
                    <option value="website">Situs Web / Custom</option>
                </select>
            </div>

            <!-- URL Input -->
            <div>
                <label class="block text-zinc-300 font-semibold mb-1">URL Profil / Nomor / Link *</label>
                <input type="text" 
                       name="url" 
                       id="editSocUrl" 
                       required 
                       class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white font-mono focus:outline-none focus:border-sky-400">
            </div>

            <!-- Label Input -->
            <div>
                <label class="block text-zinc-300 font-semibold mb-1">Label Tampilan</label>
                <input type="text" 
                       name="label" 
                       id="editSocLabel"
                       class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
            </div>

            <!-- Is Active Checkbox -->
            <div class="pt-1">
                <label class="flex items-center gap-2 text-zinc-300 cursor-pointer">
                    <input type="checkbox" name="is_active" id="editSocIsActive" value="1" class="rounded bg-zinc-800 border-zinc-700 text-sky-500 focus:ring-0">
                    <span class="text-xs font-semibold">Tampilkan di halaman bio (Aktif)</span>
                </label>
            </div>

            <!-- Submit -->
            <div class="flex justify-end gap-2 pt-3 border-t border-zinc-800">
                <button type="button" onclick="closeEditSocialModal()" class="px-4 py-2 rounded-xl bg-zinc-800 hover:bg-zinc-700 text-zinc-300">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-sky-500 hover:bg-sky-400 text-white font-bold shadow-md shadow-sky-500/20">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatarPreview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function openAddSocialModal() {
        document.getElementById('addSocialModal').classList.remove('hidden');
    }
    function closeAddSocialModal() {
        document.getElementById('addSocialModal').classList.add('hidden');
    }

    function openEditSocialModal(btn) {
        try {
            const soc = JSON.parse(btn.getAttribute('data-social'));
            const form = document.getElementById('editSocialForm');
            form.action = `/admin/profile/socials/${soc.id}`;

            document.getElementById('editSocPlatform').value = soc.platform;
            document.getElementById('editSocUrl').value = soc.url;
            document.getElementById('editSocLabel').value = soc.label || '';
            document.getElementById('editSocIsActive').checked = Boolean(soc.is_active);

            document.getElementById('editSocialModal').classList.remove('hidden');
        } catch(e) {
            console.error('Error parsing social data:', e);
        }
    }
    function closeEditSocialModal() {
        document.getElementById('editSocialModal').classList.add('hidden');
    }

    function autoSuggestSocialUrl(platform) {
        const urlInput = document.getElementById('addSocUrl');
        const placeholders = {
            'instagram': 'https://instagram.com/username',
            'tiktok': 'https://tiktok.com/@username',
            'whatsapp': 'https://wa.me/6281234567890',
            'telegram': 'https://t.me/username',
            'github': 'https://github.com/username',
            'youtube': 'https://youtube.com/@channel',
            'twitter': 'https://x.com/username',
            'linkedin': 'https://linkedin.com/in/username',
            'discord': 'https://discord.gg/invitecode',
            'facebook': 'https://facebook.com/username',
            'threads': 'https://threads.net/@username',
            'spotify': 'https://open.spotify.com/user/id',
            'email': 'mailto:email@domain.com',
            'website': 'https://domain.com'
        };
        if (placeholders[platform]) {
            urlInput.placeholder = placeholders[platform];
        }
    }

    async function toggleSocialLink(id, btn) {
        btn.disabled = true;
        try {
            const res = await fetch(`/admin/profile/socials/${id}/toggle`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            const data = await res.json();
            if (data.success) {
                const badge = document.getElementById(`socBadgeActive_${id}`);
                if (data.is_active) {
                    btn.className = 'px-3 py-1.5 rounded-xl text-xs font-bold border transition-all bg-emerald-500/10 text-emerald-300 border-emerald-500/30 hover:bg-emerald-500/20';
                    btn.innerText = 'Aktif';
                    if (badge) {
                        badge.className = 'text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20';
                        badge.innerText = 'Aktif di Bio';
                    }
                } else {
                    btn.className = 'px-3 py-1.5 rounded-xl text-xs font-bold border transition-all bg-zinc-800 text-zinc-400 border-zinc-700 hover:bg-zinc-700';
                    btn.innerText = 'Nonaktif';
                    if (badge) {
                        badge.className = 'text-[10px] font-bold px-2 py-0.5 rounded-full bg-zinc-800 text-zinc-500 border border-zinc-700';
                        badge.innerText = 'Nonaktif (Disembunyikan)';
                    }
                }
            }
        } catch (err) {
            alert('Gagal mengubah status: ' + err.message);
        } finally {
            btn.disabled = false;
        }
    }
</script>
@endsection
