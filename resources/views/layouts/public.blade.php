<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $profile->meta_title ?: $profile->display_name . ' (@' . $profile->clean_handle . ')' }}</title>
    
    <!-- Canonical & SEO Meta -->
    <link rel="canonical" href="{{ url('/@' . $profile->clean_handle) }}">
    <meta name="description" content="{{ $profile->meta_description ?: $profile->bio }}">
    <meta name="author" content="{{ $profile->display_name }}">
    <meta property="og:title" content="{{ $profile->meta_title ?: $profile->display_name }}">
    <meta property="og:description" content="{{ $profile->meta_description ?: $profile->bio }}">
    <meta property="og:image" content="{{ $profile->avatar_url }}">
    <meta property="og:url" content="{{ url('/@' . $profile->clean_handle) }}">
    <meta property="og:type" content="profile">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $profile->display_name }}">
    <meta name="twitter:description" content="{{ $profile->bio }}">
    <meta name="twitter:image" content="{{ $profile->avatar_url }}">
    
    <!-- Schema.org JSON-LD Structured Data (Google Rich Snippets) -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "ProfilePage",
      "dateCreated": "{{ $profile->created_at->toIso8601String() }}",
      "dateModified": "{{ $profile->updated_at->toIso8601String() }}",
      "mainEntity": {
        "@@type": "Person",
        "name": "{{ $profile->display_name }}",
        "alternateName": "{{ '@' . $profile->clean_handle }}",
        "identifier": "{{ $profile->clean_handle }}",
        "description": "{{ $profile->bio }}",
        "image": "{{ $profile->avatar_url }}",
        "jobTitle": "{{ $profile->job_title ?: $profile->tagline ?: 'Software Engineer' }}",
        "url": "{{ url('/@' . $profile->clean_handle) }}"
      }
    }
    </script>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ $profile->avatar_url ?: 'https://api.iconify.design/lucide:link-2.svg' }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500;700&family=Inter:wght@400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        :root {
            --theme-bg: {!! $theme->background_value ?? '#0d0d11' !!};
            --card-bg: {!! $theme->card_bg ?? 'rgba(255, 255, 255, 0.05)' !!};
            --card-border: {!! $theme->card_border ?? 'rgba(255, 255, 255, 0.12)' !!};
            --card-hover-bg: {!! $theme->card_hover_bg ?? 'rgba(255, 255, 255, 0.12)' !!};
            --card-text: {{ $theme->card_text ?? '#ffffff' }};
            --text-main: {{ $theme->text_color ?? '#ffffff' }};
            --text-sub: {{ $theme->subtext_color ?? '#9ca3af' }};
            --accent: {{ $theme->accent_color ?? '#38bdf8' }};
            --font-family: {!! $theme->font_family ?? 'Plus Jakarta Sans, sans-serif' !!};
        }

        body {
            font-family: var(--font-family);
            background: var(--theme-bg);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: var(--text-main);
            min-height: 100vh;
            overflow-x: hidden;
            -webkit-tap-highlight-color: transparent;
        }

        .bio-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            color: var(--card-text);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .bio-card:hover {
            background: var(--card-hover-bg);
            border-color: var(--accent);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px -6px rgba(0, 0, 0, 0.35);
        }

        .bio-card:active {
            transform: scale(0.985);
        }

        /* Highlight Pulse Animation */
        @keyframes subtle-glow {
            0%, 100% { border-color: var(--card-border); box-shadow: 0 0 0px var(--accent); }
            50% { border-color: var(--accent); box-shadow: 0 0 16px -2px var(--accent); }
        }
        .anim-pulse {
            animation: subtle-glow 3s infinite ease-in-out;
        }

        /* Glassmorphism scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 99px;
        }

        {!! $profile->custom_css ?? '' !!}
    </style>
</head>
<body class="antialiased flex flex-col justify-between selection:bg-sky-500 selection:text-white">
    
    <!-- Top Action Bar (vCard, QR Code, Share Button) -->
    <header class="w-full max-w-xl mx-auto px-4 pt-4 flex justify-between items-center z-10">
        <!-- vCard Save Contact Button -->
        @if($profile->enable_vcard)
            <a href="{{ route('public.vcard', $profile->clean_handle) }}" 
               class="px-3 py-1.5 rounded-full bg-white/10 hover:bg-white/20 text-white backdrop-blur-md border border-white/10 transition-all hover:scale-105 text-xs font-semibold inline-flex items-center gap-1.5 shadow-sm"
               title="Simpan Kontak ke HP">
                <svg class="w-3.5 h-3.5 text-sky-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/>
                </svg>
                <span class="hidden sm:inline">Simpan Kontak</span>
            </a>
        @else
            <div></div>
        @endif

        <div class="flex items-center gap-2">
            <!-- QR Code Button -->
            <button onclick="openQrModal()" class="p-2 rounded-full bg-white/10 hover:bg-white/20 text-white backdrop-blur-md border border-white/10 transition-all hover:scale-105" title="Lihat QR Code">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="5" height="5" x="3" y="3" rx="1"/><rect width="5" height="5" x="16" y="3" rx="1"/><rect width="5" height="5" x="3" y="16" rx="1"/><path d="M21 16h-3a2 2 0 0 0-2 2v3"/><path d="M21 21v.01"/><path d="M12 7v3a2 2 0 0 1-2 2H7"/><path d="M3 12h.01"/><path d="M12 3h.01"/><path d="M12 16v.01"/><path d="M16 12h1"/><path d="M21 12v.01"/><path d="M12 21v-1"/>
                </svg>
            </button>

            <!-- Share Button -->
            @if($profile->show_share_button)
                <button onclick="shareProfile()" class="p-2 rounded-full bg-white/10 hover:bg-white/20 text-white backdrop-blur-md border border-white/10 transition-all hover:scale-105" title="Bagikan Profil">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" x2="15.42" y1="13.51" y2="17.49"/><line x1="15.41" x2="8.59" y1="6.51" y2="10.49"/>
                    </svg>
                </button>
            @endif
        </div>
    </header>

    <!-- Main Bio Container -->
    <main class="w-full max-w-xl mx-auto px-4 py-4 flex-grow flex flex-col items-center">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="w-full text-center py-6 text-xs text-white/40 flex flex-col items-center gap-1.5 z-0">
        <a href="{{ route('login') }}" class="hover:text-white/80 transition-colors inline-flex items-center gap-1">
            <i data-lucide="shield" class="w-3.5 h-3.5"></i>
            <span>Studio Dasbor</span>
        </a>
        <p class="font-medium tracking-wide">
            Powered by <a href="/" class="text-white/70 font-bold hover:text-white">BioLink</a> &bull; 
            <a href="https://github.com/windri-dev/biolink" target="_blank" class="hover:text-white underline">windri-dev</a>
        </p>
    </footer>

    <!-- AI Assistant Floating Widget -->
    @if($profile->ai_assistant_enabled)
        <x-ai-widget :profile="$profile" />
    @endif

    <!-- QR Code Modal Dialog -->
    <div id="qrModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-zinc-900 border border-zinc-800 rounded-3xl max-w-xs w-full p-6 text-center space-y-4 shadow-2xl">
            <div class="flex items-center justify-between pb-2 border-b border-zinc-800">
                <span class="text-xs font-bold text-white flex items-center gap-1.5">
                    <i data-lucide="qr-code" class="w-4 h-4 text-sky-400"></i>
                    <span>QR Code Profil</span>
                </span>
                <button onclick="closeQrModal()" class="text-zinc-400 hover:text-white"><i data-lucide="x" class="w-4 h-4"></i></button>
            </div>

            <div class="bg-white p-3 rounded-2xl inline-block shadow-md">
                <img id="qrImage" 
                     src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode(url('/@' . $profile->clean_handle)) }}&margin=4" 
                     alt="QR Code {{ $profile->display_name }}" 
                     class="w-48 h-48 mx-auto">
            </div>

            <div>
                <p class="text-xs font-bold text-white">{{ $profile->display_name }}</p>
                <p class="text-[11px] font-mono text-sky-400">/@ {{ $profile->clean_handle }}</p>
            </div>

            <a href="https://api.qrserver.com/v1/create-qr-code/?size=500x500&data={{ urlencode(url('/@' . $profile->clean_handle)) }}" 
               download="qr_{{ $profile->clean_handle }}.png" 
               target="_blank"
               class="w-full py-2.5 rounded-xl bg-sky-500 hover:bg-sky-400 text-white font-bold text-xs transition-all shadow-md inline-flex items-center justify-center gap-1.5">
                <i data-lucide="download" class="w-3.5 h-3.5"></i>
                <span>Unduh Gambar QR</span>
            </a>
        </div>
    </div>

    <!-- Share Toast Notification Modal -->
    <div id="shareToast" class="fixed bottom-6 left-1/2 -translate-x-1/2 bg-zinc-900 text-white px-5 py-3 rounded-full border border-white/20 shadow-2xl flex items-center gap-3 text-sm opacity-0 pointer-events-none transition-all duration-300 z-50">
        <i data-lucide="check-circle" class="w-4 h-4 text-emerald-400"></i>
        <span id="shareToastText">Tautan profil berhasil disalin!</span>
    </div>

    <script>
        lucide.createIcons();

        function shareProfile() {
            const url = window.location.href;
            if (navigator.share) {
                navigator.share({
                    title: '{{ $profile->display_name }}',
                    text: '{{ $profile->bio }}',
                    url: url,
                }).catch(() => {});
            } else {
                navigator.clipboard.writeText(url).then(() => {
                    showToast('Tautan profil disalin ke clipboard!');
                });
            }
        }

        function openQrModal() {
            document.getElementById('qrModal').classList.remove('hidden');
        }

        function closeQrModal() {
            document.getElementById('qrModal').classList.add('hidden');
        }

        function showToast(text) {
            const toast = document.getElementById('shareToast');
            const toastText = document.getElementById('shareToastText');
            toastText.textContent = text;
            toast.classList.remove('opacity-0', 'pointer-events-none');
            toast.classList.add('opacity-100');
            setTimeout(() => {
                toast.classList.add('opacity-0', 'pointer-events-none');
                toast.classList.remove('opacity-100');
            }, 3000);
        }
    </script>
</body>
</html>
