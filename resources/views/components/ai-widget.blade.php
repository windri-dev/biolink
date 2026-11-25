@props(['profile'])

<div id="aiWidgetRoot" class="fixed bottom-5 right-5 z-40 font-sans" x-data="aiWidget()">
    
    <!-- Floating Trigger Launcher Button -->
    <button id="aiLauncherBtn" 
            onclick="toggleAiChat()" 
            class="group relative flex items-center gap-2.5 px-4 py-3 bg-gradient-to-r from-sky-500 to-indigo-600 text-white rounded-full shadow-2xl shadow-sky-500/30 border border-white/20 hover:scale-105 active:scale-95 transition-all duration-300">
        
        <div class="relative w-7 h-7 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
            <i data-lucide="bot" class="w-4 h-4 text-white"></i>
            <span class="absolute -top-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-400 rounded-full border-2 border-zinc-950 animate-pulse"></span>
        </div>
        
        <div class="text-left hidden sm:block">
            <p class="text-xs font-bold leading-tight flex items-center gap-1">
                Tanya {{ $profile->ai_assistant_name }}
                <span class="text-[9px] bg-white/25 px-1.5 py-0.2 rounded font-mono">AI</span>
            </p>
            <p class="text-[10px] text-white/80 leading-none">Online & siap memandu</p>
        </div>
    </button>

    <!-- Glassmorphic AI Chat Window Modal -->
    <div id="aiChatWindow" 
         class="fixed sm:absolute bottom-0 sm:bottom-16 right-0 sm:right-0 w-full sm:w-[380px] h-[85vh] sm:h-[520px] max-h-[90vh] bg-zinc-950/95 border border-white/15 rounded-t-3xl sm:rounded-3xl shadow-2xl backdrop-blur-2xl flex flex-col overflow-hidden transition-all duration-300 transform translate-y-full opacity-0 pointer-events-none z-50">
        
        <!-- Header -->
        <div class="px-5 py-4 bg-white/5 border-b border-white/10 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-sky-400 to-indigo-600 flex items-center justify-center text-white shadow-inner">
                    <i data-lucide="sparkles" class="w-4 h-4"></i>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-white flex items-center gap-1.5">
                        {{ $profile->ai_assistant_name }}
                        <span class="text-[10px] font-medium text-emerald-400 bg-emerald-500/10 px-1.5 py-0.5 rounded-full border border-emerald-500/20">Online</span>
                    </h4>
                    <p class="text-[11px] text-zinc-400">Asisten Pintar {{ $profile->display_name }}</p>
                </div>
            </div>

            <div class="flex items-center gap-1">
                <button onclick="clearChatHistory()" class="p-1.5 rounded-lg text-zinc-400 hover:text-white hover:bg-white/10 transition-colors" title="Bersihkan Obrolan">
                    <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                </button>
                <button onclick="toggleAiChat()" class="p-1.5 rounded-lg text-zinc-400 hover:text-white hover:bg-white/10 transition-colors" title="Tutup">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        </div>

        <!-- Messages Body -->
        <div id="aiChatMessages" class="flex-grow p-4 overflow-y-auto space-y-3.5 text-xs">
            
            <!-- Welcome Bot Greeting -->
            <div class="flex items-start gap-2.5">
                <div class="w-6 h-6 rounded-full bg-sky-500/20 border border-sky-400/30 flex items-center justify-center flex-shrink-0 text-sky-400 mt-0.5">
                    <i data-lucide="bot" class="w-3.5 h-3.5"></i>
                </div>
                <div class="bg-white/10 border border-white/10 rounded-2xl rounded-tl-sm px-3.5 py-2.5 text-zinc-200 leading-relaxed max-w-[85%] shadow-sm">
                    {{ $profile->ai_greeting_message }}
                </div>
            </div>

            <!-- Dynamic Prompt Chips -->
            <div id="suggestedChipsContainer" class="pt-2">
                <p class="text-[11px] text-zinc-400 mb-2 font-medium">Pertanyaan cepat yang sering ditanyakan:</p>
                <div class="flex flex-col gap-1.5" id="chipsList">
                    <button onclick="sendPrompt(this.innerText)" class="chip-btn text-left px-3 py-1.5 rounded-xl bg-white/5 hover:bg-white/15 border border-white/10 text-sky-300 hover:text-white transition-all text-[11px] font-medium flex items-center justify-between">
                        <span>Siapa itu Windri?</span>
                        <i data-lucide="corner-down-left" class="w-3 h-3 text-white/40"></i>
                    </button>
                    <button onclick="sendPrompt(this.innerText)" class="chip-btn text-left px-3 py-1.5 rounded-xl bg-white/5 hover:bg-white/15 border border-white/10 text-sky-300 hover:text-white transition-all text-[11px] font-medium flex items-center justify-between">
                        <span>Apa saja proyek yang pernah dibuat?</span>
                        <i data-lucide="corner-down-left" class="w-3 h-3 text-white/40"></i>
                    </button>
                    <button onclick="sendPrompt(this.innerText)" class="chip-btn text-left px-3 py-1.5 rounded-xl bg-white/5 hover:bg-white/15 border border-white/10 text-sky-300 hover:text-white transition-all text-[11px] font-medium flex items-center justify-between">
                        <span>Bagaimana cara menghubungi Windri?</span>
                        <i data-lucide="corner-down-left" class="w-3 h-3 text-white/40"></i>
                    </button>
                </div>
            </div>

        </div>

        <!-- Typing Indicator (Hidden by default) -->
        <div id="aiTypingIndicator" class="px-5 py-2 bg-transparent text-[11px] text-zinc-400 flex items-center gap-2 hidden">
            <span class="inline-flex gap-1 items-center">
                <span class="w-1.5 h-1.5 bg-sky-400 rounded-full animate-bounce"></span>
                <span class="w-1.5 h-1.5 bg-sky-400 rounded-full animate-bounce [animation-delay:0.2s]"></span>
                <span class="w-1.5 h-1.5 bg-sky-400 rounded-full animate-bounce [animation-delay:0.4s]"></span>
            </span>
            <span>{{ $profile->ai_assistant_name }} sedang menyusun jawaban...</span>
        </div>

        <!-- Chat Input Form -->
        <div class="p-3 bg-white/5 border-t border-white/10 flex-shrink-0">
            <form id="aiChatForm" onsubmit="submitAiChat(event)" class="relative flex items-center">
                <input type="text" 
                       id="aiChatInput" 
                       placeholder="Ketik pertanyaan untuk {{ $profile->ai_assistant_name }}..." 
                       autocomplete="off"
                       class="w-full bg-white/10 border border-white/15 rounded-xl py-2.5 pl-3.5 pr-10 text-xs text-white placeholder-zinc-500 focus:outline-none focus:border-sky-400 focus:ring-1 focus:ring-sky-400 transition-all">
                <button type="submit" 
                        id="aiSubmitBtn"
                        class="absolute right-1.5 p-1.5 rounded-lg bg-sky-500 hover:bg-sky-400 text-white transition-colors disabled:opacity-50">
                    <i data-lucide="send" class="w-3.5 h-3.5"></i>
                </button>
            </form>
        </div>

    </div>

</div>

<script>
    let isAiChatOpen = false;
    let aiSessionId = localStorage.getItem('biolink_ai_session') || ('session_' + Math.random().toString(36).substring(2, 15));
    localStorage.setItem('biolink_ai_session', aiSessionId);

    function toggleAiChat() {
        const win = document.getElementById('aiChatWindow');
        isAiChatOpen = !isAiChatOpen;

        if (isAiChatOpen) {
            win.classList.remove('translate-y-full', 'opacity-0', 'pointer-events-none');
            win.classList.add('translate-y-0', 'opacity-100');
            setTimeout(() => document.getElementById('aiChatInput').focus(), 300);
        } else {
            win.classList.add('translate-y-full', 'opacity-0', 'pointer-events-none');
            win.classList.remove('translate-y-0', 'opacity-100');
        }
    }

    function sendPrompt(text) {
        document.getElementById('aiChatInput').value = text;
        submitAiChat(new Event('submit'));
    }

    async function submitAiChat(e) {
        e.preventDefault();
        const input = document.getElementById('aiChatInput');
        const message = input.value.trim();
        if (!message) return;

        input.value = '';
        input.focus();

        // 1. Append User Message
        appendUserMessage(message);

        // 2. Show Typing Indicator
        const indicator = document.getElementById('aiTypingIndicator');
        indicator.classList.remove('hidden');
        scrollChatToBottom();

        // Disable submit button while processing
        const submitBtn = document.getElementById('aiSubmitBtn');
        submitBtn.disabled = true;

        try {
            const res = await fetch('/api/ai-chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    profile_id: {{ $profile->id }},
                    message: message,
                    session_id: aiSessionId,
                })
            });

            const data = await res.json();
            indicator.classList.add('hidden');
            submitBtn.disabled = false;

            if (data.success) {
                appendBotTypewriter(data.response, data.suggested_prompts);
            } else {
                appendBotMessage('Maaf, terjadi kendala saat memproses jawaban. Silakan coba kembali sesaat lagi.');
            }
        } catch (err) {
            indicator.classList.add('hidden');
            submitBtn.disabled = false;
            appendBotMessage('Koneksi terputus. Pastikan koneksi internet Anda aktif.');
        }
    }

    function appendUserMessage(text) {
        const container = document.getElementById('aiChatMessages');
        const div = document.createElement('div');
        div.className = 'flex justify-end';
        div.innerHTML = `
            <div class="bg-sky-600 text-white rounded-2xl rounded-tr-sm px-3.5 py-2.5 max-w-[85%] leading-relaxed shadow-sm">
                ${escapeHtml(text)}
            </div>
        `;
        container.appendChild(div);
        scrollChatToBottom();
    }

    function appendBotTypewriter(text, suggestedPrompts = []) {
        const container = document.getElementById('aiChatMessages');
        const wrapper = document.createElement('div');
        wrapper.className = 'flex items-start gap-2.5';
        
        wrapper.innerHTML = `
            <div class="w-6 h-6 rounded-full bg-sky-500/20 border border-sky-400/30 flex items-center justify-center flex-shrink-0 text-sky-400 mt-0.5">
                <i data-lucide="bot" class="w-3.5 h-3.5"></i>
            </div>
            <div class="bg-white/10 border border-white/10 rounded-2xl rounded-tl-sm px-3.5 py-2.5 text-zinc-200 leading-relaxed max-w-[85%] shadow-sm bot-text"></div>
        `;
        container.appendChild(wrapper);
        lucide.createIcons();

        const textEl = wrapper.querySelector('.bot-text');
        const formattedHtml = formatMarkdown(text);

        // Typewriter streaming effect
        let i = 0;
        const words = formattedHtml.split(' ');
        const interval = setInterval(() => {
            if (i < words.length) {
                textEl.innerHTML = words.slice(0, i + 1).join(' ');
                scrollChatToBottom();
                i++;
            } else {
                clearInterval(interval);
                renderChips(suggestedPrompts);
            }
        }, 30);
    }

    function appendBotMessage(text) {
        const container = document.getElementById('aiChatMessages');
        const wrapper = document.createElement('div');
        wrapper.className = 'flex items-start gap-2.5';
        wrapper.innerHTML = `
            <div class="w-6 h-6 rounded-full bg-sky-500/20 border border-sky-400/30 flex items-center justify-center flex-shrink-0 text-sky-400 mt-0.5">
                <i data-lucide="bot" class="w-3.5 h-3.5"></i>
            </div>
            <div class="bg-white/10 border border-white/10 rounded-2xl rounded-tl-sm px-3.5 py-2.5 text-zinc-200 leading-relaxed max-w-[85%] shadow-sm">
                ${formatMarkdown(text)}
            </div>
        `;
        container.appendChild(wrapper);
        lucide.createIcons();
        scrollChatToBottom();
    }

    function renderChips(prompts) {
        if (!prompts || prompts.length === 0) return;
        const container = document.getElementById('aiChatMessages');
        const chipContainer = document.createElement('div');
        chipContainer.className = 'pt-1 flex flex-col gap-1.5 pl-8';
        
        prompts.forEach(p => {
            const btn = document.createElement('button');
            btn.className = 'text-left px-3 py-1.5 rounded-xl bg-white/5 hover:bg-white/15 border border-white/10 text-sky-300 hover:text-white transition-all text-[11px] font-medium flex items-center justify-between';
            btn.innerHTML = `<span>${escapeHtml(p)}</span><i data-lucide="corner-down-left" class="w-3 h-3 text-white/40"></i>`;
            btn.onclick = () => sendPrompt(p);
            chipContainer.appendChild(btn);
        });

        container.appendChild(chipContainer);
        lucide.createIcons();
        scrollChatToBottom();
    }

    function formatMarkdown(text) {
        return text
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/\*(.*?)\*/g, '<em>$1</em>')
            .replace(/\n/g, '<br>');
    }

    function escapeHtml(str) {
        return str.replace(/[&<>'"]/g, tag => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            "'": '&#39;',
            '"': '&quot;'
        }[tag] || tag));
    }

    function scrollChatToBottom() {
        const container = document.getElementById('aiChatMessages');
        container.scrollTop = container.scrollHeight;
    }

    function clearChatHistory() {
        const container = document.getElementById('aiChatMessages');
        container.innerHTML = `
            <div class="flex items-start gap-2.5">
                <div class="w-6 h-6 rounded-full bg-sky-500/20 border border-sky-400/30 flex items-center justify-center flex-shrink-0 text-sky-400 mt-0.5">
                    <i data-lucide="bot" class="w-3.5 h-3.5"></i>
                </div>
                <div class="bg-white/10 border border-white/10 rounded-2xl rounded-tl-sm px-3.5 py-2.5 text-zinc-200 leading-relaxed max-w-[85%] shadow-sm">
                    {{ $profile->ai_greeting_message }}
                </div>
            </div>
        `;
        lucide.createIcons();
    }
</script>
