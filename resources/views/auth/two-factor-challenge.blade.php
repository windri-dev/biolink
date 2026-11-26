<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otentikasi Dua Faktor (2FA) • BioLink</title>

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

        <!-- Header -->
        <div class="text-center space-y-2">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-sky-500 to-indigo-600 flex items-center justify-center text-white mx-auto shadow-xl shadow-sky-500/20 mb-3">
                <i data-lucide="shield-check" class="w-7 h-7"></i>
            </div>
            <h1 class="text-xl font-black text-white tracking-tight">Otentikasi Dua Faktor (2FA)</h1>
            <p id="challengePrompt" class="text-xs text-zinc-400">
                Buka aplikasi Authenticator (Google / Microsoft Authenticator) dan masukkan 6-digit kode verifikasi Anda.
            </p>
        </div>

        @if ($errors->any())
            <div class="bg-rose-500/10 border border-rose-500/30 text-rose-400 p-3.5 rounded-xl text-xs flex items-center gap-2">
                <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('2fa.challenge.verify') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Primary: 6-Digit TOTP Input -->
            <div id="totpSection" class="space-y-1.5">
                <label for="codeInput" class="block text-xs font-semibold text-zinc-300">Kode Verifikasi 6-Digit</label>
                <div class="relative">
                    <input type="text" 
                           id="codeInput"
                           name="code" 
                           inputmode="numeric"
                           pattern="[0-9]*"
                           maxlength="6"
                           autocomplete="one-time-code"
                           placeholder="000000"
                           autofocus
                           class="w-full text-center tracking-[0.5em] text-2xl font-mono font-bold bg-zinc-800/80 border border-zinc-700 rounded-2xl py-3 px-4 text-white focus:outline-none focus:border-sky-400 transition-colors">
                </div>
            </div>

            <!-- Alternative: Recovery Code Input -->
            <div id="recoverySection" class="space-y-1.5 hidden">
                <label for="recoveryInput" class="block text-xs font-semibold text-zinc-300">Kode Pemulihan Cadangan (Recovery Code)</label>
                <div class="relative">
                    <input type="text" 
                           id="recoveryInput"
                           name="recovery_code" 
                           placeholder="ABCD-1234"
                           class="w-full text-center uppercase tracking-widest text-lg font-mono font-bold bg-zinc-800/80 border border-zinc-700 rounded-2xl py-3 px-4 text-white focus:outline-none focus:border-sky-400 transition-colors">
                </div>
                <span class="text-[10px] text-zinc-500 block text-center">Masukkan salah satu dari 8 kode pemulihan yang Anda simpan saat aktivasi 2FA.</span>
            </div>

            <button type="submit" class="w-full py-3.5 px-4 rounded-xl bg-gradient-to-r from-sky-500 to-indigo-600 hover:from-sky-400 hover:to-indigo-500 text-white font-black text-xs transition-all shadow-lg shadow-sky-500/25 flex items-center justify-center gap-2">
                <span>Verifikasi & Masuk</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </button>
        </form>

        <!-- Toggle between TOTP and Recovery Code -->
        <div class="pt-2 text-center border-t border-zinc-800/80">
            <button type="button" 
                    id="toggleModeBtn"
                    onclick="toggle2faMode()" 
                    class="text-xs font-semibold text-sky-400 hover:text-sky-300 transition-colors">
                Gunakan Kode Pemulihan Cadangan (Recovery Code)
            </button>
        </div>

        <div class="text-center">
            <a href="{{ route('login') }}" class="text-xs text-zinc-500 hover:text-zinc-300 transition-colors inline-flex items-center gap-1">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                <span>Kembali ke Halaman Masuk</span>
            </a>
        </div>

    </div>

    <script>
        lucide.createIcons();

        let isRecoveryMode = false;

        function toggle2faMode() {
            isRecoveryMode = !isRecoveryMode;

            const totpSec = document.getElementById('totpSection');
            const recSec = document.getElementById('recoverySection');
            const codeInp = document.getElementById('codeInput');
            const recInp = document.getElementById('recoveryInput');
            const btn = document.getElementById('toggleModeBtn');
            const prompt = document.getElementById('challengePrompt');

            if (isRecoveryMode) {
                totpSec.classList.add('hidden');
                recSec.classList.remove('hidden');
                codeInp.value = '';
                recInp.focus();
                btn.innerText = 'Gunakan Kode Aplikasi Authenticator (TOTP)';
                prompt.innerText = 'Masukkan salah satu dari 8 kode pemulihan darurat akun Anda.';
            } else {
                recSec.classList.add('hidden');
                totpSec.classList.remove('hidden');
                recInp.value = '';
                codeInp.focus();
                btn.innerText = 'Gunakan Kode Pemulihan Cadangan (Recovery Code)';
                prompt.innerText = 'Buka aplikasi Authenticator (Google / Microsoft Authenticator) dan masukkan 6-digit kode verifikasi Anda.';
            }
        }
    </script>
</body>
</html>
