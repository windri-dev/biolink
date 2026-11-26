<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Admin • BioLink</title>

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #09090b;
            color: #f4f4f5;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-zinc-800 via-zinc-950 to-black">

    <div class="max-w-md w-full bg-zinc-900/80 border border-zinc-800/80 rounded-3xl p-8 backdrop-blur-xl shadow-2xl space-y-6">
        
        <div class="text-center space-y-3">
            <a href="/" class="inline-block">
                <img src="{{ asset('Logo.png') }}" alt="Logo" class="h-12 w-auto object-contain mx-auto">
            </a>
            <h1 class="text-2xl font-black text-white tracking-tight">BioLink<span class="text-sky-400">.</span></h1>
            <p class="text-xs text-zinc-400">Masuk ke studio dasbor untuk mengelola profil dan tautan Anda.</p>
        </div>

        @if($errors->any())
            <div class="bg-rose-500/10 border border-rose-500/30 text-rose-400 p-3.5 rounded-xl text-xs flex items-center gap-2">
                <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('login.submit') }}" method="POST" class="space-y-4 text-xs">
            @csrf

            <div>
                <label class="block text-zinc-300 font-semibold mb-1.5">Alamat Email</label>
                <div class="relative">
                    <span class="absolute left-3.5 top-3 text-zinc-500"><i data-lucide="mail" class="w-4 h-4"></i></span>
                    <input type="email" name="email" value="{{ old('email', 'admin@biolink.local') }}" required autofocus class="w-full bg-zinc-800/80 border border-zinc-700 rounded-xl py-2.5 pl-10 pr-3.5 text-white placeholder-zinc-500 focus:outline-none focus:border-sky-400 focus:ring-1 focus:ring-sky-400">
                </div>
            </div>

            <div>
                <label class="block text-zinc-300 font-semibold mb-1.5">Kata Sandi</label>
                <div class="relative">
                    <span class="absolute left-3.5 top-3 text-zinc-500"><i data-lucide="lock" class="w-4 h-4"></i></span>
                    <input type="password" name="password" value="password123" required class="w-full bg-zinc-800/80 border border-zinc-700 rounded-xl py-2.5 pl-10 pr-3.5 text-white placeholder-zinc-500 focus:outline-none focus:border-sky-400 focus:ring-1 focus:ring-sky-400">
                </div>
            </div>

            <div class="flex items-center justify-between text-zinc-400 text-xs pt-1">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" value="1" checked class="rounded bg-zinc-800 border-zinc-700 text-sky-500">
                    <span>Ingat Saya</span>
                </label>
                <span class="text-zinc-500">Default: password123</span>
            </div>

            <button type="submit" class="w-full py-3 rounded-xl bg-sky-500 hover:bg-sky-400 text-white font-bold text-xs transition-all shadow-lg shadow-sky-500/25 flex items-center justify-center gap-2">
                <span>Masuk ke Studio Dasbor</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </button>
        </form>

        <div class="text-center pt-2 border-t border-zinc-800 text-[11px] text-zinc-400 space-y-2">
            <div>
                Belum memiliki akun?
                <a href="{{ route('register') }}" class="text-sky-400 hover:underline font-semibold ml-1">Daftar sekarang &bull; Gratis</a>
            </div>
            <div>
                <a href="/" class="text-zinc-500 hover:text-zinc-300 transition-colors inline-flex items-center gap-1">
                    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                    <span>Kembali ke Beranda Utama</span>
                </a>
            </div>
        </div>

    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
