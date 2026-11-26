@extends('layouts.admin')

@section('title', 'Otak AI & Konfigurasi API')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-bold text-white tracking-tight">Otak AI Assistant & Konfigurasi API</h2>
            <p class="text-xs text-zinc-400">Atur kunci API model kecerdasan buatan (OpenAI, DeepSeek, Groq, Ollama) dan kelola basis pengetahuan profil Anda.</p>
        </div>
        <button onclick="openAddKnowledgeModal()" class="px-4 py-2 rounded-xl bg-sky-500 hover:bg-sky-400 text-white text-xs font-bold transition-all shadow-lg shadow-sky-500/20 inline-flex items-center gap-1.5">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Tambah Data Pengetahuan</span>
        </button>
    </div>

    <!-- AI API Provider & Key Configuration Card -->
    <div class="bg-zinc-900/80 border border-zinc-800 rounded-3xl p-6 space-y-5 shadow-xl">
        <div class="flex items-center justify-between border-b border-zinc-800 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-sky-500 to-indigo-600 flex items-center justify-center text-white shadow-md">
                    <i data-lucide="cpu" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-white flex items-center gap-2 flex-wrap">
                        <span>Konfigurasi Engine & Kunci API AI</span>
                        <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-zinc-800 text-sky-400 border border-zinc-700 uppercase">
                            UNIVERSAL LLM
                        </span>
                        <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center gap-1 shadow-sm">
                            <i data-lucide="shield-check" class="w-3 h-3"></i>
                            <span>Anti-Spam Limit IP Aktif (Maks. 10/mnt)</span>
                        </span>
                    </h3>
                    <p class="text-xs text-zinc-400">Satu konfigurasi fleksibel untuk semua penyedia LLM (OpenAI resmi, DeepSeek, Groq, Ollama, OpenRouter, dll).</p>
                </div>
            </div>

            <!-- Active Status Badge & Quick 1-Click Toggle -->
            <form action="{{ route('admin.ai.toggle-quick') }}" method="POST" class="inline">
                @csrf
                <button type="submit" 
                        class="px-3.5 py-1.5 rounded-xl border {{ $profile->ai_assistant_enabled ? 'bg-emerald-500/10 border-emerald-500/30 text-emerald-400 hover:bg-emerald-500/20' : 'bg-zinc-800 border-zinc-700 text-zinc-400 hover:bg-zinc-700 hover:text-white' }} text-xs font-bold transition-all flex items-center gap-2 shadow-sm"
                        title="Klik untuk {{ $profile->ai_assistant_enabled ? 'menonaktifkan / menyembunyikan' : 'mengaktifkan / menampilkan' }} AI">
                    <span class="w-2.5 h-2.5 rounded-full {{ $profile->ai_assistant_enabled ? 'bg-emerald-400 animate-pulse' : 'bg-zinc-500' }}"></span>
                    <span>Widget AI: {{ $profile->ai_assistant_enabled ? 'Tampil di Bio (ON)' : 'Disembunyikan (OFF)' }}</span>
                    <span class="text-[10px] text-zinc-500 font-normal underline">(Klik Ganti)</span>
                </button>
            </form>
        </div>

        <form action="{{ route('admin.ai.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6 text-xs">
            @csrf

            <!-- 1. FIGURAN & KARAKTER KOSTUM ASISTEN AI (MASCOT PERSONA) -->
            <div class="bg-zinc-800/50 border border-zinc-700/70 rounded-2xl p-5 space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-zinc-700/50 gap-2">
                    <div>
                        <h4 class="text-xs font-bold text-white flex items-center gap-2">
                            <i data-lucide="smile" class="w-4 h-4 text-sky-400"></i>
                            <span>1. Personalisasi Figuran & Kostum Karakter AI</span>
                        </h4>
                        <p class="text-[11px] text-zinc-400 mt-0.5">Ubah avatar gambar/maskot figuran pada tombol mengambang dan jendela chat agar terlihat menarik dan tidak polos.</p>
                    </div>

                    <!-- Toggle Enable/Disable AI Widget with explicit hidden fallback -->
                    <div class="flex items-center gap-3 bg-zinc-900/90 border border-zinc-700/80 px-4 py-2 rounded-2xl shadow-inner">
                        <div>
                            <span class="text-xs font-bold text-white block">Tampilkan Widget AI di Halaman Bio</span>
                            <span class="text-[10px] text-zinc-400">Jika dimatikan, tombol mengambang AI tidak akan muncul bagi pengunjung</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer ml-auto">
                            <input type="hidden" name="ai_assistant_enabled" value="0">
                            <input type="checkbox" name="ai_assistant_enabled" value="1" {{ $profile->ai_assistant_enabled ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-zinc-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-zinc-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                        </label>
                    </div>
                </div>

                <!-- Live Preview of Floating Launcher Button (Desktop & Mobile) -->
                <div class="bg-zinc-950/60 border border-zinc-800 rounded-xl p-4 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="space-y-2">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-zinc-400 block">Pratinjau Tombol Figuran Mengambang (Bio Page):</span>
                        <div class="flex items-center gap-4 flex-wrap">
                            <!-- Desktop Preview -->
                            <div class="inline-flex items-center gap-3 pl-2.5 pr-4 py-2 bg-zinc-900/90 text-white rounded-full shadow-xl border border-sky-400/40 backdrop-blur-xl">
                                <div class="relative flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full p-0.5 bg-gradient-to-tr from-sky-400 via-indigo-500 to-pink-500 shadow-md ring-2 ring-white/10 overflow-hidden flex items-center justify-center bg-zinc-950">
                                        <img class="previewMascotImg w-full h-full object-cover rounded-full" 
                                             src="{{ $profile->ai_avatar_url ?: 'https://api.dicebear.com/7.x/bottts-neutral/svg?seed=AuraBot&backgroundColor=0284c7' }}" 
                                             alt="Preview Mascot">
                                    </div>
                                    <span class="absolute bottom-0 right-0 w-3 h-3 bg-emerald-400 rounded-full border-2 border-zinc-950 shadow-sm animate-pulse"></span>
                                </div>
                                <div class="text-left">
                                    <p class="text-xs font-bold leading-tight flex items-center gap-1.5 text-white">
                                        <span id="previewMascotName">Tanya {{ $profile->ai_assistant_name }}</span>
                                        <span class="text-[9px] font-mono uppercase px-1.5 py-0.5 rounded-full bg-sky-500/20 text-sky-300 border border-sky-400/30">AI</span>
                                    </p>
                                    <p class="text-[10px] text-zinc-400 leading-tight mt-0.5 flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                        <span>Desktop Mode</span>
                                    </p>
                                </div>
                            </div>

                            <!-- Mobile Preview (Full Image without wrapper) -->
                            <div class="flex items-center gap-2.5 bg-white/5 border border-white/10 rounded-2xl px-3 py-1.5">
                                <div class="relative flex-shrink-0">
                                    <div class="w-11 h-11 rounded-full p-0.5 bg-gradient-to-tr from-sky-400 via-indigo-500 to-pink-500 shadow-xl shadow-sky-500/30 ring-2 ring-white/20 overflow-hidden flex items-center justify-center bg-zinc-950">
                                        <img class="previewMascotImg w-full h-full object-cover rounded-full" 
                                             src="{{ $profile->ai_avatar_url ?: 'https://api.dicebear.com/7.x/bottts-neutral/svg?seed=AuraBot&backgroundColor=0284c7' }}" 
                                             alt="Preview Mascot Mobile">
                                    </div>
                                    <span class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-emerald-400 rounded-full border-2 border-zinc-950 shadow-md animate-pulse"></span>
                                </div>
                                <span class="text-[10px] text-zinc-300 font-medium">Versi Mobile (Full gambar murni)</span>
                            </div>
                        </div>
                    </div>

                    <div class="text-left md:text-right md:border-l md:border-zinc-800 md:pl-4">
                        <span class="text-[10px] text-zinc-500 block">Avatar saat ini:</span>
                        <span class="text-[11px] font-mono text-sky-400 truncate max-w-[200px] inline-block" id="currentAvatarLabel">
                            {{ $profile->ai_avatar_url ? 'Gambar Kustom / Preset' : 'Default (Aura 3D Bot)' }}
                        </span>
                        <div class="mt-1">
                            <button type="button" onclick="resetAiMascotAvatar()" class="text-[11px] text-rose-400 hover:text-rose-300 underline font-medium">
                                Reset ke Default
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Preset Figures / Mascots (1-Click Apply) -->
                <div>
                    <label class="block text-[11px] text-zinc-300 font-semibold mb-2">Pilihan Cepat Kostum Karakter Figuran (Klik 1 Kali untuk Menerapkan):</label>
                    <div class="grid grid-cols-2 sm:grid-cols-6 gap-2.5">
                        <!-- Preset 1 -->
                        <button type="button" 
                                onclick="applyMascotPreset('https://api.dicebear.com/7.x/bottts-neutral/svg?seed=AuraBot&backgroundColor=0284c7', 'Cyber Bot 3D')" 
                                class="p-2 rounded-xl bg-zinc-800/80 hover:bg-zinc-700/80 border border-zinc-700 hover:border-sky-400 text-center transition-all group">
                            <div class="w-10 h-10 mx-auto rounded-full overflow-hidden p-0.5 bg-sky-500/20 border border-sky-400/30 mb-1.5 group-hover:scale-105 transition-transform">
                                <img src="https://api.dicebear.com/7.x/bottts-neutral/svg?seed=AuraBot&backgroundColor=0284c7" alt="Cyber Bot" class="w-full h-full object-cover rounded-full">
                            </div>
                            <span class="text-[10px] font-bold text-white group-hover:text-sky-300 block leading-tight">Cyber Bot 3D</span>
                        </button>

                        <!-- Preset 2 -->
                        <button type="button" 
                                onclick="applyMascotPreset('https://api.dicebear.com/7.x/shapes/svg?seed=AuraHolo&backgroundColor=6366f1', 'Hologram Aura')" 
                                class="p-2 rounded-xl bg-zinc-800/80 hover:bg-zinc-700/80 border border-zinc-700 hover:border-sky-400 text-center transition-all group">
                            <div class="w-10 h-10 mx-auto rounded-full overflow-hidden p-0.5 bg-indigo-500/20 border border-indigo-400/30 mb-1.5 group-hover:scale-105 transition-transform">
                                <img src="https://api.dicebear.com/7.x/shapes/svg?seed=AuraHolo&backgroundColor=6366f1" alt="Hologram Aura" class="w-full h-full object-cover rounded-full">
                            </div>
                            <span class="text-[10px] font-bold text-white group-hover:text-sky-300 block leading-tight">Hologram Aura</span>
                        </button>

                        <!-- Preset 3 -->
                        <button type="button" 
                                onclick="applyMascotPreset('https://api.dicebear.com/7.x/bottts/svg?seed=AstroBuddy&backgroundColor=0ea5e9', 'Astro Companion')" 
                                class="p-2 rounded-xl bg-zinc-800/80 hover:bg-zinc-700/80 border border-zinc-700 hover:border-sky-400 text-center transition-all group">
                            <div class="w-10 h-10 mx-auto rounded-full overflow-hidden p-0.5 bg-sky-500/20 border border-sky-400/30 mb-1.5 group-hover:scale-105 transition-transform">
                                <img src="https://api.dicebear.com/7.x/bottts/svg?seed=AstroBuddy&backgroundColor=0ea5e9" alt="Astro Companion" class="w-full h-full object-cover rounded-full">
                            </div>
                            <span class="text-[10px] font-bold text-white group-hover:text-sky-300 block leading-tight">Astro Bot</span>
                        </button>

                        <!-- Preset 4 -->
                        <button type="button" 
                                onclick="applyMascotPreset('https://api.dicebear.com/7.x/micah/svg?seed=AuraGirl&backgroundColor=1e1b4b', 'Cyber Anime Girl')" 
                                class="p-2 rounded-xl bg-zinc-800/80 hover:bg-zinc-700/80 border border-zinc-700 hover:border-sky-400 text-center transition-all group">
                            <div class="w-10 h-10 mx-auto rounded-full overflow-hidden p-0.5 bg-purple-500/20 border border-purple-400/30 mb-1.5 group-hover:scale-105 transition-transform">
                                <img src="https://api.dicebear.com/7.x/micah/svg?seed=AuraGirl&backgroundColor=1e1b4b" alt="Cyber Anime" class="w-full h-full object-cover rounded-full">
                            </div>
                            <span class="text-[10px] font-bold text-white group-hover:text-sky-300 block leading-tight">Anime Assistant</span>
                        </button>

                        <!-- Preset 5 -->
                        <button type="button" 
                                onclick="applyMascotPreset('https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=150&auto=format&fit=crop&q=80', 'Neon Core Orb')" 
                                class="p-2 rounded-xl bg-zinc-800/80 hover:bg-zinc-700/80 border border-zinc-700 hover:border-sky-400 text-center transition-all group">
                            <div class="w-10 h-10 mx-auto rounded-full overflow-hidden p-0.5 bg-pink-500/20 border border-pink-400/30 mb-1.5 group-hover:scale-105 transition-transform">
                                <img src="https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=150&auto=format&fit=crop&q=80" alt="Neon Core Orb" class="w-full h-full object-cover rounded-full">
                            </div>
                            <span class="text-[10px] font-bold text-white group-hover:text-sky-300 block leading-tight">Neon Core Orb</span>
                        </button>

                        <!-- Preset 6 -->
                        <button type="button" 
                                onclick="applyMascotPreset('https://images.unsplash.com/photo-1546776310-eef45dd6d63c?w=150&auto=format&fit=crop&q=80', '3D Metal Bot')" 
                                class="p-2 rounded-xl bg-zinc-800/80 hover:bg-zinc-700/80 border border-zinc-700 hover:border-sky-400 text-center transition-all group">
                            <div class="w-10 h-10 mx-auto rounded-full overflow-hidden p-0.5 bg-amber-500/20 border border-amber-400/30 mb-1.5 group-hover:scale-105 transition-transform">
                                <img src="https://images.unsplash.com/photo-1546776310-eef45dd6d63c?w=150&auto=format&fit=crop&q=80" alt="3D Metal Bot" class="w-full h-full object-cover rounded-full">
                            </div>
                            <span class="text-[10px] font-bold text-white group-hover:text-sky-300 block leading-tight">3D Metal Bot</span>
                        </button>
                    </div>
                </div>

                <!-- Custom Avatar URL & Upload Inputs -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                    <div>
                        <label class="block text-zinc-300 font-semibold mb-1">Link URL Gambar Kostum / Figuran</label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-2.5 text-zinc-500"><i data-lucide="image" class="w-4 h-4"></i></span>
                            <input type="url" 
                                   id="aiAvatarUrlInput" 
                                   name="ai_avatar_url" 
                                   value="{{ $profile->ai_avatar_url }}" 
                                   placeholder="https://... (URL gambar maskot)" 
                                   oninput="updateAvatarPreviewFromUrl(this.value)"
                                   class="w-full bg-zinc-800 border border-zinc-700 rounded-xl py-2 pl-10 pr-3 text-white font-mono focus:outline-none focus:border-sky-400 text-xs">
                        </div>
                        <span class="text-[10px] text-zinc-500 mt-1 block">Bisa paste link gambar karakter/maskot apapun (Unsplash, Imgur, DiceBear, dsb).</span>
                    </div>

                    <div>
                        <label class="block text-zinc-300 font-semibold mb-1">Atau Upload Gambar dari Komputer / HP</label>
                        <input type="file" 
                               id="aiAvatarFileInput" 
                               name="ai_avatar_file" 
                               accept="image/png,image/jpeg,image/webp,image/svg+xml" 
                               onchange="handleAvatarFileSelect(this)"
                               class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-1.5 text-white file:mr-3 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-semibold file:bg-sky-500 file:text-white hover:file:bg-sky-400 text-xs cursor-pointer">
                        <span class="text-[10px] text-zinc-500 mt-1 block">Maksimal 5MB (Format PNG transparan atau JPG persegi disarankan).</span>
                    </div>
                </div>

                <!-- Identity Settings: Name & Greeting -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-zinc-700/40">
                    <div>
                        <label class="block text-zinc-300 font-semibold mb-1">Nama Asisten AI (Contoh: Aura, Jarvis, Luna)</label>
                        <input type="text" 
                               name="ai_assistant_name" 
                               id="aiAssistantNameInput"
                               value="{{ $profile->ai_assistant_name }}" 
                               oninput="document.getElementById('previewMascotName').innerText = 'Tanya ' + (this.value || 'Aura')"
                               placeholder="Aura" 
                               class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white font-semibold focus:outline-none focus:border-sky-400 text-xs">
                    </div>

                    <div>
                        <label class="block text-zinc-300 font-semibold mb-1">Pesan Sambutan Awal (Greeting)</label>
                        <input type="text" 
                               name="ai_greeting_message" 
                               value="{{ $profile->ai_greeting_message }}" 
                               placeholder="Halo, saya asisten AI..." 
                               class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400 text-xs">
                    </div>
                </div>
            </div>

            <!-- 2. UNIVERSAL LLM ENGINE & KUNCI API -->
            <input type="hidden" name="ai_provider" id="aiProviderInput" value="{{ $profile->ai_provider ?: 'universal' }}">

            <div class="bg-zinc-800/40 border border-zinc-700/60 rounded-2xl p-4 space-y-3">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div>
                        <span class="text-xs font-bold text-white flex items-center gap-2">
                            <i data-lucide="sparkles" class="w-4 h-4 text-sky-400"></i>
                            <span>2. Universal LLM & API Engine</span>
                        </span>
                        <p class="text-[11px] text-zinc-400 mt-0.5">Mendukung OpenAI resmi dan seluruh provider LLM OpenAI-Compatible dalam satu pengaturan.</p>
                    </div>
                    <span class="text-[10px] font-mono px-2.5 py-1 rounded-lg bg-sky-500/10 text-sky-300 border border-sky-500/20 w-fit">
                        OpenAI REST Protocol Compatible
                    </span>
                </div>

                <!-- Quick Preset Selector (1-Click Fill) -->
                <div>
                    <label class="block text-[11px] text-zinc-400 font-semibold mb-1.5">Preset Cepat Engine (Klik untuk mengisi Base URL & Model otomatis):</label>
                    <div class="grid grid-cols-2 sm:grid-cols-5 gap-2">
                        <button type="button" onclick="applyAiEnginePreset('openai')" class="p-2.5 rounded-xl bg-zinc-800 hover:bg-zinc-700 border border-zinc-700 hover:border-sky-400 text-left transition-all group">
                            <div class="flex items-center gap-1.5">
                                <span class="text-xs">⚡</span>
                                <span class="text-xs font-bold text-white group-hover:text-sky-300">OpenAI Resmi</span>
                            </div>
                            <span class="text-[10px] text-zinc-400 block truncate font-mono mt-0.5">gpt-4o-mini</span>
                        </button>
                        <button type="button" onclick="applyAiEnginePreset('deepseek')" class="p-2.5 rounded-xl bg-zinc-800 hover:bg-zinc-700 border border-zinc-700 hover:border-sky-400 text-left transition-all group">
                            <div class="flex items-center gap-1.5">
                                <span class="text-xs">🐋</span>
                                <span class="text-xs font-bold text-white group-hover:text-sky-300">DeepSeek</span>
                            </div>
                            <span class="text-[10px] text-zinc-400 block truncate font-mono mt-0.5">deepseek-chat</span>
                        </button>
                        <button type="button" onclick="applyAiEnginePreset('groq')" class="p-2.5 rounded-xl bg-zinc-800 hover:bg-zinc-700 border border-zinc-700 hover:border-sky-400 text-left transition-all group">
                            <div class="flex items-center gap-1.5">
                                <span class="text-xs">🚀</span>
                                <span class="text-xs font-bold text-white group-hover:text-sky-300">Groq (Cepat)</span>
                            </div>
                            <span class="text-[10px] text-zinc-400 block truncate font-mono mt-0.5">llama-3.3-70b</span>
                        </button>
                        <button type="button" onclick="applyAiEnginePreset('openrouter')" class="p-2.5 rounded-xl bg-zinc-800 hover:bg-zinc-700 border border-zinc-700 hover:border-sky-400 text-left transition-all group">
                            <div class="flex items-center gap-1.5">
                                <span class="text-xs">🌐</span>
                                <span class="text-xs font-bold text-white group-hover:text-sky-300">OpenRouter</span>
                            </div>
                            <span class="text-[10px] text-zinc-400 block truncate font-mono mt-0.5">multi-model</span>
                        </button>
                        <button type="button" onclick="applyAiEnginePreset('ollama')" class="p-2.5 rounded-xl bg-zinc-800 hover:bg-zinc-700 border border-zinc-700 hover:border-sky-400 text-left transition-all group">
                            <div class="flex items-center gap-1.5">
                                <span class="text-xs">🦙</span>
                                <span class="text-xs font-bold text-white group-hover:text-sky-300">Ollama Lokal</span>
                            </div>
                            <span class="text-[10px] text-zinc-400 block truncate font-mono mt-0.5">localhost:11434</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- API Credentials Section -->
            <div id="apiFieldsWrapper" class="space-y-4 pt-1">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- API Key -->
                    <div>
                        <label class="block text-zinc-300 font-semibold mb-1">API Key *</label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-2.5 text-zinc-500"><i data-lucide="key" class="w-4 h-4"></i></span>
                            <input type="password" 
                                   id="aiApiKeyInput" 
                                   name="ai_api_key" 
                                   value="{{ $profile->ai_api_key }}" 
                                   placeholder="sk-proj-..." 
                                   class="w-full bg-zinc-800 border border-zinc-700 rounded-xl py-2 pl-10 pr-10 text-white font-mono focus:outline-none focus:border-sky-400">
                            <button type="button" onclick="togglePasswordVisibility('aiApiKeyInput', this)" class="absolute right-3 top-2.5 text-zinc-400 hover:text-white">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Base URL Endpoint -->
                    <div>
                        <label class="block text-zinc-300 font-semibold mb-1">API Base URL</label>
                        <input type="url" 
                               id="aiApiBaseInput" 
                               name="ai_api_base" 
                               value="{{ $profile->ai_api_base ?: 'https://api.openai.com/v1' }}" 
                               placeholder="https://api.openai.com/v1" 
                               class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white font-mono focus:outline-none focus:border-sky-400">
                        <span class="text-[10px] text-zinc-500 mt-0.5 block">Contoh: DeepSeek: <code>https://api.deepseek.com/v1</code> &bull; Groq: <code>https://api.groq.com/openai/v1</code></span>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Model ID -->
                    <div>
                        <label class="block text-zinc-300 font-semibold mb-1">Nama Model (Model ID)</label>
                        <input type="text" 
                               id="aiModelInput" 
                               name="ai_model" 
                               value="{{ $profile->ai_model ?: 'gpt-4o-mini' }}" 
                               placeholder="gpt-4o-mini / deepseek-chat" 
                               class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white font-mono focus:outline-none focus:border-sky-400">
                    </div>

                    <!-- Temperature -->
                    <div>
                        <label class="block text-zinc-300 font-semibold mb-1">Temperature Kreativitas (0.0 - 1.5)</label>
                        <input type="number" 
                               step="0.1" 
                               min="0" 
                               max="1.5" 
                               name="ai_temperature" 
                               value="{{ $profile->ai_temperature ?? 0.7 }}" 
                               class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white font-mono focus:outline-none focus:border-sky-400">
                    </div>
                </div>

                <!-- Custom System Prompt -->
                <div>
                    <label class="block text-zinc-300 font-semibold mb-1">Kustomisasi Instruksi Sistem (System Prompt)</label>
                    <textarea name="ai_system_prompt" 
                              rows="3" 
                              placeholder="Kosongkan untuk menggunakan instruksi bawaan sistem yang otomatis memadukan seluruh data pengetahuan Anda..." 
                              class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">{{ $profile->ai_system_prompt }}</textarea>
                </div>
            </div>

            <!-- 3. KEAMANAN AI & LIMIT OBROLAN PER IP (ANTI-SPAM & FIREWALL SHIELD) -->
            <div class="bg-zinc-800/40 border border-zinc-700/60 rounded-2xl p-5 space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-zinc-700/50 gap-2">
                    <div>
                        <h4 class="text-xs font-bold text-white flex items-center gap-2">
                            <i data-lucide="shield-check" class="w-4 h-4 text-emerald-400"></i>
                            <span>3. Keamanan AI & Limit Obrolan per IP (Anti-Spam & Firewall)</span>
                        </h4>
                        <p class="text-[11px] text-zinc-400 mt-0.5">Lindungi kuota token API dari bot dan cegah serangan manipulasi prompt (Jailbreak / Prompt Injection).</p>
                    </div>

                    <span class="text-[10px] font-mono px-2.5 py-1 rounded-lg bg-emerald-500/10 text-emerald-300 border border-emerald-500/20 flex items-center gap-1.5 w-fit">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>AI Security Active</span>
                    </span>
                </div>

                <!-- Rate Limiting Controls -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-zinc-300 font-semibold mb-1">
                            Batas Pesan / Menit per IP
                        </label>
                        <div class="relative">
                            <input type="number" 
                                   name="ai_rate_limit_per_minute" 
                                   value="{{ $profile->ai_rate_limit_per_minute ?? 10 }}" 
                                   min="1" 
                                   max="120" 
                                   class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white font-mono focus:outline-none focus:border-sky-400 text-xs">
                            <span class="absolute right-3 top-2 text-[10px] text-zinc-500 font-mono">pesan/mnt</span>
                        </div>
                        <span class="text-[10px] text-zinc-500 mt-1 block">Rekomendasi: 5 - 15 pesan/menit agar tidak spam.</span>
                    </div>

                    <div>
                        <label class="block text-zinc-300 font-semibold mb-1">
                            Batas Maksimal / Jam per IP
                        </label>
                        <div class="relative">
                            <input type="number" 
                                   name="ai_rate_limit_per_hour" 
                                   value="{{ $profile->ai_rate_limit_per_hour ?? 60 }}" 
                                   min="5" 
                                   max="1000" 
                                   class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white font-mono focus:outline-none focus:border-sky-400 text-xs">
                            <span class="absolute right-3 top-2 text-[10px] text-zinc-500 font-mono">pesan/jam</span>
                        </div>
                        <span class="text-[10px] text-zinc-500 mt-1 block">Rekomendasi: 30 - 100 pesan/jam per pengunjung.</span>
                    </div>

                    <div>
                        <label class="block text-zinc-300 font-semibold mb-1">
                            Durasi Auto-Ban Cooldown
                        </label>
                        <div class="relative">
                            <input type="number" 
                                   name="ai_block_duration_minutes" 
                                   value="{{ $profile->ai_block_duration_minutes ?? 15 }}" 
                                   min="1" 
                                   max="1440" 
                                   class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white font-mono focus:outline-none focus:border-sky-400 text-xs">
                            <span class="absolute right-3 top-2 text-[10px] text-zinc-500 font-mono">menit</span>
                        </div>
                        <span class="text-[10px] text-zinc-500 mt-1 block">Waktu blokir sementara jika IP spamming terus menerus.</span>
                    </div>
                </div>

                <!-- Security Toggles -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2 border-t border-zinc-700/40">
                    <label class="flex items-start gap-3 p-3 rounded-xl bg-zinc-900/60 border border-zinc-800 hover:border-zinc-700 cursor-pointer transition-colors">
                        <input type="checkbox" 
                               name="ai_security_guard" 
                               value="1" 
                               {{ ($profile->ai_security_guard ?? true) ? 'checked' : '' }} 
                               class="mt-0.5 rounded border-zinc-700 bg-zinc-800 text-emerald-500 focus:ring-emerald-500">
                        <div>
                            <span class="text-xs font-bold text-white block">AI Firewall (Anti Prompt Injection & Jailbreak)</span>
                            <span class="text-[11px] text-zinc-400 block mt-0.5">Memblokir otomatis upaya hacking prompt ("ignore instructions", "DAN mode", "bocorkan API key", dsb).</span>
                        </div>
                    </label>

                    <label class="flex items-start gap-3 p-3 rounded-xl bg-zinc-900/60 border border-zinc-800 hover:border-zinc-700 cursor-pointer transition-colors">
                        <input type="checkbox" 
                               name="ai_content_filter" 
                               value="1" 
                               {{ ($profile->ai_content_filter ?? true) ? 'checked' : '' }} 
                               class="mt-0.5 rounded border-zinc-700 bg-zinc-800 text-emerald-500 focus:ring-emerald-500">
                        <div>
                            <span class="text-xs font-bold text-white block">Sensor Kata Kasar & Konten Pelecehan</span>
                            <span class="text-[11px] text-zinc-400 block mt-0.5">Menolak dan memberi teguran otomatis jika pengunjung mengirim kata-kata kasar atau toxic.</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Action Buttons Row -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-4 border-t border-zinc-800">
                <button type="button" 
                        id="testApiBtn"
                        onclick="testExternalApiConnection()" 
                        class="w-full sm:w-auto px-4 py-2 rounded-xl bg-zinc-800 hover:bg-zinc-700 text-zinc-300 hover:text-white border border-zinc-700 text-xs font-semibold transition-all inline-flex items-center justify-center gap-1.5 shadow-sm">
                    <i data-lucide="zap" class="w-4 h-4 text-amber-400"></i>
                    <span>Uji Koneksi API AI</span>
                </button>

                <button type="submit" class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-gradient-to-r from-sky-500 to-indigo-600 hover:from-sky-400 hover:to-indigo-500 text-white font-bold text-xs transition-all shadow-lg shadow-sky-500/20">
                    Simpan Seluruh Konfigurasi AI & Figuran
                </button>
            </div>

            <!-- Test Connection Result Notification -->
            <div id="testApiResult" class="hidden p-3 rounded-xl border text-xs"></div>
        </form>
    </div>

    <!-- Live AI Chat Simulator -->
    <div class="bg-gradient-to-r from-indigo-950/40 via-zinc-900 to-zinc-900 border border-indigo-500/30 rounded-3xl p-5 space-y-3 shadow-xl">
        <div class="flex items-center justify-between">
            <h3 class="text-xs font-bold uppercase tracking-wider text-indigo-400 flex items-center gap-2">
                <i data-lucide="terminal" class="w-4 h-4"></i>
                <span>Simulator Pengujian Respon AI Langsung</span>
            </h3>
            <span class="text-[10px] font-mono text-zinc-400 bg-zinc-800 px-2 py-0.5 rounded border border-zinc-700">Sandbox Test</span>
        </div>
        <p class="text-xs text-zinc-300">Uji langsung pertanyaan pengunjung untuk melihat bagaimana sistem AI Anda merespon berdasarkan data di bawah.</p>
        
        <div class="flex gap-2">
            <input type="text" id="simQuestionInput" placeholder="Ketik pertanyaan pengujian (contoh: apa saja proyek windri?)..." class="flex-grow bg-zinc-800 border border-zinc-700 rounded-xl px-3.5 py-2 text-xs text-white focus:outline-none focus:border-indigo-400">
            <button onclick="testAiSimulator()" id="simBtn" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold transition-colors inline-flex items-center gap-1.5">
                <i data-lucide="play" class="w-3.5 h-3.5"></i>
                <span>Uji Respon</span>
            </button>
        </div>

        <div id="simResultBox" class="p-3.5 rounded-xl bg-zinc-950/80 border border-indigo-500/20 text-xs text-zinc-200 hidden">
            <div class="flex items-center justify-between mb-1.5 text-[10px] text-zinc-400">
                <span id="simIntentBadge" class="font-bold text-indigo-400 font-mono">Matched Intent: -</span>
                <span id="simTimeBadge">Response Time: 25ms</span>
            </div>
            <p id="simResponseText" class="leading-relaxed"></p>
        </div>
    </div>

    <!-- Knowledges Table / List -->
    <div class="space-y-3">
        @forelse($knowledges as $k)
            <div class="bg-zinc-900/70 border border-zinc-800 rounded-2xl p-4 flex flex-col sm:flex-row sm:items-start justify-between gap-4 hover:border-zinc-700 transition-colors">
                <div class="space-y-1.5 min-w-0 flex-grow">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="text-[10px] font-bold uppercase font-mono px-2 py-0.5 rounded-md bg-zinc-800 text-zinc-300 border border-zinc-700">
                            {{ $k->category }}
                        </span>
                        <h4 class="font-bold text-sm text-white">{{ $k->title }}</h4>
                    </div>

                    <p class="text-xs text-zinc-300/90 leading-relaxed bg-zinc-950/50 p-3 rounded-xl border border-zinc-800/80 whitespace-pre-line">
                        {{ $k->content }}
                    </p>

                    @if($k->keywords)
                        <div class="flex items-center gap-1.5 text-[11px] text-zinc-500 pt-1">
                            <i data-lucide="key" class="w-3 h-3 text-amber-400"></i>
                            <span class="truncate">Kata Kunci: {{ $k->keywords }}</span>
                        </div>
                    @endif

                    @if($k->suggested_prompt)
                        <div class="flex items-center gap-1.5 text-[11px] text-sky-400">
                            <i data-lucide="sparkles" class="w-3 h-3"></i>
                            <span>Chip Saran: "{{ $k->suggested_prompt }}"</span>
                        </div>
                    @endif
                </div>

                <div class="flex sm:flex-col items-center gap-2 flex-shrink-0">
                    <button type="button"
                            data-knowledge="{{ json_encode($k) }}"
                            onclick="openEditKnowledgeModal(this)"
                            class="p-2 rounded-lg bg-zinc-800 hover:bg-zinc-700 text-zinc-300 hover:text-white transition-colors" title="Edit Data">
                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                    </button>

                    <form action="{{ route('admin.ai-knowledge.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Hapus data pengetahuan ini?')" class="inline">
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
                <i data-lucide="brain-circuit" class="w-8 h-8 mx-auto mb-2 opacity-50"></i>
                <p class="text-sm">Belum ada data pengetahuan AI. Tambahkan data pertama Anda!</p>
            </div>
        @endforelse
    </div>

</div>

<!-- Modal Tambah Pengetahuan -->
<div id="addKnowledgeModal" class="fixed inset-0 bg-black/75 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-zinc-900 border border-zinc-800 rounded-2xl max-w-lg w-full p-6 space-y-4 shadow-2xl">
        <div class="flex items-center justify-between border-b border-zinc-800 pb-3">
            <h3 class="text-sm font-bold text-white">Tambah Data Pengetahuan AI</h3>
            <button onclick="closeAddKnowledgeModal()" class="text-zinc-400 hover:text-white"><i data-lucide="x" class="w-4 h-4"></i></button>
        </div>

        <form action="{{ route('admin.ai-knowledge.store') }}" method="POST" class="space-y-3.5 text-xs">
            @csrf
            <div>
                <label class="block text-zinc-300 font-semibold mb-1">Kategori *</label>
                <select name="category" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
                    <option value="bio">Biografi & Profil Diri</option>
                    <option value="project">Proyek & Portofolio</option>
                    <option value="experience">Pengalaman & Tech Stack</option>
                    <option value="contact">Kontak & Jalur Kolaborasi</option>
                    <option value="faq">FAQ Umum</option>
                </select>
            </div>

            <div>
                <label class="block text-zinc-300 font-semibold mb-1">Judul Topik *</label>
                <input type="text" name="title" required placeholder="Contoh: Pengalaman Kerja & Stack" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
            </div>

            <div>
                <label class="block text-zinc-300 font-semibold mb-1">Kata Kunci Pemicu (Pisahkan dengan koma)</label>
                <input type="text" name="keywords" placeholder="proyek, karya, portofolio, buat aplikasi" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
            </div>

            <div>
                <label class="block text-zinc-300 font-semibold mb-1">Isi Fakta / Jawaban AI *</label>
                <textarea name="content" rows="4" required placeholder="Tuliskan jawaban yang akurat, santun, dan lengkap..." class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400"></textarea>
            </div>

            <div>
                <label class="block text-zinc-300 font-semibold mb-1">Chip Pertanyaan Cepat untuk Pengunjung (Opsional)</label>
                <input type="text" name="suggested_prompt" placeholder="Contoh: Apa saja proyek yang pernah dibuat?" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
            </div>

            <div class="flex justify-end gap-2 pt-3 border-t border-zinc-800">
                <button type="button" onclick="closeAddKnowledgeModal()" class="px-4 py-2 rounded-xl bg-zinc-800 hover:bg-zinc-700 text-zinc-300">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-sky-500 hover:bg-sky-400 text-white font-bold">Simpan Pengetahuan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Pengetahuan -->
<div id="editKnowledgeModal" class="fixed inset-0 bg-black/75 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-zinc-900 border border-zinc-800 rounded-2xl max-w-lg w-full p-6 space-y-4 shadow-2xl">
        <div class="flex items-center justify-between border-b border-zinc-800 pb-3">
            <h3 class="text-sm font-bold text-white">Edit Data Pengetahuan</h3>
            <button onclick="closeEditKnowledgeModal()" class="text-zinc-400 hover:text-white"><i data-lucide="x" class="w-4 h-4"></i></button>
        </div>

        <form id="editKnowledgeForm" method="POST" class="space-y-3.5 text-xs">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-zinc-300 font-semibold mb-1">Kategori *</label>
                <select id="editKCategory" name="category" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
                    <option value="bio">Biografi & Profil Diri</option>
                    <option value="project">Proyek & Portofolio</option>
                    <option value="experience">Pengalaman & Tech Stack</option>
                    <option value="contact">Kontak & Jalur Kolaborasi</option>
                    <option value="faq">FAQ Umum</option>
                </select>
            </div>

            <div>
                <label class="block text-zinc-300 font-semibold mb-1">Judul Topik *</label>
                <input type="text" id="editKTitle" name="title" required class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
            </div>

            <div>
                <label class="block text-zinc-300 font-semibold mb-1">Kata Kunci Pemicu</label>
                <input type="text" id="editKKeywords" name="keywords" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
            </div>

            <div>
                <label class="block text-zinc-300 font-semibold mb-1">Isi Fakta / Jawaban AI *</label>
                <textarea id="editKContent" name="content" rows="4" required class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400"></textarea>
            </div>

            <div>
                <label class="block text-zinc-300 font-semibold mb-1">Chip Pertanyaan Cepat</label>
                <input type="text" id="editKSuggestedPrompt" name="suggested_prompt" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
            </div>

            <div class="flex justify-end gap-2 pt-3 border-t border-zinc-800">
                <button type="button" onclick="closeEditKnowledgeModal()" class="px-4 py-2 rounded-xl bg-zinc-800 hover:bg-zinc-700 text-zinc-300">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-sky-500 hover:bg-sky-400 text-white font-bold">Perbarui</button>
            </div>
        </form>
    </div>
</div>

<script>
    function applyAiEnginePreset(type) {
        const baseInput = document.getElementById('aiApiBaseInput');
        const modelInput = document.getElementById('aiModelInput');
        const providerInput = document.getElementById('aiProviderInput');

        if (providerInput) {
            providerInput.value = type;
        }

        switch(type) {
            case 'openai':
                baseInput.value = 'https://api.openai.com/v1';
                modelInput.value = 'gpt-4o-mini';
                break;
            case 'deepseek':
                baseInput.value = 'https://api.deepseek.com/v1';
                modelInput.value = 'deepseek-chat';
                break;
            case 'groq':
                baseInput.value = 'https://api.groq.com/openai/v1';
                modelInput.value = 'llama-3.3-70b-versatile';
                break;
            case 'openrouter':
                baseInput.value = 'https://openrouter.ai/api/v1';
                modelInput.value = 'openai/gpt-4o-mini';
                break;
            case 'ollama':
                baseInput.value = 'http://localhost:11434/v1';
                modelInput.value = 'llama3';
                break;
        }
    }

    function updateAllPreviewImgs(src) {
        document.querySelectorAll('.previewMascotImg').forEach(img => img.src = src);
    }

    function applyMascotPreset(url, label) {
        document.getElementById('aiAvatarUrlInput').value = url;
        document.getElementById('aiAvatarFileInput').value = '';
        updateAllPreviewImgs(url);
        document.getElementById('currentAvatarLabel').innerText = label;
    }

    function updateAvatarPreviewFromUrl(url) {
        const defaultAvatar = 'https://api.dicebear.com/7.x/bottts-neutral/svg?seed=AuraBot&backgroundColor=0284c7';
        if (url && url.trim().length > 5) {
            updateAllPreviewImgs(url.trim());
            document.getElementById('currentAvatarLabel').innerText = 'URL Kustom';
        } else {
            updateAllPreviewImgs(defaultAvatar);
            document.getElementById('currentAvatarLabel').innerText = 'Default (Aura 3D Bot)';
        }
    }

    function handleAvatarFileSelect(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                updateAllPreviewImgs(e.target.result);
                document.getElementById('currentAvatarLabel').innerText = 'File: ' + input.files[0].name;
                document.getElementById('aiAvatarUrlInput').value = '';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function resetAiMascotAvatar() {
        const defaultAvatar = 'https://api.dicebear.com/7.x/bottts-neutral/svg?seed=AuraBot&backgroundColor=0284c7';
        document.getElementById('aiAvatarUrlInput').value = '';
        document.getElementById('aiAvatarFileInput').value = '';
        updateAllPreviewImgs(defaultAvatar);
        document.getElementById('currentAvatarLabel').innerText = 'Default (Aura 3D Bot)';
    }

    function togglePasswordVisibility(inputId, btn) {
        const input = document.getElementById(inputId);
        if (input.type === 'password') {
            input.type = 'text';
            btn.innerHTML = '<i data-lucide="eye-off" class="w-4 h-4"></i>';
        } else {
            input.type = 'password';
            btn.innerHTML = '<i data-lucide="eye" class="w-4 h-4"></i>';
        }
        lucide.createIcons();
    }

    async function testExternalApiConnection() {
        const apiKey = document.getElementById('aiApiKeyInput').value.trim();
        const apiBase = document.getElementById('aiApiBaseInput').value.trim();
        const model = document.getElementById('aiModelInput').value.trim();
        const resultBox = document.getElementById('testApiResult');
        const testBtn = document.getElementById('testApiBtn');

        if (!apiKey) {
            alert('Silakan masukkan API Key terlebih dahulu.');
            return;
        }

        testBtn.disabled = true;
        resultBox.className = 'p-3 rounded-xl border border-zinc-700 bg-zinc-800/80 text-xs text-zinc-300';
        resultBox.innerText = 'Sedang menguji koneksi ke endpoint API...';
        resultBox.classList.remove('hidden');

        try {
            const res = await fetch('{{ route("admin.ai.api.test") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    api_key: apiKey,
                    api_base: apiBase,
                    model: model
                })
            });

            const data = await res.json();
            if (data.success) {
                resultBox.className = 'p-3 rounded-xl border border-emerald-500/30 bg-emerald-500/10 text-xs text-emerald-400 font-medium';
                resultBox.innerText = data.message;
            } else {
                resultBox.className = 'p-3 rounded-xl border border-rose-500/30 bg-rose-500/10 text-xs text-rose-400 font-medium';
                resultBox.innerText = data.message;
            }
        } catch (err) {
            resultBox.className = 'p-3 rounded-xl border border-rose-500/30 bg-rose-500/10 text-xs text-rose-400 font-medium';
            resultBox.innerText = 'Koneksi gagal: ' + err.message;
        } finally {
            testBtn.disabled = false;
        }
    }

    function openAddKnowledgeModal() {
        document.getElementById('addKnowledgeModal').classList.remove('hidden');
    }
    function closeAddKnowledgeModal() {
        document.getElementById('addKnowledgeModal').classList.add('hidden');
    }

    function openEditKnowledgeModal(btn) {
        try {
            const k = JSON.parse(btn.getAttribute('data-knowledge'));
            const form = document.getElementById('editKnowledgeForm');
            form.action = `/admin/ai-knowledge/${k.id}`;

            document.getElementById('editKCategory').value = k.category || 'bio';
            document.getElementById('editKTitle').value = k.title || '';
            document.getElementById('editKKeywords').value = k.keywords || '';
            document.getElementById('editKContent').value = k.content || '';
            document.getElementById('editKSuggestedPrompt').value = k.suggested_prompt || '';

            document.getElementById('editKnowledgeModal').classList.remove('hidden');
        } catch (e) {
            console.error('Failed to parse knowledge data:', e);
        }
    }

    function closeEditKnowledgeModal() {
        document.getElementById('editKnowledgeModal').classList.add('hidden');
    }

    async function testAiSimulator() {
        const input = document.getElementById('simQuestionInput');
        const q = input.value.trim();
        if (!q) return;

        const btn = document.getElementById('simBtn');
        btn.disabled = true;

        const startTime = Date.now();

        try {
            const res = await fetch('/api/ai-chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    profile_id: {{ $profile->id }},
                    message: q,
                    session_id: 'simulator_test_' + Date.now(),
                })
            });

            const data = await res.json();
            const elapsed = Date.now() - startTime;

            const resBox = document.getElementById('simResultBox');
            resBox.classList.remove('hidden');

            document.getElementById('simIntentBadge').innerText = 'Matched: ' + (data.matched_intent || 'unknown').toUpperCase();
            document.getElementById('simTimeBadge').innerText = `Elapsed: ${elapsed}ms`;
            document.getElementById('simResponseText').innerText = data.response;
        } catch (err) {
            alert('Gagal menguji AI: ' + err.message);
        } finally {
            btn.disabled = false;
        }
    }
</script>
@endsection
