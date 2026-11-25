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

    <!-- Social Media Accounts Form -->
    <div class="bg-zinc-900/70 border border-zinc-800 rounded-2xl p-6 space-y-4">
        <div>
            <h3 class="text-sm font-bold text-white flex items-center gap-2">
                <i data-lucide="share-2" class="w-4 h-4 text-emerald-400"></i>
                <span>Akun Media Sosial & Kanal Komunikasi</span>
            </h3>
            <p class="text-xs text-zinc-400">Ikon yang diisi URL-nya akan otomatis muncul sebagai deretan tombol di bawah bio Anda.</p>
        </div>

        <form action="{{ route('admin.profile.socials') }}" method="POST" class="space-y-3 text-xs">
            @csrf

            @php
                $platforms = [
                    'github' => ['label' => 'GitHub', 'icon' => 'github', 'placeholder' => 'https://github.com/windri-dev'],
                    'telegram' => ['label' => 'Telegram', 'icon' => 'send', 'placeholder' => 'https://t.me/windri'],
                    'whatsapp' => ['label' => 'WhatsApp', 'icon' => 'message-circle', 'placeholder' => 'https://wa.me/628...'],
                    'email' => ['label' => 'Email', 'icon' => 'mail', 'placeholder' => 'mailto:mail262@gmail.com'],
                    'website' => ['label' => 'Situs Web Resmi', 'icon' => 'globe', 'placeholder' => 'https://wn-cdn.net'],
                    'youtube' => ['label' => 'YouTube', 'icon' => 'youtube', 'placeholder' => 'https://youtube.com/@...'],
                    'twitter' => ['label' => 'X / Twitter', 'icon' => 'twitter', 'placeholder' => 'https://x.com/...'],
                    'linkedin' => ['label' => 'LinkedIn', 'icon' => 'linkedin', 'placeholder' => 'https://linkedin.com/in/...'],
                ];
                $activeSocMap = $socialLinks->keyBy('platform');
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                @foreach($platforms as $platKey => $meta)
                    @php
                        $curSoc = $activeSocMap->get($platKey);
                    @endphp
                    <div class="p-3 rounded-xl bg-zinc-800/40 border border-zinc-800 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-zinc-800 flex items-center justify-center text-zinc-300 flex-shrink-0">
                            <i data-lucide="{{ $meta['icon'] }}" class="w-4 h-4"></i>
                        </div>
                        <div class="flex-grow min-w-0">
                            <label class="block text-[11px] font-semibold text-zinc-300 mb-0.5">{{ $meta['label'] }}</label>
                            <input type="text" 
                                   name="socials[{{ $platKey }}][url]" 
                                   value="{{ $curSoc?->url ?? '' }}" 
                                   placeholder="{{ $meta['placeholder'] }}" 
                                   class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-2.5 py-1.5 text-white text-[11px] font-mono focus:outline-none focus:border-sky-400">
                        </div>
                        <label class="flex items-center gap-1.5 cursor-pointer ml-1 text-[11px] text-zinc-400">
                            <input type="checkbox" name="socials[{{ $platKey }}][is_active]" value="1" {{ ($curSoc?->is_active ?? true) ? 'checked' : '' }} class="rounded bg-zinc-900 border-zinc-700 text-sky-500">
                            <span>Aktif</span>
                        </label>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-end pt-3 border-t border-zinc-800">
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold transition-all shadow-lg shadow-emerald-600/20">
                    Simpan Akun Media Sosial
                </button>
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
</script>
@endsection
