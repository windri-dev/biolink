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
                        <input type="hidden" name="ai_assistant_enabled" value="0">
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

            <!-- SEO & Meta Settings (Judul Tab Browser & Deskripsi Mesin Pencari) -->
            <div class="border-t border-zinc-800 pt-5 space-y-3">
                <div>
                    <h4 class="text-sm font-bold text-white flex items-center gap-1.5">
                        <i data-lucide="globe" class="w-4 h-4 text-sky-400"></i>
                        <span>SEO & Judul Halaman (Browser Tab Title)</span>
                    </h4>
                    <p class="text-[11px] text-zinc-400">Atur judul yang tampil di tab browser pengunjung serta pratinjau di Google & media sosial.</p>
                </div>

                <div class="space-y-3 pt-1">
                    <div>
                        <label class="block text-zinc-300 font-semibold mb-1 text-xs">Judul Tab Browser (Meta Title)</label>
                        <input type="text" name="meta_title" value="{{ $profile->meta_title }}" placeholder="Contoh: {{ $profile->display_name }} (@{{ $profile->clean_handle }}) • Portfolio" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400 text-sm">
                        <span class="text-[10px] text-zinc-500 mt-1 block">Kosongkan jika ingin menggunakan judul default: {{ $profile->display_name }} (@{{ $profile->clean_handle }})</span>
                    </div>
                    <div>
                        <label class="block text-zinc-300 font-semibold mb-1 text-xs">Deskripsi Halaman (Meta Description)</label>
                        <textarea name="meta_description" rows="2" placeholder="Deskripsi singkat profil Anda yang tampil di hasil pencarian Google..." class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400 text-sm">{{ $profile->meta_description }}</textarea>
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

        <!-- Social Links List Header & Counter -->
        <div class="flex items-center justify-between px-1 text-[11px] text-zinc-400 font-medium">
            <span class="flex items-center gap-1.5">
                <i data-lucide="arrow-up-down" class="w-3.5 h-3.5 text-emerald-400"></i>
                <span>Tahan & geser icon grip atau klik panah untuk mengatur urutan media sosial di bio</span>
            </span>
            <span class="font-mono text-zinc-500">{{ count($socialLinks) }} Saluran</span>
        </div>

        <!-- Social Links List -->
        <div class="space-y-3" id="socialContainer">
            @forelse($socialLinks as $soc)
                <div class="p-3.5 rounded-2xl bg-zinc-800/40 border border-zinc-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:border-zinc-700/80 transition-all select-none group" data-id="{{ $soc->id }}">
                    <div class="flex items-center gap-2.5 sm:gap-3.5 min-w-0">
                        <!-- Drag Handle & Up/Down Arrows -->
                        <div class="flex items-center gap-1 flex-shrink-0">
                            <div class="drag-handle p-1.5 rounded-lg text-zinc-500 hover:text-white hover:bg-zinc-800 cursor-grab active:cursor-grabbing transition-colors" title="Geser (Drag & Drop) untuk mengatur urutan">
                                <i data-lucide="grip-vertical" class="w-4 h-4"></i>
                            </div>
                            <div class="flex flex-col -space-y-0.5">
                                <button type="button" onclick="moveSocialUp(this)" class="p-0.5 rounded text-zinc-500 hover:text-emerald-400 hover:bg-zinc-800 transition-colors" title="Pindahkan ke atas">
                                    <i data-lucide="chevron-up" class="w-3.5 h-3.5"></i>
                                </button>
                                <button type="button" onclick="moveSocialDown(this)" class="p-0.5 rounded text-zinc-500 hover:text-emerald-400 hover:bg-zinc-800 transition-colors" title="Pindahkan ke bawah">
                                    <i data-lucide="chevron-down" class="w-3.5 h-3.5"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Platform SVG Icon Component -->
                        <div class="w-10 h-10 rounded-xl bg-zinc-800 border border-zinc-700/80 flex items-center justify-center flex-shrink-0 text-white shadow-sm">
                            <x-social-icon :platform="$soc->platform" class="w-5 h-5" />
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
                    <option value="shopee">Shopee (Toko Online)</option>
                    <option value="tokopedia">Tokopedia (Toko Online)</option>
                    <option value="dribbble">Dribbble (Portofolio)</option>
                    <option value="behance">Behance (Portofolio)</option>
                    <option value="medium">Medium (Blog/Artikel)</option>
                    <option value="pinterest">Pinterest</option>
                    <option value="twitch">Twitch (Live Stream)</option>
                    <option value="steam">Steam (Gaming)</option>
                    <option value="phone">Telepon / Call (Nomor Kontak)</option>
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
                    <option value="shopee">Shopee (Toko Online)</option>
                    <option value="tokopedia">Tokopedia (Toko Online)</option>
                    <option value="dribbble">Dribbble (Portofolio)</option>
                    <option value="behance">Behance (Portofolio)</option>
                    <option value="medium">Medium (Blog/Artikel)</option>
                    <option value="pinterest">Pinterest</option>
                    <option value="twitch">Twitch (Live Stream)</option>
                    <option value="steam">Steam (Gaming)</option>
                    <option value="phone">Telepon / Call (Nomor Kontak)</option>
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
            'shopee': 'https://shopee.co.id/namatoko',
            'tokopedia': 'https://tokopedia.com/namatoko',
            'dribbble': 'https://dribbble.com/username',
            'behance': 'https://behance.net/username',
            'medium': 'https://medium.com/@username',
            'pinterest': 'https://pinterest.com/username',
            'twitch': 'https://twitch.tv/username',
            'steam': 'https://steamcommunity.com/id/username',
            'phone': 'tel:+6281234567890',
            'website': 'https://domain.com'
        };
        if (placeholders[platform]) {
            urlInput.placeholder = placeholders[platform];
        }
    }

    // Initialize Drag & Drop Sortable for Social Links
    document.addEventListener('DOMContentLoaded', function() {
        if (window.lucide) {
            lucide.createIcons();
        }

        const container = document.getElementById('socialContainer');
        if (container && typeof Sortable !== 'undefined') {
            new Sortable(container, {
                handle: '.drag-handle',
                animation: 200,
                ghostClass: 'bg-emerald-500/10',
                chosenClass: 'border-emerald-500/50',
                dragClass: 'shadow-2xl',
                onEnd: function() {
                    saveSocialOrder();
                }
            });
        }
    });

    // Move Social Link 1 step Up
    function moveSocialUp(btn) {
        const card = btn.closest('[data-id]');
        const prev = card.previousElementSibling;
        if (prev && prev.hasAttribute('data-id')) {
            card.parentNode.insertBefore(card, prev);
            saveSocialOrder();
        }
    }

    // Move Social Link 1 step Down
    function moveSocialDown(btn) {
        const card = btn.closest('[data-id]');
        const next = card.nextElementSibling;
        if (next && next.hasAttribute('data-id')) {
            card.parentNode.insertBefore(next, card);
            saveSocialOrder();
        }
    }

    // Persist new social order to server via AJAX
    async function saveSocialOrder() {
        const container = document.getElementById('socialContainer');
        const cards = container.querySelectorAll('[data-id]');
        const order = Array.from(cards).map(c => parseInt(c.getAttribute('data-id')));

        try {
            const res = await fetch('{{ route('admin.profile.socials.reorder') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ order })
            });
            const data = await res.json();
            if (data.success) {
                showSocialToast();
            }
        } catch (err) {
            console.error('Failed to save social order:', err);
        }
    }

    // Display floating toast message
    function showSocialToast() {
        const toast = document.getElementById('socialReorderToast');
        if (!toast) return;
        toast.classList.remove('translate-y-20', 'opacity-0');
        setTimeout(() => {
            toast.classList.add('translate-y-20', 'opacity-0');
        }, 2200);
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

<!-- Floating Toast Notification for Social Links -->
<div id="socialReorderToast" class="fixed bottom-6 right-6 z-50 bg-emerald-500 text-white px-4 py-2.5 rounded-2xl shadow-2xl backdrop-blur-md text-xs font-bold flex items-center gap-2 transform translate-y-20 opacity-0 transition-all duration-300 pointer-events-none">
    <i data-lucide="check-circle" class="w-4 h-4"></i>
    <span>Urutan media sosial berhasil disimpan!</span>
</div>

<!-- SortableJS CDN -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
@endsection
