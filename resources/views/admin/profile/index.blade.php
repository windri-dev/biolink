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
                                <svg class="w-5 h-5 text-pink-400 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            @elseif($soc->platform === 'tiktok')
                                <svg class="w-5 h-5 fill-current text-white" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.24 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                            @elseif($soc->platform === 'telegram')
                                <svg class="w-5 h-5 text-sky-400 fill-current" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.446 1.394c-.16.16-.295.295-.605.295l.213-3.053 5.56-5.023c.242-.213-.054-.333-.373-.121l-6.871 4.326-2.962-.924c-.643-.204-.657-.643.136-.953l11.57-4.458c.538-.196 1.006.128.832.915z"/></svg>
                            @elseif($soc->platform === 'whatsapp')
                                <svg class="w-5 h-5 text-emerald-400 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.301-.15-1.781-.878-2.056-.979-.275-.1-.475-.15-.675.15-.2.301-.776.979-.951 1.18-.175.2-.35.226-.651.075-.301-.15-1.272-.469-2.424-1.496-.895-.798-1.5-1.784-1.675-2.085-.175-.301-.019-.464.132-.614.136-.135.301-.35.451-.526.15-.175.2-.301.301-.501.1-.2.05-.376-.025-.526-.075-.15-.675-1.628-.925-2.231-.244-.588-.493-.508-.675-.517-.175-.01-.375-.01-.576-.01-.2 0-.526.075-.802.376-.275.301-1.052 1.028-1.052 2.508s1.077 2.909 1.228 3.11c.15.2 2.12 3.238 5.136 4.542.717.311 1.277.496 1.713.635.72.229 1.376.197 1.895.119.579-.087 1.781-.728 2.032-1.431.25-.702.25-1.303.175-1.43-.075-.126-.275-.201-.576-.351zm-5.467 7.618h-.002a10.948 10.948 0 0 1-5.586-1.531l-.401-.238-4.156 1.09 1.109-4.052-.261-.415A10.957 10.957 0 0 1 1.01 11.002C1.01 4.936 5.946 0 12.005 0c2.936 0 5.696 1.144 7.771 3.22a10.923 10.923 0 0 1 3.224 7.78c0 6.069-4.938 11.002-10.995 11.002z"/></svg>
                            @elseif($soc->platform === 'discord')
                                <svg class="w-5 h-5 text-indigo-400 fill-current" viewBox="0 0 24 24"><path d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0 12.64 12.64 0 0 0-.617-1.25.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057 19.9 19.9 0 0 0 5.993 3.03.078.078 0 0 0 .084-.028c.462-.63.874-1.295 1.226-1.994.021-.041.001-.09-.041-.106a13.107 13.107 0 0 1-1.872-.892.077.077 0 0 1-.008-.128 10.2 10.2 0 0 0 .372-.292.074.074 0 0 1 .077-.01c3.929 1.793 8.18 1.793 12.061 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127 12.299 12.299 0 0 1-1.873.894.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028 19.839 19.839 0 0 0 6.002-3.03.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.028zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.956-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.955-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.946 2.418-2.157 2.418z"/></svg>
                            @elseif($soc->platform === 'facebook')
                                <svg class="w-5 h-5 text-blue-500 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            @elseif($soc->platform === 'spotify')
                                <svg class="w-5 h-5 text-emerald-400 fill-current" viewBox="0 0 24 24"><path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.54.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.419 1.56-.299.421-1.02.599-1.559.3z"/></svg>
                            @elseif($soc->platform === 'youtube')
                                <svg class="w-5 h-5 text-red-500 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            @elseif($soc->platform === 'twitter' || $soc->platform === 'x' || $soc->platform === 'threads')
                                <svg class="w-5 h-5 fill-current text-white" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            @elseif($soc->platform === 'linkedin')
                                <svg class="w-5 h-5 text-blue-400 fill-current" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                            @elseif($soc->platform === 'email')
                                <svg class="w-5 h-5 text-amber-300 fill-current" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                            @else
                                <svg class="w-5 h-5 text-sky-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
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
