@extends('layouts.admin')

@section('title', 'Kustomisasi Tema & Tampilan')

@section('content')
@php
    $bgType = $currentTheme->background_type ?? 'gradient';
    $bgValue = $currentTheme->background_value ?? 'linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%)';
    $savedImageUrl = '';
    $savedOverlay = 50;

    // Detect if current theme has an image background
    if ($bgType === 'image' || str_contains($bgValue, 'url(')) {
        $bgType = 'image';
        if (preg_match("/url\(['\"]?([^'\")]+)['\"]?\)/", $bgValue, $mImg)) {
            $savedImageUrl = $mImg[1] ?? '';
        }
        if (preg_match("/rgba\(0,\s*0,\s*0,\s*([0-9.]+)\)/", $bgValue, $mOverlay)) {
            $savedOverlay = round(floatval($mOverlay[1]) * 100);
        }
    }

    // Detect card bg color and opacity
    $cardBgRaw = $currentTheme->card_bg ?? 'rgba(255, 255, 255, 0.08)';
    $cardOpacity = 8;
    if (preg_match("/rgba\([^,]+,[^,]+,[^,]+,\s*([0-9.]+)\)/", $cardBgRaw, $mCard)) {
        $cardOpacity = round(floatval($mCard[1]) * 100);
    }

    // Detect card border color and opacity
    $cardBorderRaw = $currentTheme->card_border ?? 'rgba(255, 255, 255, 0.15)';
    $borderOpacity = 15;
    if (preg_match("/rgba\([^,]+,[^,]+,[^,]+,\s*([0-9.]+)\)/", $cardBorderRaw, $mBorder)) {
        $borderOpacity = round(floatval($mBorder[1]) * 100);
    }
@endphp

<div class="space-y-6">

    <!-- Header & Tab Navigation -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-zinc-800">
        <div>
            <h2 class="text-xl font-extrabold text-white tracking-tight flex items-center gap-2">
                <i data-lucide="palette" class="w-5 h-5 text-sky-400"></i>
                <span>Studio Desain & Tema BioLink</span>
            </h2>
            <p class="text-xs text-zinc-400 mt-0.5">Ubah warna latar belakang, upload gambar wallpaper, bentuk tombol, dan gaya visual sesuai selera Anda.</p>
        </div>

        <!-- Mode Tab Switcher -->
        <div class="flex items-center bg-zinc-900 border border-zinc-800 rounded-xl p-1 gap-1 text-xs font-bold">
            <button type="button" onclick="switchThemeTab('customizer')" id="tabBtnCustomizer" class="px-3.5 py-1.5 rounded-lg bg-sky-500 text-white transition-all shadow-sm flex items-center gap-1.5">
                <i data-lucide="sliders" class="w-3.5 h-3.5"></i>
                <span>Editor Kustom</span>
            </button>
            <button type="button" onclick="switchThemeTab('gallery')" id="tabBtnGallery" class="px-3.5 py-1.5 rounded-lg text-zinc-400 hover:text-white transition-all flex items-center gap-1.5">
                <i data-lucide="layout-grid" class="w-3.5 h-3.5"></i>
                <span>Galeri Preset ({{ $themes->count() }})</span>
            </button>
        </div>
    </div>

    <!-- Active Theme Quick Info Banner -->
    <div class="bg-gradient-to-r from-sky-950/40 via-zinc-900 to-zinc-900 border border-sky-500/30 rounded-2xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-lg">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white shadow-md border border-white/20 flex-shrink-0 overflow-hidden relative" style="background: {!! $currentTheme->background_value ?? '#0d0d11' !!};">
                @if($bgType === 'image' && $savedImageUrl)
                    <img src="{{ $savedImageUrl }}" class="w-full h-full object-cover" alt="Preview">
                @else
                    <i data-lucide="sparkles" class="w-5 h-5 text-sky-400"></i>
                @endif
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-sky-400 bg-sky-500/10 px-2 py-0.5 rounded-full border border-sky-500/20">Tema Aktif</span>
                    <h3 class="text-sm font-extrabold text-white">{{ $currentTheme->name ?? 'Default' }}</h3>
                </div>
                <p class="text-xs text-zinc-400 font-mono mt-0.5">
                    Tipe: <span class="text-zinc-200 capitalize">{{ $bgType }}</span> &bull; 
                    Font: <span class="text-zinc-200">{{ explode(',', $currentTheme->font_family ?? 'Plus Jakarta Sans')[0] }}</span> &bull; 
                    Bentuk: <span class="text-zinc-200">{{ $currentTheme->button_shape ?? 'rounded-2xl' }}</span>
                </p>
            </div>
        </div>

        <!-- Banner Action Buttons -->
        <div class="flex items-center gap-2 flex-wrap sm:flex-nowrap">
            @if($bgType === 'image')
                <form action="{{ route('admin.themes.reset-background') }}" method="POST" onsubmit="return confirm('Hapus gambar latar belakang dan kembalikan ke gradient default?')">
                    @csrf
                    <button type="submit" class="px-3 py-2 rounded-xl bg-rose-500/20 hover:bg-rose-500/30 text-rose-300 border border-rose-500/30 text-xs font-bold transition-all inline-flex items-center gap-1.5 shadow-sm" title="Hapus gambar latar belakang aktif">
                        <i data-lucide="image-minus" class="w-3.5 h-3.5"></i>
                        <span>Hapus Gambar</span>
                    </button>
                </form>
            @endif

            <button type="button" onclick="switchThemeTab('customizer')" class="px-3 py-2 rounded-xl bg-zinc-800 hover:bg-zinc-700 text-white text-xs font-bold transition-all inline-flex items-center gap-1.5 border border-zinc-700 shadow-sm">
                <i data-lucide="sliders" class="w-3.5 h-3.5 text-sky-400"></i>
                <span>Edit di Studio</span>
            </button>

            <a href="{{ route('public.bio.at', $profile->clean_handle) }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-sky-500 hover:bg-sky-400 text-white text-xs font-bold transition-all shadow-md inline-flex items-center justify-center gap-1.5 flex-shrink-0">
                <span>Lihat Bio</span>
                <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
            </a>
        </div>
    </div>

    <!-- Main Workspace: Split-Screen Editor (7 Cols) & Live Mobile Mockup (5 Cols) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- ==================== LEFT COLUMN: WORKSPACE ==================== -->
        <div class="lg:col-span-7 space-y-6">

            <!-- TAB 1: VISUAL THEME CUSTOMIZER -->
            <div id="tabContentCustomizer" class="space-y-6">

                <form id="themeCustomizerForm" action="{{ route('admin.themes.custom') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- 1. Background Section -->
                    <div class="bg-zinc-900/80 border border-zinc-800 rounded-2xl p-5 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-white uppercase tracking-wider flex items-center gap-2">
                                <i data-lucide="image" class="w-4 h-4 text-sky-400"></i>
                                <span>1. Latar Belakang (Background)</span>
                            </span>
                            <span class="text-[11px] text-emerald-400 font-semibold flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                <span>Preview Instan Aktif</span>
                            </span>
                        </div>

                        <!-- Background Type Selector Tabs -->
                        <div>
                            <label class="block text-zinc-300 text-xs font-semibold mb-2">Pilih Jenis Latar Belakang:</label>
                            <div class="grid grid-cols-3 gap-2.5">
                                <label class="cursor-pointer">
                                    <input type="radio" name="bg_type_radio" value="gradient" onchange="setBgMode('gradient')" {{ $bgType === 'gradient' ? 'checked' : '' }} class="peer sr-only">
                                    <div class="p-3 text-center rounded-xl bg-zinc-800 border border-zinc-700 peer-checked:border-sky-400 peer-checked:bg-sky-500/10 peer-checked:text-sky-300 text-zinc-300 text-xs font-bold transition-all">
                                        <div class="w-full h-4 rounded-md bg-gradient-to-r from-sky-500 to-indigo-600 mx-auto mb-1.5 opacity-80"></div>
                                        <span>Gradient Warna</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="bg_type_radio" value="solid" onchange="setBgMode('solid')" {{ $bgType === 'solid' ? 'checked' : '' }} class="peer sr-only">
                                    <div class="p-3 text-center rounded-xl bg-zinc-800 border border-zinc-700 peer-checked:border-sky-400 peer-checked:bg-sky-500/10 peer-checked:text-sky-300 text-zinc-300 text-xs font-bold transition-all">
                                        <div class="w-full h-4 rounded-md bg-zinc-700 mx-auto mb-1.5 opacity-80"></div>
                                        <span>Warna Solid</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="bg_type_radio" value="image" onchange="setBgMode('image')" {{ $bgType === 'image' ? 'checked' : '' }} class="peer sr-only">
                                    <div class="p-3 text-center rounded-xl bg-zinc-800 border border-zinc-700 peer-checked:border-sky-400 peer-checked:bg-sky-500/10 peer-checked:text-sky-300 text-zinc-300 text-xs font-bold transition-all">
                                        <div class="w-full h-4 rounded-md border border-dashed border-current flex items-center justify-center mx-auto mb-1.5 opacity-80 text-[10px]">
                                            <i data-lucide="camera" class="w-3 h-3"></i>
                                        </div>
                                        <span>Gambar / Wallpaper</span>
                                    </div>
                                </label>
                            </div>
                            <input type="hidden" name="background_type" id="bgTypeInput" value="{{ $bgType }}">
                        </div>

                        <!-- PANEL A: GRADIENT CONTROLS -->
                        <div id="panelGradient" class="space-y-4 pt-1 {{ $bgType !== 'gradient' ? 'hidden' : '' }}">
                            <!-- Quick Presets Palette Pills -->
                            <div>
                                <label class="block text-[11px] font-semibold text-zinc-400 mb-2">Palet Gradient Populer:</label>
                                <div class="flex flex-wrap gap-2">
                                    <button type="button" onclick="applyQuickPalette('#09090b', '#18181b', 135)" class="px-2.5 py-1.5 rounded-lg text-[11px] font-semibold border border-zinc-700 bg-zinc-900 text-zinc-300 hover:border-sky-400 transition-all flex items-center gap-1.5">
                                        <span class="w-3 h-3 rounded-full bg-zinc-950 border border-zinc-700"></span>
                                        <span>Midnight Dark</span>
                                    </button>
                                    <button type="button" onclick="applyQuickPalette('#0f172a', '#1e1b4b', 135)" class="px-2.5 py-1.5 rounded-lg text-[11px] font-semibold border border-zinc-700 bg-zinc-900 text-zinc-300 hover:border-sky-400 transition-all flex items-center gap-1.5">
                                        <span class="w-3 h-3 rounded-full bg-gradient-to-r from-slate-900 to-indigo-950 border border-zinc-700"></span>
                                        <span>Indigo Night</span>
                                    </button>
                                    <button type="button" onclick="applyQuickPalette('#064e3b', '#022c22', 135)" class="px-2.5 py-1.5 rounded-lg text-[11px] font-semibold border border-zinc-700 bg-zinc-900 text-zinc-300 hover:border-sky-400 transition-all flex items-center gap-1.5">
                                        <span class="w-3 h-3 rounded-full bg-gradient-to-r from-emerald-900 to-teal-950 border border-zinc-700"></span>
                                        <span>Emerald Forest</span>
                                    </button>
                                    <button type="button" onclick="applyQuickPalette('#4c0519', '#1e1b4b', 135)" class="px-2.5 py-1.5 rounded-lg text-[11px] font-semibold border border-zinc-700 bg-zinc-900 text-zinc-300 hover:border-sky-400 transition-all flex items-center gap-1.5">
                                        <span class="w-3 h-3 rounded-full bg-gradient-to-r from-rose-950 to-indigo-950 border border-zinc-700"></span>
                                        <span>Rose Cyber</span>
                                    </button>
                                    <button type="button" onclick="applyQuickPalette('#312e81', '#581c87', 135)" class="px-2.5 py-1.5 rounded-lg text-[11px] font-semibold border border-zinc-700 bg-zinc-900 text-zinc-300 hover:border-sky-400 transition-all flex items-center gap-1.5">
                                        <span class="w-3 h-3 rounded-full bg-gradient-to-r from-indigo-900 to-purple-900 border border-zinc-700"></span>
                                        <span>Tokyo Purple</span>
                                    </button>
                                    <button type="button" onclick="applyQuickPalette('#7c2d12', '#431407', 135)" class="px-2.5 py-1.5 rounded-lg text-[11px] font-semibold border border-zinc-700 bg-zinc-900 text-zinc-300 hover:border-sky-400 transition-all flex items-center gap-1.5">
                                        <span class="w-3 h-3 rounded-full bg-gradient-to-r from-amber-900 to-orange-950 border border-zinc-700"></span>
                                        <span>Sunset Ember</span>
                                    </button>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-zinc-300 text-xs font-semibold mb-1">Warna Awal (Start)</label>
                                    <div class="flex items-center gap-2 bg-zinc-800 border border-zinc-700 rounded-xl p-1.5">
                                        <input type="color" id="bgColor1" value="#0f172a" oninput="updateLiveCustomizer()" class="w-8 h-8 rounded-lg cursor-pointer bg-transparent border-0 p-0">
                                        <input type="text" id="bgColor1Hex" value="#0f172a" onchange="syncColorInput('bgColor1', this.value)" class="w-full bg-transparent text-white font-mono text-xs focus:outline-none uppercase">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-zinc-300 text-xs font-semibold mb-1">Warna Akhir (End)</label>
                                    <div class="flex items-center gap-2 bg-zinc-800 border border-zinc-700 rounded-xl p-1.5">
                                        <input type="color" id="bgColor2" value="#1e1b4b" oninput="updateLiveCustomizer()" class="w-8 h-8 rounded-lg cursor-pointer bg-transparent border-0 p-0">
                                        <input type="text" id="bgColor2Hex" value="#1e1b4b" onchange="syncColorInput('bgColor2', this.value)" class="w-full bg-transparent text-white font-mono text-xs focus:outline-none uppercase">
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-zinc-300 text-xs font-semibold mb-1">Arah Sudut Gradient: <span id="angleValueText" class="text-sky-400 font-mono">135</span>&deg;</label>
                                <input type="range" id="gradientAngleInput" min="0" max="360" value="135" oninput="updateLiveCustomizer()" class="w-full accent-sky-400 cursor-pointer">
                            </div>
                        </div>

                        <!-- PANEL B: SOLID COLOR CONTROLS -->
                        <div id="panelSolid" class="space-y-4 pt-1 {{ $bgType !== 'solid' ? 'hidden' : '' }}">
                            <div>
                                <label class="block text-zinc-300 text-xs font-semibold mb-1">Pilih Warna Latar Belakang Solid:</label>
                                <div class="flex items-center gap-2 bg-zinc-800 border border-zinc-700 rounded-xl p-2 max-w-sm">
                                    <input type="color" id="solidColorPicker" value="{{ $bgType === 'solid' ? $bgValue : '#09090b' }}" oninput="updateLiveCustomizer()" class="w-10 h-10 rounded-lg cursor-pointer bg-transparent border-0 p-0">
                                    <input type="text" id="solidColorHex" value="{{ $bgType === 'solid' ? $bgValue : '#09090b' }}" onchange="syncColorInput('solidColorPicker', this.value)" class="w-full bg-transparent text-white font-mono text-sm focus:outline-none uppercase pl-2">
                                </div>
                            </div>
                        </div>

                        <!-- PANEL C: IMAGE / WALLPAPER CONTROLS -->
                        <div id="panelImage" class="space-y-4 pt-1 {{ $bgType !== 'image' ? 'hidden' : '' }}">

                            <!-- Active Image Quick Card & Remove Button -->
                            @if($savedImageUrl)
                                <div id="activeWallpaperBox" class="bg-zinc-800/80 border border-zinc-700/80 rounded-xl p-3 flex items-center justify-between gap-3 shadow-sm">
                                    <div class="flex items-center gap-2.5 min-w-0">
                                        <img src="{{ $savedImageUrl }}" class="w-11 h-11 rounded-lg object-cover border border-zinc-600 flex-shrink-0 shadow-md" alt="Wallpaper">
                                        <div class="min-w-0">
                                            <span class="text-[10px] font-bold text-sky-400 uppercase tracking-wide flex items-center gap-1">
                                                <i data-lucide="check-circle" class="w-3 h-3"></i>
                                                <span>Gambar Wallpaper Aktif</span>
                                            </span>
                                            <p class="text-[11px] text-zinc-300 truncate font-mono mt-0.5">{{ $savedImageUrl }}</p>
                                        </div>
                                    </div>
                                    <button type="button" onclick="removeActiveImage()" class="px-2.5 py-1.5 rounded-lg bg-rose-500/20 hover:bg-rose-500/30 text-rose-300 border border-rose-500/30 text-xs font-semibold transition-all flex items-center gap-1 flex-shrink-0 shadow-sm" title="Lepas gambar ini">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        <span>Hapus Gambar</span>
                                    </button>
                                </div>
                            @endif

                            <!-- Image Source Method Tabs -->
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 border-b border-zinc-800 pb-3">
                                <div class="grid grid-cols-2 p-1 bg-zinc-800/90 border border-zinc-700/80 rounded-xl w-full sm:w-auto sm:min-w-[280px] text-xs font-semibold">
                                    <button type="button" onclick="setImageSourceMode('url')" id="imgModeUrlBtn" class="py-1.5 px-3 rounded-lg bg-sky-500 text-white shadow-sm transition-all flex items-center justify-center gap-1.5 text-center">
                                        <i data-lucide="link" class="w-3.5 h-3.5 flex-shrink-0"></i>
                                        <span class="whitespace-nowrap">URL & Rekomendasi</span>
                                    </button>
                                    <button type="button" onclick="setImageSourceMode('upload')" id="imgModeUploadBtn" class="py-1.5 px-3 rounded-lg text-zinc-400 hover:text-white transition-all flex items-center justify-center gap-1.5 text-center">
                                        <i data-lucide="upload" class="w-3.5 h-3.5 flex-shrink-0"></i>
                                        <span class="whitespace-nowrap">Upload File</span>
                                    </button>
                                </div>

                                <button type="button" onclick="removeActiveImage()" class="px-2.5 py-1.5 rounded-lg text-rose-400 hover:text-rose-300 hover:bg-rose-500/10 text-xs font-semibold flex items-center gap-1.5 transition-colors self-start sm:self-center" title="Batal gunakan gambar dan kembali ke gradient">
                                    <i data-lucide="rotate-ccw" class="w-3.5 h-3.5 flex-shrink-0"></i>
                                    <span class="whitespace-nowrap">Reset ke Gradient</span>
                                </button>
                            </div>

                            <!-- Image URL Input & Presets (Active by default for easiest use) -->
                            <div id="imageUrlBox" class="space-y-3">
                                <div>
                                    <label class="block text-zinc-300 text-xs font-semibold mb-1.5">Link / URL Gambar Wallpaper:</label>
                                    <div class="relative">
                                        <span class="absolute left-3.5 top-2.5 text-zinc-500"><i data-lucide="link" class="w-4 h-4"></i></span>
                                        <input type="url" name="bg_image_url" id="bgImageUrlInput" value="{{ $savedImageUrl }}" placeholder="https://images.unsplash.com/... atau link gambar web Anda" oninput="previewUrlImage(this.value)" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl py-2 pl-10 pr-3 text-white text-xs placeholder-zinc-500 focus:outline-none focus:border-sky-400">
                                    </div>
                                </div>

                                <!-- Wallpaper Presets Quick Click -->
                                <div>
                                    <label class="block text-[11px] font-semibold text-zinc-400 mb-1.5">Wallpaper Rekomendasi (Klik 1 Kali untuk Menggunakan):</label>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                        <button type="button" onclick="applyWallpaperPreset('https://images.unsplash.com/photo-1519501025264-65ba15a82390?w=1000&q=80')" class="p-2 rounded-xl border border-zinc-700 bg-zinc-800/80 hover:border-sky-400 text-left transition-all flex items-center gap-2 group">
                                            <img src="https://images.unsplash.com/photo-1519501025264-65ba15a82390?w=100&q=80" class="w-8 h-8 rounded-lg object-cover flex-shrink-0" alt="Cyberpunk">
                                            <span class="text-[11px] font-semibold text-zinc-300 group-hover:text-white truncate">Neon City</span>
                                        </button>
                                        <button type="button" onclick="applyWallpaperPreset('https://images.unsplash.com/photo-1550684848-fac1c5b4e853?w=1000&q=80')" class="p-2 rounded-xl border border-zinc-700 bg-zinc-800/80 hover:border-sky-400 text-left transition-all flex items-center gap-2 group">
                                            <img src="https://images.unsplash.com/photo-1550684848-fac1c5b4e853?w=100&q=80" class="w-8 h-8 rounded-lg object-cover flex-shrink-0" alt="Dark Marble">
                                            <span class="text-[11px] font-semibold text-zinc-300 group-hover:text-white truncate">Dark Marble</span>
                                        </button>
                                        <button type="button" onclick="applyWallpaperPreset('https://images.unsplash.com/photo-1506744038136-46273834b3fb?w=1000&q=80')" class="p-2 rounded-xl border border-zinc-700 bg-zinc-800/80 hover:border-sky-400 text-left transition-all flex items-center gap-2 group">
                                            <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?w=100&q=80" class="w-8 h-8 rounded-lg object-cover flex-shrink-0" alt="Mountains">
                                            <span class="text-[11px] font-semibold text-zinc-300 group-hover:text-white truncate">Mountains</span>
                                        </button>
                                        <button type="button" onclick="applyWallpaperPreset('https://images.unsplash.com/photo-1509198397868-475647b2a1e5?w=1000&q=80')" class="p-2 rounded-xl border border-zinc-700 bg-zinc-800/80 hover:border-sky-400 text-left transition-all flex items-center gap-2 group">
                                            <img src="https://images.unsplash.com/photo-1509198397868-475647b2a1e5?w=100&q=80" class="w-8 h-8 rounded-lg object-cover flex-shrink-0" alt="Tokyo Rain">
                                            <span class="text-[11px] font-semibold text-zinc-300 group-hover:text-white truncate">Tokyo Rain</span>
                                        </button>
                                        <button type="button" onclick="applyWallpaperPreset('https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=1000&q=80')" class="p-2 rounded-xl border border-zinc-700 bg-zinc-800/80 hover:border-sky-400 text-left transition-all flex items-center gap-2 group">
                                            <img src="https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=100&q=80" class="w-8 h-8 rounded-lg object-cover flex-shrink-0" alt="Wave">
                                            <span class="text-[11px] font-semibold text-zinc-300 group-hover:text-white truncate">Fluid Wave</span>
                                        </button>
                                        <button type="button" onclick="applyWallpaperPreset('https://images.unsplash.com/photo-1534447677768-be436bb09401?w=1000&q=80')" class="p-2 rounded-xl border border-zinc-700 bg-zinc-800/80 hover:border-sky-400 text-left transition-all flex items-center gap-2 group">
                                            <img src="https://images.unsplash.com/photo-1534447677768-be436bb09401?w=100&q=80" class="w-8 h-8 rounded-lg object-cover flex-shrink-0" alt="Deep Space">
                                            <span class="text-[11px] font-semibold text-zinc-300 group-hover:text-white truncate">Deep Space</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Image Upload Box -->
                            <div id="imageUploadBox" class="hidden">
                                <label class="block text-zinc-300 text-xs font-semibold mb-1.5">Pilih File Foto dari Komputer/HP:</label>
                                <div class="border-2 border-dashed border-zinc-700 hover:border-sky-400 rounded-2xl p-5 text-center transition-colors bg-zinc-800/40">
                                    <input type="file" name="bg_image_file" id="bgImageFileInput" accept="image/*" onchange="previewUploadedImage(event)" class="hidden">
                                    <label for="bgImageFileInput" class="cursor-pointer flex flex-col items-center justify-center gap-2">
                                        <div class="w-10 h-10 rounded-full bg-sky-500/10 text-sky-400 flex items-center justify-center">
                                            <i data-lucide="upload-cloud" class="w-5 h-5"></i>
                                        </div>
                                        <span class="text-xs font-bold text-white">Klik untuk Memilih File Gambar</span>
                                        <span class="text-[11px] text-zinc-400">JPG, PNG, WEBP, GIF (Maks. 10MB)</span>
                                    </label>
                                </div>
                                <p id="uploadFileNameDisplay" class="text-[11px] text-sky-400 font-mono mt-1.5 hidden flex items-center gap-1">
                                    <i data-lucide="check" class="w-3 h-3"></i>
                                    <span id="uploadFileNameText"></span>
                                </p>
                            </div>

                            <!-- Overlay Darkness Slider -->
                            <div class="bg-zinc-800/60 border border-zinc-700/60 rounded-xl p-3 space-y-1.5">
                                <div class="flex items-center justify-between text-xs font-semibold">
                                    <span class="text-zinc-300 flex items-center gap-1.5">
                                        <i data-lucide="sun-dim" class="w-3.5 h-3.5 text-amber-400"></i>
                                        <span>Tingkat Kegelapan Lapisan Gambar (Overlay Dimmer)</span>
                                    </span>
                                    <span id="overlayPercentText" class="text-sky-400 font-mono">{{ $savedOverlay }}%</span>
                                </div>
                                <p class="text-[11px] text-zinc-400">Lapisan gelap agar teks nama dan tombol bio Anda selalu kontras dan mudah dibaca.</p>
                                <input type="range" name="bg_image_overlay" id="overlayRangeInput" min="0" max="90" value="{{ $savedOverlay }}" oninput="updateLiveCustomizer()" class="w-full accent-sky-400 cursor-pointer">
                            </div>

                        </div>

                        <!-- Final CSS background string (submitted) -->
                        <input type="hidden" name="background_value" id="finalBackgroundValue" value="{{ $bgValue }}">
                    </div>

                    <!-- 2. Button & Card Shape Section -->
                    <div class="bg-zinc-900/80 border border-zinc-800 rounded-2xl p-5 space-y-4">
                        <span class="text-xs font-bold text-white uppercase tracking-wider flex items-center gap-2">
                            <i data-lucide="square" class="w-4 h-4 text-sky-400"></i>
                            <span>2. Bentuk & Gaya Kartu Tautan (Card & Buttons)</span>
                        </span>

                        <!-- Button Shape Visual Selector -->
                        <div>
                            <label class="block text-zinc-300 text-xs font-semibold mb-2">Bentuk Sudut Tombol:</label>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                                <label class="cursor-pointer">
                                    <input type="radio" name="button_shape" value="rounded-full" onchange="updateLiveCustomizer()" {{ ($currentTheme->button_shape ?? '') === 'rounded-full' ? 'checked' : '' }} class="peer sr-only">
                                    <div class="p-3 text-center rounded-xl bg-zinc-800 border border-zinc-700 peer-checked:border-sky-400 peer-checked:bg-sky-500/10 peer-checked:text-sky-300 text-zinc-300 text-xs font-bold transition-all">
                                        <div class="w-full h-4 rounded-full border border-current mx-auto mb-1.5 opacity-60"></div>
                                        <span>Pill (Full)</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="button_shape" value="rounded-2xl" onchange="updateLiveCustomizer()" {{ ($currentTheme->button_shape ?? 'rounded-2xl') === 'rounded-2xl' ? 'checked' : '' }} class="peer sr-only">
                                    <div class="p-3 text-center rounded-xl bg-zinc-800 border border-zinc-700 peer-checked:border-sky-400 peer-checked:bg-sky-500/10 peer-checked:text-sky-300 text-zinc-300 text-xs font-bold transition-all">
                                        <div class="w-full h-4 rounded-2xl border border-current mx-auto mb-1.5 opacity-60"></div>
                                        <span>Modern (2xl)</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="button_shape" value="rounded-xl" onchange="updateLiveCustomizer()" {{ ($currentTheme->button_shape ?? '') === 'rounded-xl' ? 'checked' : '' }} class="peer sr-only">
                                    <div class="p-3 text-center rounded-xl bg-zinc-800 border border-zinc-700 peer-checked:border-sky-400 peer-checked:bg-sky-500/10 peer-checked:text-sky-300 text-zinc-300 text-xs font-bold transition-all">
                                        <div class="w-full h-4 rounded-xl border border-current mx-auto mb-1.5 opacity-60"></div>
                                        <span>Soft (xl)</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="button_shape" value="rounded-lg" onchange="updateLiveCustomizer()" {{ ($currentTheme->button_shape ?? '') === 'rounded-lg' ? 'checked' : '' }} class="peer sr-only">
                                    <div class="p-3 text-center rounded-xl bg-zinc-800 border border-zinc-700 peer-checked:border-sky-400 peer-checked:bg-sky-500/10 peer-checked:text-sky-300 text-zinc-300 text-xs font-bold transition-all">
                                        <div class="w-full h-4 rounded-lg border border-current mx-auto mb-1.5 opacity-60"></div>
                                        <span>Box (lg)</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Card Background & Border Opacity Settings -->
                        <div class="grid grid-cols-2 gap-3 pt-2">
                            <div>
                                <label class="block text-zinc-300 text-xs font-semibold mb-1">Warna Isi Kartu</label>
                                <div class="flex items-center gap-2 bg-zinc-800 border border-zinc-700 rounded-xl p-1.5">
                                    <input type="color" id="cardColorPicker" value="#ffffff" oninput="updateLiveCustomizer()" class="w-8 h-8 rounded-lg cursor-pointer bg-transparent border-0 p-0">
                                    <div class="flex-grow">
                                        <div class="flex justify-between text-[10px] text-zinc-400">
                                            <span>Transparansi</span>
                                            <span id="cardOpacityText">{{ $cardOpacity }}%</span>
                                        </div>
                                        <input type="range" id="cardOpacityInput" min="0" max="100" value="{{ $cardOpacity }}" oninput="updateLiveCustomizer()" class="w-full accent-sky-400 cursor-pointer h-1">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-zinc-300 text-xs font-semibold mb-1">Warna Garis Border</label>
                                <div class="flex items-center gap-2 bg-zinc-800 border border-zinc-700 rounded-xl p-1.5">
                                    <input type="color" id="borderColorPicker" value="#ffffff" oninput="updateLiveCustomizer()" class="w-8 h-8 rounded-lg cursor-pointer bg-transparent border-0 p-0">
                                    <div class="flex-grow">
                                        <div class="flex justify-between text-[10px] text-zinc-400">
                                            <span>Transparansi</span>
                                            <span id="borderOpacityText">{{ $borderOpacity }}%</span>
                                        </div>
                                        <input type="range" id="borderOpacityInput" min="0" max="100" value="{{ $borderOpacity }}" oninput="updateLiveCustomizer()" class="w-full accent-sky-400 cursor-pointer h-1">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="card_bg" id="finalCardBg" value="{{ $currentTheme->card_bg ?? 'rgba(255, 255, 255, 0.08)' }}">
                        <input type="hidden" name="card_border" id="finalCardBorder" value="{{ $currentTheme->card_border ?? 'rgba(255, 255, 255, 0.15)' }}">
                        <input type="hidden" name="card_hover_bg" id="finalCardHoverBg" value="{{ $currentTheme->card_hover_bg ?? 'rgba(255, 255, 255, 0.16)' }}">
                        <input type="hidden" name="card_text" value="#ffffff">
                    </div>

                    <!-- 3. Typography & Text Colors -->
                    <div class="bg-zinc-900/80 border border-zinc-800 rounded-2xl p-5 space-y-4">
                        <span class="text-xs font-bold text-white uppercase tracking-wider flex items-center gap-2">
                            <i data-lucide="type" class="w-4 h-4 text-sky-400"></i>
                            <span>3. Tipografi & Warna Teks (Text & Accents)</span>
                        </span>

                        <!-- Font Family Selection -->
                        <div>
                            <label class="block text-zinc-300 text-xs font-semibold mb-1">Gaya Huruf (Font Family):</label>
                            <select id="fontFamilySelect" name="font_family" onchange="updateLiveCustomizer()" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white text-xs focus:outline-none focus:border-sky-400 font-sans">
                                <option value="Plus Jakarta Sans, sans-serif" {{ str_contains($currentTheme->font_family ?? '', 'Jakarta') ? 'selected' : '' }}>Plus Jakarta Sans (Modern & Clean)</option>
                                <option value="Inter, sans-serif" {{ str_contains($currentTheme->font_family ?? '', 'Inter') ? 'selected' : '' }}>Inter (Minimalist Tech)</option>
                                <option value="Outfit, sans-serif" {{ str_contains($currentTheme->font_family ?? '', 'Outfit') ? 'selected' : '' }}>Outfit (Geometric Friendly)</option>
                                <option value="DM Mono, monospace" {{ str_contains($currentTheme->font_family ?? '', 'Mono') ? 'selected' : '' }}>DM Mono (Developer & Terminal)</option>
                            </select>
                        </div>

                        <!-- Text Color Pickers -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-zinc-300 text-xs font-semibold mb-1">Teks Utama (Nama)</label>
                                <div class="flex items-center gap-2 bg-zinc-800 border border-zinc-700 rounded-xl p-1.5">
                                    <input type="color" id="textColorPicker" name="text_color" value="{{ $currentTheme->text_color ?? '#ffffff' }}" oninput="updateLiveCustomizer()" class="w-8 h-8 rounded-lg cursor-pointer bg-transparent border-0 p-0">
                                    <input type="text" id="textColorHex" value="{{ $currentTheme->text_color ?? '#ffffff' }}" onchange="syncColorInput('textColorPicker', this.value)" class="w-full bg-transparent text-white font-mono text-xs focus:outline-none uppercase">
                                </div>
                            </div>
                            <div>
                                <label class="block text-zinc-300 text-xs font-semibold mb-1">Teks Subtitle (Bio)</label>
                                <div class="flex items-center gap-2 bg-zinc-800 border border-zinc-700 rounded-xl p-1.5">
                                    <input type="color" id="subtextColorPicker" name="subtext_color" value="{{ $currentTheme->subtext_color ?? '#9ca3af' }}" oninput="updateLiveCustomizer()" class="w-8 h-8 rounded-lg cursor-pointer bg-transparent border-0 p-0">
                                    <input type="text" id="subtextColorHex" value="{{ $currentTheme->subtext_color ?? '#9ca3af' }}" onchange="syncColorInput('subtextColorPicker', this.value)" class="w-full bg-transparent text-white font-mono text-xs focus:outline-none uppercase">
                                </div>
                            </div>
                            <div>
                                <label class="block text-zinc-300 text-xs font-semibold mb-1">Aksen / Highlight</label>
                                <div class="flex items-center gap-2 bg-zinc-800 border border-zinc-700 rounded-xl p-1.5">
                                    <input type="color" id="accentColorPicker" name="accent_color" value="{{ $currentTheme->accent_color ?? '#38bdf8' }}" oninput="updateLiveCustomizer()" class="w-8 h-8 rounded-lg cursor-pointer bg-transparent border-0 p-0">
                                    <input type="text" id="accentColorHex" value="{{ $currentTheme->accent_color ?? '#38bdf8' }}" onchange="syncColorInput('accentColorPicker', this.value)" class="w-full bg-transparent text-white font-mono text-xs focus:outline-none uppercase">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Save Action Bar -->
                    <div class="flex items-center justify-between pt-2">
                        <button type="button" onclick="refreshPreview()" class="px-4 py-2.5 rounded-xl bg-zinc-800 hover:bg-zinc-700 text-zinc-300 hover:text-white text-xs font-bold transition-all inline-flex items-center gap-1.5">
                            <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                            <span>Muat Ulang Preview</span>
                        </button>

                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-sky-500 hover:bg-sky-400 text-white text-xs font-bold transition-all shadow-lg shadow-sky-500/25 inline-flex items-center gap-2 hover:scale-[1.02]">
                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                            <span>Simpan & Terapkan Perubahan</span>
                        </button>
                    </div>

                </form>

            </div>

            <!-- TAB 2: GALLERY PRESET GRID -->
            <div id="tabContentGallery" class="space-y-6 hidden">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($themes as $thm)
                        @php
                            $isActive = $currentTheme?->id === $thm->id;
                        @endphp
                        <div class="bg-zinc-900/80 border {{ $isActive ? 'border-sky-500 ring-2 ring-sky-500/30' : 'border-zinc-800 hover:border-zinc-700' }} rounded-2xl overflow-hidden flex flex-col transition-all group shadow-sm">
                            
                            <!-- Theme Visual Mockup Header -->
                            <div class="h-32 p-4 flex flex-col justify-center items-center relative overflow-hidden" style="background: {!! $thm->background_value !!}; background-size: cover; background-position: center;">
                                <div class="w-40 px-3 py-2 text-center shadow-lg border text-[10px] font-bold truncate flex items-center justify-center gap-1.5 {{ $thm->button_shape }}"
                                     style="background: {{ $thm->card_bg }}; border-color: {{ $thm->card_border }}; color: {{ $thm->card_text }};">
                                    <span class="w-2 h-2 rounded-full flex-shrink-0" style="background: {{ $thm->accent_color }};"></span>
                                    <span class="truncate">Preview Tombol</span>
                                </div>

                                @if($isActive)
                                    <div class="absolute top-2.5 right-2.5 bg-sky-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-md flex items-center gap-1">
                                        <i data-lucide="check" class="w-3 h-3"></i>
                                        <span>Aktif</span>
                                    </div>
                                @endif

                                @if(!$thm->is_preset)
                                    <div class="absolute top-2.5 left-2.5 bg-sky-500/20 text-sky-300 border border-sky-500/30 text-[9px] font-bold px-1.5 py-0.5 rounded shadow-sm">
                                        Kustom Anda
                                    </div>
                                @endif
                            </div>

                            <!-- Theme Metadata & Action -->
                            <div class="p-3.5 flex-grow flex flex-col justify-between space-y-3">
                                <div>
                                    <div class="flex items-center justify-between">
                                        <h4 class="font-bold text-xs text-white truncate">{{ $thm->name }}</h4>
                                        <span class="text-[9px] font-mono text-zinc-500 uppercase flex-shrink-0">{{ $thm->background_type }}</span>
                                    </div>
                                    <p class="text-[11px] text-zinc-400 mt-0.5 truncate">{{ $thm->font_family }}</p>
                                </div>

                                <!-- Card Action Buttons -->
                                <div>
                                    @if($isActive)
                                        <div class="grid grid-cols-2 gap-2">
                                            <button disabled class="w-full py-2 rounded-xl bg-zinc-800/80 text-zinc-500 text-xs font-bold cursor-not-allowed border border-zinc-700/50 flex items-center justify-center gap-1">
                                                <i data-lucide="check" class="w-3 h-3 text-emerald-400"></i>
                                                <span>Aktif Digunakan</span>
                                            </button>
                                            <button type="button" onclick='loadThemeToCustomizer(@json($thm))' class="w-full py-2 rounded-xl bg-sky-500/20 hover:bg-sky-500/30 text-sky-300 border border-sky-500/30 text-xs font-bold transition-all flex items-center justify-center gap-1.5 shadow-sm">
                                                <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                                <span>Edit Tema</span>
                                            </button>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-1.5">
                                            <form action="{{ route('admin.themes.apply', $thm->id) }}" method="POST" class="flex-grow">
                                                @csrf
                                                <button type="submit" class="w-full py-2 rounded-xl bg-zinc-800 hover:bg-sky-500 hover:text-white text-zinc-300 text-xs font-bold transition-all border border-zinc-700/70 hover:border-sky-500 flex items-center justify-center gap-1.5">
                                                    <span>Terapkan</span>
                                                    <i data-lucide="arrow-right" class="w-3 h-3"></i>
                                                </button>
                                            </form>

                                            <!-- Edit in Studio Button -->
                                            <button type="button" onclick='loadThemeToCustomizer(@json($thm))' class="px-2.5 py-2 rounded-xl bg-zinc-800 hover:bg-zinc-700 text-zinc-300 hover:text-white text-xs font-bold transition-all border border-zinc-700 flex items-center justify-center" title="Edit tema ini di Editor Studio">
                                                <i data-lucide="sliders" class="w-3.5 h-3.5"></i>
                                            </button>

                                            <!-- Delete Button for User Custom Themes -->
                                            @if(!$thm->is_preset)
                                                <form action="{{ route('admin.themes.destroy', $thm->id) }}" method="POST" onsubmit="return confirm('Hapus tema kustom \'{{ $thm->name }}\' secara permanen?')" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2 rounded-xl bg-zinc-800 hover:bg-rose-500/20 text-zinc-400 hover:text-rose-400 border border-zinc-700 hover:border-rose-500/30 transition-all" title="Hapus Tema Kustom Ini">
                                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        <!-- ==================== RIGHT COLUMN: LIVE REALTIME MOBILE MOCKUP ==================== -->
        <div class="lg:col-span-5 hidden lg:block sticky top-24">
            <div class="bg-zinc-900/60 border border-zinc-800 rounded-3xl p-5 flex flex-col items-center shadow-xl">
                
                <div class="w-full flex items-center justify-between pb-3 border-b border-zinc-800 mb-4 text-xs">
                    <span class="font-bold text-white flex items-center gap-1.5">
                        <i data-lucide="smartphone" class="w-4 h-4 text-sky-400"></i>
                        <span>Live Mobile Preview</span>
                    </span>
                    <button type="button" onclick="refreshPreview()" class="p-1.5 rounded-lg bg-zinc-800 hover:bg-zinc-700 text-zinc-400 hover:text-white transition-colors" title="Muat Ulang Preview">
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
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Live feedback aktif saat warna / gambar diubah</span>
                </div>
            </div>
        </div>

    </div>

</div>

<script>
    let currentBgMode = "{{ $bgType }}";
    let uploadedImageDataUrl = null;

    // Tab Switcher Handler
    function switchThemeTab(tab) {
        const customizerContent = document.getElementById('tabContentCustomizer');
        const galleryContent = document.getElementById('tabContentGallery');
        const customizerBtn = document.getElementById('tabBtnCustomizer');
        const galleryBtn = document.getElementById('tabBtnGallery');

        if (tab === 'customizer') {
            customizerContent.classList.remove('hidden');
            galleryContent.classList.add('hidden');
            customizerBtn.className = 'px-3.5 py-1.5 rounded-lg bg-sky-500 text-white transition-all shadow-sm flex items-center gap-1.5';
            galleryBtn.className = 'px-3.5 py-1.5 rounded-lg text-zinc-400 hover:text-white transition-all flex items-center gap-1.5';
        } else {
            customizerContent.classList.add('hidden');
            galleryContent.classList.remove('hidden');
            galleryBtn.className = 'px-3.5 py-1.5 rounded-lg bg-sky-500 text-white transition-all shadow-sm flex items-center gap-1.5';
            customizerBtn.className = 'px-3.5 py-1.5 rounded-lg text-zinc-400 hover:text-white transition-all flex items-center gap-1.5';
        }
    }

    // Set Background Mode (gradient, solid, image)
    function setBgMode(mode) {
        currentBgMode = mode;
        document.getElementById('bgTypeInput').value = mode;

        document.getElementById('panelGradient').classList.toggle('hidden', mode !== 'gradient');
        document.getElementById('panelSolid').classList.toggle('hidden', mode !== 'solid');
        document.getElementById('panelImage').classList.toggle('hidden', mode !== 'image');

        updateLiveCustomizer();
    }

    // Image Source Mode (upload or url)
    function setImageSourceMode(source) {
        const uploadBox = document.getElementById('imageUploadBox');
        const urlBox = document.getElementById('imageUrlBox');
        const uploadBtn = document.getElementById('imgModeUploadBtn');
        const urlBtn = document.getElementById('imgModeUrlBtn');

        if (source === 'upload') {
            uploadBox.classList.remove('hidden');
            urlBox.classList.add('hidden');
            uploadBtn.className = 'py-1.5 px-3 rounded-lg bg-sky-500 text-white shadow-sm transition-all flex items-center justify-center gap-1.5 text-center';
            urlBtn.className = 'py-1.5 px-3 rounded-lg text-zinc-400 hover:text-white transition-all flex items-center justify-center gap-1.5 text-center';
        } else {
            uploadBox.classList.add('hidden');
            urlBox.classList.remove('hidden');
            urlBtn.className = 'py-1.5 px-3 rounded-lg bg-sky-500 text-white shadow-sm transition-all flex items-center justify-center gap-1.5 text-center';
            uploadBtn.className = 'py-1.5 px-3 rounded-lg text-zinc-400 hover:text-white transition-all flex items-center justify-center gap-1.5 text-center';
        }
    }

    // Remove Active Background Image and Revert to Gradient
    function removeActiveImage() {
        // Clear inputs
        document.getElementById('bgImageUrlInput').value = '';
        const fileInput = document.getElementById('bgImageFileInput');
        if (fileInput) fileInput.value = '';
        const fileNameEl = document.getElementById('uploadFileNameDisplay');
        if (fileNameEl) fileNameEl.classList.add('hidden');
        const activeBox = document.getElementById('activeWallpaperBox');
        if (activeBox) activeBox.classList.add('hidden');

        uploadedImageDataUrl = null;

        // Switch back to Gradient
        setBgMode('gradient');
        const gradientRadio = document.querySelector('input[name="bg_type_radio"][value="gradient"]');
        if (gradientRadio) gradientRadio.checked = true;

        updateLiveCustomizer();
    }

    // Load any theme into the Visual Customizer Editor
    function loadThemeToCustomizer(thm) {
        // 1. Background
        const bgVal = thm.background_value || '';
        if (thm.background_type === 'image' || bgVal.includes('url(')) {
            setBgMode('image');
            const imgRadio = document.querySelector('input[name="bg_type_radio"][value="image"]');
            if (imgRadio) imgRadio.checked = true;

            const match = bgVal.match(/url\(['"]?([^'")]+)['"]?\)/);
            if (match && match[1]) {
                document.getElementById('bgImageUrlInput').value = match[1];
                setImageSourceMode('url');
            }
        } else if (thm.background_type === 'solid') {
            setBgMode('solid');
            const solidRadio = document.querySelector('input[name="bg_type_radio"][value="solid"]');
            if (solidRadio) solidRadio.checked = true;
            document.getElementById('solidColorPicker').value = bgVal.startsWith('#') ? bgVal : '#09090b';
            document.getElementById('solidColorHex').value = bgVal;
        } else {
            setBgMode('gradient');
            const gradRadio = document.querySelector('input[name="bg_type_radio"][value="gradient"]');
            if (gradRadio) gradRadio.checked = true;
        }

        // 2. Colors & Typography
        if (thm.text_color) {
            document.getElementById('textColorPicker').value = thm.text_color;
            document.getElementById('textColorHex').value = thm.text_color;
        }
        if (thm.subtext_color) {
            document.getElementById('subtextColorPicker').value = thm.subtext_color;
            document.getElementById('subtextColorHex').value = thm.subtext_color;
        }
        if (thm.accent_color) {
            document.getElementById('accentColorPicker').value = thm.accent_color;
            document.getElementById('accentColorHex').value = thm.accent_color;
        }

        // 3. Font
        if (thm.font_family) {
            const fontSelect = document.getElementById('fontFamilySelect');
            for (let opt of fontSelect.options) {
                if (opt.value.includes(thm.font_family.split(',')[0].trim())) {
                    opt.selected = true;
                    break;
                }
            }
        }

        // 4. Button shape
        if (thm.button_shape) {
            const shapeRadio = document.querySelector(`input[name="button_shape"][value="${thm.button_shape}"]`);
            if (shapeRadio) shapeRadio.checked = true;
        }

        // Switch to Customizer tab and update preview
        switchThemeTab('customizer');
        updateLiveCustomizer();
        window.scrollTo({ top: 120, behavior: 'smooth' });
    }

    // Preview Uploaded Image via FileReader
    function previewUploadedImage(event) {
        const file = event.target.files[0];
        if (file) {
            document.getElementById('uploadFileNameDisplay').classList.remove('hidden');
            document.getElementById('uploadFileNameText').textContent = file.name;

            const reader = new FileReader();
            reader.onload = function(e) {
                uploadedImageDataUrl = e.target.result;
                setBgMode('image');
                document.querySelector('input[name="bg_type_radio"][value="image"]').checked = true;
                updateLiveCustomizer();
            };
            reader.readAsDataURL(file);
        }
    }

    // Preview URL Image
    function previewUrlImage(url) {
        uploadedImageDataUrl = null;
        setBgMode('image');
        document.querySelector('input[name="bg_type_radio"][value="image"]').checked = true;
        updateLiveCustomizer();
    }

    // Apply Wallpaper Preset
    function applyWallpaperPreset(url) {
        setBgMode('image');
        document.querySelector('input[name="bg_type_radio"][value="image"]').checked = true;
        document.getElementById('bgTypeInput').value = 'image';
        setImageSourceMode('url');
        document.getElementById('bgImageUrlInput').value = url;
        uploadedImageDataUrl = null;
        updateLiveCustomizer();
    }

    // Hex to RGBA Helper
    function hexToRgba(hex, opacityPercent) {
        hex = hex.replace('#', '');
        if (hex.length === 3) {
            hex = hex.split('').map(c => c + c).join('');
        }
        const r = parseInt(hex.substring(0, 2), 16) || 0;
        const g = parseInt(hex.substring(2, 4), 16) || 0;
        const b = parseInt(hex.substring(4, 6), 16) || 0;
        const a = (opacityPercent / 100).toFixed(2);
        return `rgba(${r}, ${g}, ${b}, ${a})`;
    }

    // Sync input text hex to color picker
    function syncColorInput(pickerId, hexValue) {
        if (/^#[0-9A-Fa-f]{6}$/.test(hexValue)) {
            document.getElementById(pickerId).value = hexValue;
            updateLiveCustomizer();
        }
    }

    // Quick Palette Click
    function applyQuickPalette(color1, color2, angle = 135) {
        setBgMode('gradient');
        document.querySelector('input[name="bg_type_radio"][value="gradient"]').checked = true;
        document.getElementById('bgColor1').value = color1;
        document.getElementById('bgColor1Hex').value = color1;
        document.getElementById('bgColor2').value = color2;
        document.getElementById('bgColor2Hex').value = color2;
        document.getElementById('gradientAngleInput').value = angle;
        updateLiveCustomizer();
    }

    // Real-Time Live Preview CSS Injection
    function updateLiveCustomizer() {
        let bgValue = '';

        if (currentBgMode === 'solid') {
            const solidColor = document.getElementById('solidColorPicker').value;
            document.getElementById('solidColorHex').value = solidColor;
            bgValue = solidColor;
        } else if (currentBgMode === 'image') {
            const overlayPercent = parseInt(document.getElementById('overlayRangeInput').value);
            document.getElementById('overlayPercentText').textContent = overlayPercent + '%';
            const overlayAlpha = (overlayPercent / 100).toFixed(2);
            const overlayCss = `linear-gradient(rgba(0, 0, 0, ${overlayAlpha}), rgba(0, 0, 0, ${overlayAlpha}))`;

            const imgUrl = uploadedImageDataUrl || document.getElementById('bgImageUrlInput').value;
            if (imgUrl) {
                bgValue = `${overlayCss}, url('${imgUrl}')`;
            } else {
                bgValue = `${overlayCss}, #09090b`;
            }
        } else {
            // Gradient
            const color1 = document.getElementById('bgColor1').value;
            const color2 = document.getElementById('bgColor2').value;
            const angle = document.getElementById('gradientAngleInput').value;
            document.getElementById('angleValueText').textContent = angle;
            document.getElementById('bgColor1Hex').value = color1;
            document.getElementById('bgColor2Hex').value = color2;

            bgValue = `linear-gradient(${angle}deg, ${color1} 0%, ${color2} 100%)`;
        }

        document.getElementById('finalBackgroundValue').value = bgValue;

        // Card Colors
        const cardColor = document.getElementById('cardColorPicker').value;
        const cardOpacity = parseInt(document.getElementById('cardOpacityInput').value);
        document.getElementById('cardOpacityText').textContent = cardOpacity + '%';
        const cardBg = hexToRgba(cardColor, cardOpacity);
        const cardHoverBg = hexToRgba(cardColor, Math.min(cardOpacity + 8, 100));
        document.getElementById('finalCardBg').value = cardBg;
        document.getElementById('finalCardHoverBg').value = cardHoverBg;

        // Border Colors
        const borderColor = document.getElementById('borderColorPicker').value;
        const borderOpacity = parseInt(document.getElementById('borderOpacityInput').value);
        document.getElementById('borderOpacityText').textContent = borderOpacity + '%';
        const cardBorder = hexToRgba(borderColor, borderOpacity);
        document.getElementById('finalCardBorder').value = cardBorder;

        // Typography & Accents
        const textColor = document.getElementById('textColorPicker').value;
        const subtextColor = document.getElementById('subtextColorPicker').value;
        const accentColor = document.getElementById('accentColorPicker').value;
        document.getElementById('textColorHex').value = textColor;
        document.getElementById('subtextColorHex').value = subtextColor;
        document.getElementById('accentColorHex').value = accentColor;

        const fontFamily = document.getElementById('fontFamilySelect').value;
        const selectedShapeEl = document.querySelector('input[name="button_shape"]:checked');
        const buttonShape = selectedShapeEl ? selectedShapeEl.value : 'rounded-2xl';

        // Direct CSS Variable Injection into Smartphone Iframe (0ms instant feedback)
        try {
            const iframe = document.getElementById('previewIframe');
            if (iframe && iframe.contentDocument) {
                const doc = iframe.contentDocument;
                const root = doc.documentElement;
                root.style.setProperty('--theme-bg', bgValue);
                root.style.setProperty('--card-bg', cardBg);
                root.style.setProperty('--card-border', cardBorder);
                root.style.setProperty('--card-hover-bg', cardHoverBg);
                root.style.setProperty('--text-main', textColor);
                root.style.setProperty('--text-sub', subtextColor);
                root.style.setProperty('--accent', accentColor);
                root.style.setProperty('--font-family', fontFamily);

                // Update shape class on cards inside iframe
                const cards = doc.querySelectorAll('.bio-card');
                cards.forEach(card => {
                    card.classList.remove('rounded-full', 'rounded-2xl', 'rounded-xl', 'rounded-lg', 'rounded-none');
                    card.classList.add(buttonShape);
                });
            }
        } catch (e) {
            // Cross-origin fallback
        }
    }

    function refreshPreview() {
        const iframe = document.getElementById('previewIframe');
        if (iframe) iframe.src = iframe.src;
    }
</script>
@endsection
