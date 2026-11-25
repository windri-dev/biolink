@props(['profile'])

@php
    $aiAvatar = $profile->ai_avatar_url ?: 'https://api.dicebear.com/7.x/bottts-neutral/svg?seed=AuraBot&backgroundColor=0284c7';
@endphp

<!-- Mobile Backdrop Dimmer -->
<div id="aiChatBackdrop" 
     onclick="toggleAiChat()" 
     class="fixed inset-0 bg-black/60 backdrop-blur-xs z-40 transition-opacity duration-300 opacity-0 pointer-events-none"></div>

<div id="aiWidgetRoot" class="fixed bottom-4 sm:bottom-6 right-4 sm:right-6 z-40 font-sans">
    
    <!-- Floating Trigger Launcher Button with Custom Figurine / Avatar -->
    <button id="aiLauncherBtn" 
            onclick="toggleAiChat()" 
            class="group relative flex items-center p-0 sm:pl-2.5 sm:pr-4 sm:py-2 sm:gap-3 bg-transparent sm:bg-zinc-900/90 sm:hover:bg-zinc-900 text-white rounded-full border-0 sm:border sm:border-sky-400/30 sm:hover:border-sky-400/60 hover:scale-105 active:scale-95 transition-all duration-300 sm:backdrop-blur-xl sm:shadow-2xl sm:shadow-sky-500/30">
        
        <!-- Figuran / Avatar Karakter AI (Full tanpa bungkus gelap di mobile) -->
        <div class="relative flex-shrink-0">
            <div class="w-[52px] h-[52px] sm:w-11 sm:h-11 rounded-full p-0.5 bg-gradient-to-tr from-sky-400 via-indigo-500 to-pink-500 shadow-2xl shadow-sky-500/40 ring-2 ring-white/20 group-hover:ring-sky-400/60 transition-all overflow-hidden flex items-center justify-center bg-zinc-950">
                <img src="{{ $aiAvatar }}" 
                     alt="{{ $profile->ai_assistant_name }}" 
                     class="w-full h-full object-cover rounded-full">
            </div>
            <!-- Online status badge -->
            <span class="absolute bottom-0 right-0 w-3.5 h-3.5 sm:w-3 sm:h-3 bg-emerald-400 rounded-full border-2 border-zinc-950 shadow-md animate-pulse"></span>
        </div>
        
        <!-- Text Label (Desktop only) -->
        <div class="text-left hidden sm:block pr-1">
            <p class="text-xs font-bold leading-tight flex items-center gap-1.5 text-white group-hover:text-sky-300 transition-colors">
                <span>Tanya {{ $profile->ai_assistant_name }}</span>
                <span class="text-[9px] font-mono uppercase px-1.5 py-0.5 rounded-full bg-sky-500/20 text-sky-300 border border-sky-400/30">AI</span>
            </p>
            <p class="text-[10px] text-zinc-400 leading-tight mt-0.5 flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                <span>Online &bull; Siap memandu</span>
            </p>
        </div>
    </button>

    <!-- Glassmorphic AI Chat Window Modal (Responsive Bottom-Sheet on Mobile) -->
    <div id="aiChatWindow" 
         class="fixed sm:absolute bottom-0 sm:bottom-16 right-0 sm:right-0 w-full sm:w-[385px] h-[60vh] sm:h-[520px] max-h-[62vh] sm:max-h-[540px] bg-zinc-950/95 border border-white/15 rounded-t-3xl sm:rounded-3xl shadow-2xl backdrop-blur-2xl flex flex-col overflow-hidden transition-all duration-300 transform translate-y-full opacity-0 pointer-events-none z-50">
        
        <!-- Mobile Sheet Handle Pill -->
        <div class="w-10 h-1 bg-white/20 rounded-full mx-auto mt-2.5 mb-1 sm:hidden flex-shrink-0 cursor-pointer" onclick="toggleAiChat()"></div>

        <!-- Header -->
        <div class="px-5 py-3 sm:py-4 bg-white/5 border-b border-white/10 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full p-0.5 bg-gradient-to-tr from-sky-400 via-indigo-500 to-pink-500 shadow-md flex-shrink-0 overflow-hidden bg-zinc-950">
                    <img src="{{ $aiAvatar }}" 
                         alt="{{ $profile->ai_assistant_name }}" 
                         class="w-full h-full object-cover rounded-full">
                </div>
                <div>
                    <h4 class="text-sm font-bold text-white flex items-center gap-1.5 leading-tight">
                        {{ $profile->ai_assistant_name }}
                        <span class="text-[10px] font-medium text-emerald-400 bg-emerald-500/10 px-1.5 py-0.5 rounded-full border border-emerald-500/20">Online</span>
                    </h4>
                    <p class="text-[11px] text-zinc-400 leading-tight">Asisten Pintar {{ $profile->display_name }}</p>
                </div>
            </div>

            <div class="flex items-center gap-1">
                <button onclick="clearChatHistory()" class="p-1.5 rounded-lg text-zinc-400 hover:text-white hover:bg-white/10 transition-colors" title="Bersihkan Obrolan">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </button>
                <button onclick="toggleAiChat()" class="p-1.5 rounded-lg text-zinc-400 hover:text-white hover:bg-white/10 transition-colors" title="Tutup">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Messages Body -->
        <div id="aiChatMessages" class="flex-grow p-4 overflow-y-auto space-y-3.5 text-xs">
            
            <!-- Welcome Bot Greeting -->
            <div class="flex items-start gap-2.5">
                <div class="w-7 h-7 rounded-full overflow-hidden flex-shrink-0 border border-sky-400/30 shadow-sm mt-0.5 bg-zinc-900">
                    <img src="{{ $aiAvatar }}" alt="Bot" class="w-full h-full object-cover rounded-full">
                </div>
                <div class="bg-white/10 border border-white/10 rounded-2xl rounded-tl-sm px-3.5 py-2.5 text-zinc-200 leading-relaxed max-w-[85%] shadow-sm">
                    {{ $profile->ai_greeting_message }}
                </div>
            </div>

            <!-- Dynamic Prompt Chips -->
            <div id="suggestedChipsContainer" class="pt-2">
                <p class="text-[11px] text-zinc-400 mb-2 font-medium">Pertanyaan cepat yang sering ditanyakan:</p>
                <div class="flex flex-col gap-1.5" id="chipsList">
                    <button onclick="sendPrompt('Siapa itu {{ $profile->display_name }}?')" class="chip-btn text-left px-3 py-2 rounded-xl bg-white/5 hover:bg-white/15 border border-white/10 text-sky-300 hover:text-white transition-all text-[11px] font-medium flex items-center justify-between">
                        <span>Siapa itu {{ $profile->display_name }}?</span>
                        <svg class="w-3.5 h-3.5 text-white/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <polyline points="9 10 4 15 9 20"></polyline>
                            <path d="M20 4v7a4 4 0 0 1-4 4H4"></path>
                        </svg>
                    </button>
                    <button onclick="sendPrompt('Apa saja proyek yang pernah dibuat?')" class="chip-btn text-left px-3 py-2 rounded-xl bg-white/5 hover:bg-white/15 border border-white/10 text-sky-300 hover:text-white transition-all text-[11px] font-medium flex items-center justify-between">
                        <span>Apa saja proyek yang pernah dibuat?</span>
                        <svg class="w-3.5 h-3.5 text-white/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <polyline points="9 10 4 15 9 20"></polyline>
                            <path d="M20 4v7a4 4 0 0 1-4 4H4"></path>
                        </svg>
                    </button>
                    <button onclick="sendPrompt('Bagaimana cara menghubungi {{ $profile->display_name }}?')" class="chip-btn text-left px-3 py-2 rounded-xl bg-white/5 hover:bg-white/15 border border-white/10 text-sky-300 hover:text-white transition-all text-[11px] font-medium flex items-center justify-between">
                        <span>Bagaimana cara menghubungi {{ $profile->display_name }}?</span>
                        <svg class="w-3.5 h-3.5 text-white/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <polyline points="9 10 4 15 9 20"></polyline>
                            <path d="M20 4v7a4 4 0 0 1-4 4H4"></path>
                        </svg>
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
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                </button>
            </form>
        </div>

    </div>

</div>

<script>
    let isAiChatOpen = false;
    let aiSessionId = localStorage.getItem('biolink_ai_session') || ('session_' + Math.random().toString(36).substring(2, 15));
    localStorage.setItem('biolink_ai_session', aiSessionId);

    const aiBotAvatarUrl = @json($aiAvatar);

    function toggleAiChat() {
        const win = document.getElementById('aiChatWindow');
        const launcher = document.getElementById('aiLauncherBtn');
        const backdrop = document.getElementById('aiChatBackdrop');
        isAiChatOpen = !isAiChatOpen;

        if (isAiChatOpen) {
            win.classList.remove('translate-y-full', 'opacity-0', 'pointer-events-none');
            win.classList.add('translate-y-0', 'opacity-100');
            
            // Hide launcher button when modal is open so it doesn't overlap
            if (launcher) {
                launcher.classList.add('opacity-0', 'pointer-events-none', 'scale-75');
            }

            // Show mobile backdrop
            if (backdrop) {
                backdrop.classList.remove('opacity-0', 'pointer-events-none');
                backdrop.classList.add('opacity-100', 'pointer-events-auto');
            }

            setTimeout(() => {
                const input = document.getElementById('aiChatInput');
                if (input && window.innerWidth >= 640) input.focus();
            }, 300);
        } else {
            win.classList.add('translate-y-full', 'opacity-0', 'pointer-events-none');
            win.classList.remove('translate-y-0', 'opacity-100');

            // Restore launcher button
            if (launcher) {
                launcher.classList.remove('opacity-0', 'pointer-events-none', 'scale-75');
            }

            // Hide mobile backdrop
            if (backdrop) {
                backdrop.classList.add('opacity-0', 'pointer-events-none');
                backdrop.classList.remove('opacity-100', 'pointer-events-auto');
            }
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
                appendBotMessage(data.message || 'Maaf, terjadi kendala saat memproses jawaban. Silakan coba kembali sesaat lagi.');
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
            <div class="w-7 h-7 rounded-full overflow-hidden flex-shrink-0 border border-sky-400/30 shadow-sm mt-0.5 bg-zinc-900">
                <img src="${aiBotAvatarUrl}" alt="Bot" class="w-full h-full object-cover rounded-full">
            </div>
            <div class="bg-white/10 border border-white/10 rounded-2xl rounded-tl-sm px-3.5 py-2.5 text-zinc-200 leading-relaxed max-w-[85%] shadow-sm bot-text"></div>
        `;
        container.appendChild(wrapper);

        const textEl = wrapper.querySelector('.bot-text');

        // Robust typewriter token-by-token effect without breaking markdown HTML tags
        const tokens = text.split(/(\s+)/);
        let currentText = '';
        let i = 0;

        const interval = setInterval(() => {
            if (i < tokens.length) {
                currentText += tokens[i];
                textEl.innerHTML = formatMarkdown(currentText);
                scrollChatToBottom();
                i++;
            } else {
                clearInterval(interval);
                textEl.innerHTML = formatMarkdown(text); // 100% full text guarantee
                scrollChatToBottom();
                renderChips(suggestedPrompts);
            }
        }, 16);
    }

    function appendBotMessage(text) {
        const container = document.getElementById('aiChatMessages');
        const wrapper = document.createElement('div');
        wrapper.className = 'flex items-start gap-2.5';
        wrapper.innerHTML = `
            <div class="w-7 h-7 rounded-full overflow-hidden flex-shrink-0 border border-sky-400/30 shadow-sm mt-0.5 bg-zinc-900">
                <img src="${aiBotAvatarUrl}" alt="Bot" class="w-full h-full object-cover rounded-full">
            </div>
            <div class="bg-white/10 border border-white/10 rounded-2xl rounded-tl-sm px-3.5 py-2.5 text-zinc-200 leading-relaxed max-w-[85%] shadow-sm">
                ${formatMarkdown(text)}
            </div>
        `;
        container.appendChild(wrapper);
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
            btn.innerHTML = `
                <span>${escapeHtml(p)}</span>
                <svg class="w-3 h-3 text-white/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <polyline points="9 10 4 15 9 20"></polyline>
                    <path d="M20 4v7a4 4 0 0 1-4 4H4"></path>
                </svg>
            `;
            btn.onclick = () => sendPrompt(p);
            chipContainer.appendChild(btn);
        });

        container.appendChild(chipContainer);
        scrollChatToBottom();
    }

    function formatMarkdown(text) {
        if (!text) return '';
        return text
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/\*\*(.*?)\*\*/g, '<strong class="text-white font-semibold">$1</strong>')
            .replace(/\*(.*?)\*/g, '<em class="text-sky-200">$1</em>')
            .replace(/^• (.*)$/gm, '<div class="flex items-start gap-1.5 my-0.5"><span class="text-sky-400 font-bold">•</span><span>$1</span></div>')
            .replace(/^- (.*)$/gm, '<div class="flex items-start gap-1.5 my-0.5"><span class="text-sky-400 font-bold">•</span><span>$1</span></div>')
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
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    }

    function clearChatHistory() {
        const container = document.getElementById('aiChatMessages');
        container.innerHTML = `
            <div class="flex items-start gap-2.5">
                <div class="w-7 h-7 rounded-full overflow-hidden flex-shrink-0 border border-sky-400/30 shadow-sm mt-0.5 bg-zinc-900">
                    <img src="${aiBotAvatarUrl}" alt="Bot" class="w-full h-full object-cover rounded-full">
                </div>
                <div class="bg-white/10 border border-white/10 rounded-2xl rounded-tl-sm px-3.5 py-2.5 text-zinc-200 leading-relaxed max-w-[85%] shadow-sm">
                    {{ $profile->ai_greeting_message }}
                </div>
            </div>
        `;
    }
</script>
