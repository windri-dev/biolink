<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Ditangguhkan • BioLink</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=DM+Mono:wght@500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #09090b; color: #f4f4f5; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-zinc-900 via-zinc-950 to-black">
    <div class="max-w-md w-full bg-zinc-900/80 border border-zinc-800 rounded-3xl p-8 text-center space-y-5 shadow-2xl backdrop-blur-xl">
        <div class="w-16 h-16 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-400 mx-auto flex items-center justify-center shadow-lg">
            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>

        <div class="space-y-2">
            <h1 class="text-xl font-black text-white">Halaman Bio Ditangguhkan</h1>
            <p class="text-xs text-zinc-400 font-mono">@<span>{{ $profile->clean_handle }}</span></p>
            <p class="text-xs text-zinc-300 leading-relaxed">
                Halaman bio ini sedang ditangguhkan sementara oleh administrator platform untuk peninjauan keamanan atau moderasi konten.
            </p>
        </div>

        <div class="pt-4 border-t border-zinc-800">
            <a href="/" class="inline-flex items-center gap-2 text-xs font-semibold px-4 py-2.5 rounded-xl bg-zinc-800 hover:bg-zinc-700 text-zinc-200 transition-colors">
                <span>Kembali ke Beranda BioLink</span>
            </a>
        </div>
    </div>
</body>
</html>
