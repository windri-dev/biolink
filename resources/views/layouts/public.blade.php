<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $profile->meta_title ?: $profile->display_name . ' (@' . $profile->clean_handle . ')' }}</title>
    
    <!-- Meta & OpenGraph SEO -->
    <meta name="description" content="{{ $profile->meta_description ?: $profile->bio }}">
    <meta property="og:title" content="{{ $profile->meta_title ?: $profile->display_name }}">
    <meta property="og:description" content="{{ $profile->meta_description ?: $profile->bio }}">
    <meta property="og:image" content="{{ $profile->avatar_url }}">
    <meta property="og:type" content="profile">
    <meta name="twitter:card" content="summary_large_image">
    
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
            --theme-bg: {{ $theme->background_value ?? '#0d0d11' }};
            --card-bg: {{ $theme->card_bg ?? 'rgba(255, 255, 255, 0.05)' }};
            --card-border: {{ $theme->card_border ?? 'rgba(255, 255, 255, 0.12)' }};
            --card-hover-bg: {{ $theme->card_hover_bg ?? 'rgba(255, 255, 255, 0.12)' }};
            --card-text: {{ $theme->card_text ?? '#ffffff' }};
            --text-main: {{ $theme->text_color ?? '#ffffff' }};
            --text-sub: {{ $theme->subtext_color ?? '#9ca3af' }};
            --accent: {{ $theme->accent_color ?? '#38bdf8' }};
            --font-family: {{ $theme->font_family ?? 'Plus Jakarta Sans, sans-serif' }};
        }

        body {
            font-family: var(--font-family);
            background: var(--theme-bg);
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
    
    <!-- Top Action Bar (Share Button) -->
    <header class="w-full max-w-xl mx-auto px-4 pt-4 flex justify-end items-center z-10">
        @if($profile->show_share_button)
            <button onclick="shareProfile()" class="p-2.5 rounded-full bg-white/10 hover:bg-white/20 text-white backdrop-blur-md border border-white/10 transition-all hover:scale-105" title="Bagikan Profil">
                <i data-lucide="share-2" class="w-4 h-4"></i>
            </button>
        @endif
    </header>

    <!-- Main Bio Container -->
    <main class="w-full max-w-xl mx-auto px-4 py-4 flex-grow flex flex-col items-center">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="w-full text-center py-6 text-xs text-white/40 flex flex-col items-center gap-1.5 z-0">
        <a href="{{ route('admin.login') }}" class="hover:text-white/80 transition-colors inline-flex items-center gap-1">
            <i data-lucide="shield" class="w-3.5 h-3.5"></i>
            <span>Admin Dashboard</span>
        </a>
        <p class="font-medium tracking-wide">
            Powered by <span class="text-white/70 font-bold">BioLink</span> &bull; 
            <a href="https://github.com/windri-dev/biolink" target="_blank" class="hover:text-white underline">windri-dev</a>
        </p>
    </footer>

    <!-- AI Assistant Floating Widget -->
    @if($profile->ai_assistant_enabled)
        <x-ai-widget :profile="$profile" />
    @endif

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
