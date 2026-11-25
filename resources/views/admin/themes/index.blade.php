@extends('layouts.admin')

@section('title', 'Tema & Tampilan')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-bold text-white tracking-tight">Koleksi Tema & Tampilan Visual</h2>
            <p class="text-xs text-zinc-400">Pilih dari preset tema modern atau buat palet gaya kustom sesuai identitas personal Anda.</p>
        </div>
        <button onclick="openCustomThemeModal()" class="px-4 py-2 rounded-xl bg-zinc-800 hover:bg-zinc-700 border border-zinc-700 text-white text-xs font-bold transition-all inline-flex items-center gap-1.5">
            <i data-lucide="palette" class="w-4 h-4 text-sky-400"></i>
            <span>Buat Tema Kustom</span>
        </button>
    </div>

    <!-- Active Theme Card -->
    <div class="bg-gradient-to-r from-sky-950/40 via-zinc-900 to-zinc-900 border border-sky-500/30 rounded-2xl p-5 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-white shadow-lg border border-white/20" style="background: {{ $currentTheme->background_value ?? '#0d0d11' }};">
                <i data-lucide="sparkles" class="w-5 h-5 text-sky-400"></i>
            </div>
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-sky-400 bg-sky-500/10 px-2 py-0.5 rounded-full border border-sky-500/20">Tema Aktif Saat Ini</span>
                <h3 class="text-base font-extrabold text-white mt-1">{{ $currentTheme->name ?? 'Default' }}</h3>
                <p class="text-xs text-zinc-400 font-mono text-[11px]">{{ $currentTheme->font_family ?? 'Plus Jakarta Sans' }} &bull; {{ $currentTheme->button_shape ?? 'rounded-2xl' }}</p>
            </div>
        </div>

        <a href="{{ route('public.bio') }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-sky-500 hover:bg-sky-400 text-white text-xs font-bold transition-all shadow-md inline-flex items-center gap-1.5">
            <span>Pratinjau Live</span>
            <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
        </a>
    </div>

    <!-- Themes Gallery Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($themes as $thm)
            @php
                $isActive = $currentTheme?->id === $thm->id;
            @endphp
            <div class="bg-zinc-900/70 border {{ $isActive ? 'border-sky-500 ring-2 ring-sky-500/30' : 'border-zinc-800 hover:border-zinc-700' }} rounded-2xl overflow-hidden flex flex-col transition-all group">
                
                <!-- Theme Visual Mockup Header -->
                <div class="h-36 p-4 flex flex-col justify-center items-center relative overflow-hidden" style="background: {{ $thm->background_value }};">
                    <!-- Miniature Mockup Card -->
                    <div class="w-44 px-3 py-2 text-center shadow-lg border text-[10px] font-bold truncate flex items-center justify-center gap-1.5 {{ $thm->button_shape }}"
                         style="background: {{ $thm->card_bg }}; border-color: {{ $thm->card_border }}; color: {{ $thm->card_text }};">
                        <span class="w-2 h-2 rounded-full" style="background: {{ $thm->accent_color }};"></span>
                        <span>Preview Tombol Link</span>
                    </div>

                    @if($isActive)
                        <div class="absolute top-2.5 right-2.5 bg-sky-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-md flex items-center gap-1">
                            <i data-lucide="check" class="w-3 h-3"></i>
                            <span>Aktif</span>
                        </div>
                    @endif
                </div>

                <!-- Theme Metadata & Action -->
                <div class="p-4 flex-grow flex flex-col justify-between space-y-3">
                    <div>
                        <div class="flex items-center justify-between">
                            <h4 class="font-bold text-sm text-white">{{ $thm->name }}</h4>
                            <span class="text-[10px] font-mono text-zinc-500 uppercase">{{ $thm->background_type }}</span>
                        </div>
                        <p class="text-[11px] text-zinc-400 mt-1">Font: {{ $thm->font_family }}</p>
                    </div>

                    <div>
                        @if($isActive)
                            <button disabled class="w-full py-2 rounded-xl bg-zinc-800 text-zinc-500 text-xs font-bold cursor-not-allowed">
                                Sedang Digunakan
                            </button>
                        @else
                            <form action="{{ route('admin.themes.apply', $thm->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full py-2 rounded-xl bg-zinc-800 hover:bg-sky-500 hover:text-white text-zinc-300 text-xs font-bold transition-colors">
                                    Terapkan Tema Ini
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

            </div>
        @endforeach
    </div>

</div>

<!-- Modal Buat Tema Kustom -->
<div id="customThemeModal" class="fixed inset-0 bg-black/75 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-zinc-900 border border-zinc-800 rounded-2xl max-w-lg w-full p-6 space-y-4 shadow-2xl">
        <div class="flex items-center justify-between border-b border-zinc-800 pb-3">
            <h3 class="text-sm font-bold text-white">Buat Tema Kustom Baru</h3>
            <button onclick="closeCustomThemeModal()" class="text-zinc-400 hover:text-white"><i data-lucide="x" class="w-4 h-4"></i></button>
        </div>

        <form action="{{ route('admin.themes.custom') }}" method="POST" class="space-y-3.5 text-xs">
            @csrf
            <div>
                <label class="block text-zinc-300 font-semibold mb-1">Nama Tema *</label>
                <input type="text" name="name" required placeholder="Contoh: Neon Emerald Dream" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-zinc-300 font-semibold mb-1">Tipe Latar Belakang</label>
                    <select name="background_type" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
                        <option value="gradient">Gradient CSS</option>
                        <option value="solid">Warna Solid</option>
                        <option value="glassmorphism">Glassmorphism</option>
                    </select>
                </div>
                <div>
                    <label class="block text-zinc-300 font-semibold mb-1">Bentuk Sudut Tombol</label>
                    <select name="button_shape" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
                        <option value="rounded-2xl">Rounded Modern (2xl)</option>
                        <option value="rounded-full">Pill Melingkar (Full)</option>
                        <option value="rounded-lg">Kotak Halus (lg)</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-zinc-300 font-semibold mb-1">Nilai CSS Background *</label>
                <input type="text" name="background_value" required value="linear-gradient(135deg, #111827 0%, #000000 100%)" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white font-mono focus:outline-none focus:border-sky-400">
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block text-zinc-300 font-semibold mb-1">Warna Kartu</label>
                    <input type="text" name="card_bg" value="rgba(255, 255, 255, 0.08)" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-2.5 py-1.5 text-white font-mono">
                </div>
                <div>
                    <label class="block text-zinc-300 font-semibold mb-1">Border Kartu</label>
                    <input type="text" name="card_border" value="rgba(255, 255, 255, 0.15)" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-2.5 py-1.5 text-white font-mono">
                </div>
                <div>
                    <label class="block text-zinc-300 font-semibold mb-1">Aksen Warna</label>
                    <input type="text" name="accent_color" value="#38bdf8" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-2.5 py-1.5 text-white font-mono">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-zinc-300 font-semibold mb-1">Teks Utama</label>
                    <input type="text" name="text_color" value="#ffffff" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-2.5 py-1.5 text-white font-mono">
                </div>
                <div>
                    <label class="block text-zinc-300 font-semibold mb-1">Teks Sekunder</label>
                    <input type="text" name="subtext_color" value="#9ca3af" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-2.5 py-1.5 text-white font-mono">
                </div>
            </div>

            <input type="hidden" name="card_text" value="#ffffff">

            <div class="flex justify-end gap-2 pt-3 border-t border-zinc-800">
                <button type="button" onclick="closeCustomThemeModal()" class="px-4 py-2 rounded-xl bg-zinc-800 hover:bg-zinc-700 text-zinc-300">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-sky-500 hover:bg-sky-400 text-white font-bold">Simpan & Terapkan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCustomThemeModal() {
        document.getElementById('customThemeModal').classList.remove('hidden');
    }
    function closeCustomThemeModal() {
        document.getElementById('customThemeModal').classList.add('hidden');
    }
</script>
@endsection
