<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru • BioLink</title>

    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="alternate icon" href="/favicon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=DM+Mono:wght@500;700&display=swap" rel="stylesheet">

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
        
        <div class="text-center space-y-2">
            <a href="/" class="inline-flex items-center gap-2 font-black text-xl tracking-tight text-white mb-1">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-sky-400 to-indigo-600 flex items-center justify-center text-white shadow-lg shadow-sky-500/20">
                    <i data-lucide="link-2" class="w-5 h-5"></i>
                </div>
                <span>BioLink<span class="text-sky-400">.</span></span>
            </a>
            <h1 class="text-xl font-black text-white tracking-tight">Klaim Halaman Bio Anda</h1>
            <p class="text-xs text-zinc-400">Buat akun untuk mulai mengumpulkan link dan mengaktifkan Asisten AI Anda.</p>
        </div>

        @if($errors->any())
            <div class="bg-rose-500/10 border border-rose-500/30 text-rose-400 p-3.5 rounded-xl text-xs flex items-center gap-2">
                <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('register.submit') }}" method="POST" class="space-y-4 text-xs">
            @csrf

            <!-- Handle / Username -->
            <div>
                <label class="block text-zinc-300 font-semibold mb-1.5">Pilih Username / Handle *</label>
                <div class="relative">
                    <span class="absolute left-3.5 top-3 text-zinc-500 font-mono">@</span>
                    <input type="text" 
                           name="handle" 
                           value="{{ old('handle', $prefilledHandle ?? '') }}" 
                           required 
                           autofocus
                           placeholder="username-anda" 
                           class="w-full bg-zinc-800/80 border border-zinc-700 rounded-xl py-2.5 pl-8 pr-3.5 text-white font-mono placeholder-zinc-500 focus:outline-none focus:border-sky-400 focus:ring-1 focus:ring-sky-400">
                </div>
                <p class="text-[10px] text-zinc-500 mt-1">URL publik Anda akan menjadi: <span class="text-sky-400 font-mono">biolink.local/@username</span></p>
            </div>

            <!-- Full Name -->
            <div>
                <label class="block text-zinc-300 font-semibold mb-1.5">Nama Lengkap / Brand *</label>
                <div class="relative">
                    <span class="absolute left-3.5 top-3 text-zinc-500"><i data-lucide="user" class="w-4 h-4"></i></span>
                    <input type="text" 
                           name="name" 
                           value="{{ old('name') }}" 
                           required 
                           placeholder="Contoh: Windri" 
                           class="w-full bg-zinc-800/80 border border-zinc-700 rounded-xl py-2.5 pl-10 pr-3.5 text-white placeholder-zinc-500 focus:outline-none focus:border-sky-400 focus:ring-1 focus:ring-sky-400">
                </div>
            </div>

            <!-- Email Address -->
            <div>
                <label class="block text-zinc-300 font-semibold mb-1.5">Alamat Email *</label>
                <div class="relative">
                    <span class="absolute left-3.5 top-3 text-zinc-500"><i data-lucide="mail" class="w-4 h-4"></i></span>
                    <input type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           placeholder="nama@email.com" 
                           class="w-full bg-zinc-800/80 border border-zinc-700 rounded-xl py-2.5 pl-10 pr-3.5 text-white placeholder-zinc-500 focus:outline-none focus:border-sky-400 focus:ring-1 focus:ring-sky-400">
                </div>
            </div>

            <!-- Password -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-zinc-300 font-semibold mb-1.5">Kata Sandi *</label>
                    <input type="password" 
                           name="password" 
                           required 
                           placeholder="Min. 6 karakter" 
                           class="w-full bg-zinc-800/80 border border-zinc-700 rounded-xl py-2.5 px-3.5 text-white placeholder-zinc-500 focus:outline-none focus:border-sky-400 focus:ring-1 focus:ring-sky-400">
                </div>
                <div>
                    <label class="block text-zinc-300 font-semibold mb-1.5">Ulangi Sandi *</label>
                    <input type="password" 
                           name="password_confirmation" 
                           required 
                           placeholder="Ketik ulang sandi" 
                           class="w-full bg-zinc-800/80 border border-zinc-700 rounded-xl py-2.5 px-3.5 text-white placeholder-zinc-500 focus:outline-none focus:border-sky-400 focus:ring-1 focus:ring-sky-400">
                </div>
            </div>

            <button type="submit" class="w-full py-3 rounded-xl bg-sky-500 hover:bg-sky-400 text-white font-bold text-xs transition-all shadow-lg shadow-sky-500/25 flex items-center justify-center gap-2 mt-2">
                <span>Daftar & Luncurkan Bio Saya</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </button>
        </form>

        <div class="text-center pt-2 border-t border-zinc-800 text-[11px] text-zinc-400">
            Sudah memiliki akun? 
            <a href="{{ route('login') }}" class="text-sky-400 hover:underline font-semibold ml-1">Masuk ke sini</a>
        </div>

    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
