<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curriculum Vitae • {{ $profile->display_name }} ({{ $profile->cv_headline ?: $profile->tagline ?: 'Professional Resume' }})</title>

    <!-- SEO & Metadata -->
    <meta name="description" content="Curriculum Vitae resmi {{ $profile->display_name }} - {{ $profile->cv_headline ?: $profile->tagline }}. {{ Str::limit($profile->cv_summary ?: $profile->bio, 150) }}">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url('/@' . $profile->clean_handle . '/cv') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ $profile->avatar_url ?: asset('favicon-32x32.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #0b0f17;
            color: #f1f5f9;
        }

        .mono {
            font-family: 'JetBrains Mono', monospace;
        }

        /* Glassmorphism styling for web view */
        .cv-card {
            background: rgba(18, 24, 38, 0.7);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        /* Professional Print Optimization (A4 Document Format) */
        @media print {
            @page {
                size: A4;
                margin: 1.2cm 1.5cm;
            }

            body {
                background: #ffffff !important;
                color: #0f172a !important;
                font-size: 11pt;
                line-height: 1.5;
            }

            .no-print {
                display: none !important;
            }

            .print-only {
                display: block !important;
            }

            .cv-container {
                max-width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
                box-shadow: none !important;
                border: none !important;
                background: transparent !important;
            }

            .cv-card {
                background: transparent !important;
                border: none !important;
                backdrop-filter: none !important;
                padding: 0 !important;
                margin-bottom: 1.5rem !important;
            }

            .print-border-b {
                border-bottom: 2px solid #e2e8f0 !important;
                padding-bottom: 0.75rem !important;
                margin-bottom: 1rem !important;
            }

            .print-text-dark {
                color: #0f172a !important;
            }

            .print-text-muted {
                color: #475569 !important;
            }

            .print-badge {
                border: 1px solid #cbd5e1 !important;
                background: #f1f5f9 !important;
                color: #0f172a !important;
            }

            .page-break-avoid {
                break-inside: avoid;
                page-break-inside: avoid;
            }

            a {
                text-decoration: none !important;
                color: inherit !important;
            }
        }
    </style>
</head>
<body class="min-h-screen selection:bg-sky-500 selection:text-white flex flex-col justify-between">

    @if(!$profile->enable_cv && auth()->check() && auth()->id() === $profile->user_id)
        <div class="no-print bg-amber-500/15 border-b border-amber-500/30 px-4 py-2 text-xs text-amber-300">
            <div class="max-w-4xl mx-auto flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div class="flex items-center gap-2">
                    <i data-lucide="alert-triangle" class="w-4 h-4 text-amber-400 flex-shrink-0"></i>
                    <span><strong>Status CV: Nonaktif (Draf / Tersembunyi)</strong> &mdash; Hanya Anda yang dapat melihat pratinjau ini. Pengunjung umum akan dialihkan ke bio.</span>
                </div>
                <form action="{{ route('admin.cv.toggle') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-3 py-1 rounded-lg bg-emerald-500 hover:bg-emerald-400 text-white font-bold text-xs shadow transition-all">
                        Aktifkan Sekarang
                    </button>
                </form>
            </div>
        </div>
    @endif

    <!-- Top Floating Toolbar (Hidden on Print) -->
    <header class="no-print sticky top-0 z-40 bg-[#0b0f17]/85 backdrop-blur-md border-b border-white/10 px-4 py-3">
        <div class="max-w-4xl mx-auto flex items-center justify-between gap-4">
            <!-- Back to Bio Link -->
            <a href="{{ route('public.bio.at', $profile->clean_handle) }}" 
               class="inline-flex items-center gap-2 text-xs font-semibold text-zinc-300 hover:text-white transition-colors bg-white/5 hover:bg-white/10 px-3.5 py-2 rounded-xl border border-white/10">
                <i data-lucide="arrow-left" class="w-4 h-4 text-sky-400"></i>
                <span>Kembali ke BioLink</span>
            </a>

            <!-- Action Controls -->
            <div class="flex items-center gap-2">
                @if($profile->cv_file_url)
                    <a href="{{ $profile->cv_file_url }}" 
                       download 
                       target="_blank"
                       class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold bg-zinc-800 hover:bg-zinc-700 text-zinc-200 border border-zinc-700 transition-all hover:scale-[1.02] shadow-sm"
                       title="Unduh File PDF Dokumen Asli">
                        <i data-lucide="download" class="w-4 h-4 text-emerald-400"></i>
                        <span class="hidden sm:inline">Unduh PDF Resmi</span>
                    </a>
                @endif

                <button onclick="window.print()" 
                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold bg-sky-500 hover:bg-sky-400 text-white transition-all hover:scale-[1.02] shadow-lg shadow-sky-500/20"
                        title="Cetak langsung atau simpan sebagai dokumen PDF">
                    <i data-lucide="printer" class="w-4 h-4"></i>
                    <span>Cetak / Simpan PDF</span>
                </button>
            </div>
        </div>
    </header>

    <!-- Main CV Content Container -->
    <main class="w-full max-w-4xl mx-auto px-4 sm:px-6 py-6 md:py-10 flex-grow">
        <x-cv-sheet 
            :profile="$profile" 
            :experiences="$experiences" 
            :educations="$educations" 
            :skills="$skills" 
            :socialLinks="$socialLinks" 
        />
    </main>

    <!-- Footer Note (Hidden on Print) -->
    <footer class="no-print w-full py-8 text-center text-xs text-zinc-500 flex flex-col items-center gap-2">
        <p>
            Dibuat secara profesional menggunakan <a href="/" class="text-zinc-400 hover:text-white font-bold underline">BioLink CV Builder</a> &bull; 
            <a href="{{ route('public.bio.at', $profile->clean_handle) }}" class="text-sky-400 hover:underline">/@ {{ $profile->clean_handle }}</a>
        </p>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
