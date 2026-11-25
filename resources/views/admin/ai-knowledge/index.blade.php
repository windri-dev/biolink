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
                    <h3 class="text-sm font-bold text-white flex items-center gap-2">
                        <span>Konfigurasi Engine & Kunci API AI</span>
                        <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-zinc-800 text-sky-400 border border-zinc-700 uppercase">
                            {{ $profile->ai_provider }}
                        </span>
                    </h3>
                    <p class="text-xs text-zinc-400">Pilih penyedia API yang ingin digunakan untuk mentenagai asisten obrolan di halaman bio Anda.</p>
                </div>
            </div>

            <!-- Active Status Badge -->
            <div class="flex items-center gap-1.5 text-xs">
                <span class="w-2.5 h-2.5 rounded-full {{ $profile->ai_assistant_enabled ? 'bg-emerald-400 animate-pulse' : 'bg-zinc-600' }}"></span>
                <span class="text-zinc-300 font-semibold">{{ $profile->ai_assistant_enabled ? 'Aktif' : 'Nonaktif' }}</span>
            </div>
        </div>

        <form action="{{ route('admin.ai.settings.update') }}" method="POST" class="space-y-4 text-xs">
            @csrf

            <!-- Provider Selection -->
            <div>
                <label class="block text-zinc-300 font-semibold mb-2">Penyedia AI Engine (Provider) *</label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <label class="p-3.5 rounded-2xl bg-zinc-800/40 border {{ $profile->ai_provider === 'local' ? 'border-sky-500 bg-sky-500/5' : 'border-zinc-800 hover:border-zinc-700' }} flex items-start gap-3 cursor-pointer transition-all">
                        <input type="radio" name="ai_provider" value="local" {{ $profile->ai_provider === 'local' ? 'checked' : '' }} class="mt-0.5 text-sky-500 bg-zinc-900 border-zinc-700" onchange="toggleApiFields(this.value)">
                        <div>
                            <span class="font-bold text-white block">Offline / Engine Lokal</span>
                            <span class="text-[11px] text-zinc-400">Gratis tanpa API Key. Menjawab murni dari data tabel pengetahuan di bawah.</span>
                        </div>
                    </label>

                    <label class="p-3.5 rounded-2xl bg-zinc-800/40 border {{ $profile->ai_provider === 'openai' ? 'border-sky-500 bg-sky-500/5' : 'border-zinc-800 hover:border-zinc-700' }} flex items-start gap-3 cursor-pointer transition-all">
                        <input type="radio" name="ai_provider" value="openai" {{ $profile->ai_provider === 'openai' ? 'checked' : '' }} class="mt-0.5 text-sky-500 bg-zinc-900 border-zinc-700" onchange="toggleApiFields(this.value)">
                        <div>
                            <span class="font-bold text-white block">OpenAI Resmi</span>
                            <span class="text-[11px] text-zinc-400">Menggunakan model GPT-4o / GPT-4o-mini dengan API key resmi OpenAI.</span>
                        </div>
                    </label>

                    <label class="p-3.5 rounded-2xl bg-zinc-800/40 border {{ $profile->ai_provider === 'custom' ? 'border-sky-500 bg-sky-500/5' : 'border-zinc-800 hover:border-zinc-700' }} flex items-start gap-3 cursor-pointer transition-all">
                        <input type="radio" name="ai_provider" value="custom" {{ $profile->ai_provider === 'custom' ? 'checked' : '' }} class="mt-0.5 text-sky-500 bg-zinc-900 border-zinc-700" onchange="toggleApiFields(this.value)">
                        <div>
                            <span class="font-bold text-white block">OpenAI-Compatible</span>
                            <span class="text-[11px] text-zinc-400">DeepSeek, Groq, OpenRouter, atau server Ollama lokal mandiri.</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- API Credentials Section -->
            <div id="apiFieldsWrapper" class="space-y-4 pt-2 {{ $profile->ai_provider === 'local' ? 'hidden' : '' }}">
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

            <!-- Action Buttons Row -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-3 border-t border-zinc-800">
                <button type="button" 
                        id="testApiBtn"
                        onclick="testExternalApiConnection()" 
                        class="w-full sm:w-auto px-4 py-2 rounded-xl bg-zinc-800 hover:bg-zinc-700 text-zinc-300 hover:text-white border border-zinc-700 text-xs font-semibold transition-all inline-flex items-center justify-center gap-1.5 shadow-sm">
                    <i data-lucide="zap" class="w-4 h-4 text-amber-400"></i>
                    <span>Uji Koneksi API AI</span>
                </button>

                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-sky-500 hover:bg-sky-400 text-white font-bold text-xs transition-all shadow-lg shadow-sky-500/20">
                    Simpan Konfigurasi Engine AI
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
    function toggleApiFields(val) {
        const wrapper = document.getElementById('apiFieldsWrapper');
        if (val === 'local') {
            wrapper.classList.add('hidden');
        } else {
            wrapper.classList.remove('hidden');
        }
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
