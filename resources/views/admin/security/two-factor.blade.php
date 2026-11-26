@extends('layouts.admin')

@section('title', 'Keamanan Akun & Authenticator (2FA)')

@section('content')
<div class="space-y-6 max-w-4xl">

    <!-- Header -->
    <div>
        <div class="flex items-center gap-2 mb-1">
            <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-sky-500/10 text-sky-400 border border-sky-500/30 uppercase">Proteksi Akun</span>
            <span class="text-xs text-zinc-500 font-mono">• Multi-Factor Authentication</span>
        </div>
        <h2 class="text-xl font-black text-white tracking-tight">Autentikasi Dua Faktor (2FA Authenticator)</h2>
        <p class="text-xs text-zinc-400">Tambahkan lapisan keamanan ekstra pada akun Anda menggunakan aplikasi Google Authenticator, Microsoft Authenticator, atau Authy.</p>
    </div>

    @if(!$isEnabled)
        <!-- ================================================================= -->
        <!-- STATE 1: 2FA BELUM DIAKTIFKAN (SETUP WIZARD)                     -->
        <!-- ================================================================= -->
        <div class="bg-zinc-900/80 border border-zinc-800 rounded-3xl p-6 sm:p-8 space-y-6 shadow-xl">
            <div class="flex items-center gap-3 border-b border-zinc-800 pb-4">
                <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center">
                    <i data-lucide="shield-alert" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-white">Status 2FA: Nonaktif</h3>
                    <p class="text-xs text-zinc-400">Akun Anda saat ini hanya dilindungi oleh kata sandi. Aktifkan 2FA untuk perlindungan maksimal.</p>
                </div>
            </div>

            <!-- Steps Setup -->
            <div class="space-y-6">
                <!-- Step 1 -->
                <div class="space-y-2">
                    <span class="text-xs font-bold text-sky-400 font-mono uppercase tracking-wider block">Langkah 1: Siapkan Aplikasi Authenticator</span>
                    <p class="text-xs text-zinc-300">
                        Pastikan Anda telah memasang aplikasi autentikator seperti <strong>Google Authenticator</strong>, <strong>Microsoft Authenticator</strong>, atau <strong>Authy</strong> di ponsel Anda.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="space-y-3">
                    <span class="text-xs font-bold text-sky-400 font-mono uppercase tracking-wider block">Langkah 2: Pindai Kode QR atau Masukkan Kunci Rahasia</span>
                    <p class="text-xs text-zinc-300">
                        Buka aplikasi Authenticator di ponsel Anda, lalu pindai kode QR di bawah ini:
                    </p>

                    <div class="flex flex-col sm:flex-row items-center gap-6 p-5 rounded-2xl bg-zinc-950/70 border border-zinc-800">
                        <!-- QR Code Canvas Container -->
                        <div class="p-3 bg-white rounded-2xl shadow-md flex-shrink-0">
                            <div id="qrcode"></div>
                        </div>

                        <div class="space-y-3 flex-grow min-w-0 text-xs">
                            <div>
                                <span class="text-zinc-400 block mb-1 font-medium">Atau masukkan Kunci Rahasia (*Secret Key*) secara manual:</span>
                                <div class="flex items-center gap-2">
                                    <code id="secretKeyCode" class="px-3 py-2 rounded-xl bg-zinc-900 border border-zinc-700 text-sky-400 font-mono font-bold tracking-widest text-sm select-all">
                                        {{ $secret }}
                                    </code>
                                    <button type="button" onclick="copySecretKey()" class="px-3 py-2 rounded-xl bg-zinc-800 hover:bg-zinc-700 text-zinc-300 hover:text-white transition-colors inline-flex items-center gap-1 font-semibold text-xs border border-zinc-700">
                                        <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                                        <span id="copyBtnText">Salin</span>
                                    </button>
                                </div>
                            </div>
                            <p class="text-[11px] text-zinc-500 leading-relaxed">
                                Nama Akun: <strong class="text-zinc-300 font-mono">{{ $user->email }}</strong><br>
                                Issuer: <strong class="text-zinc-300 font-mono">BioLink</strong>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="space-y-3 pt-2">
                    <span class="text-xs font-bold text-sky-400 font-mono uppercase tracking-wider block">Langkah 3: Konfirmasi 6-Digit Kode Verifikasi</span>
                    <p class="text-xs text-zinc-300">
                        Masukkan 6-digit angka yang muncul di aplikasi Authenticator ponsel Anda untuk menyelesaikan aktivasi:
                    </p>

                    <form action="{{ route('admin.security.2fa.confirm') }}" method="POST" class="max-w-xs space-y-3">
                        @csrf
                        <div class="relative">
                            <input type="text" 
                                   name="code" 
                                   inputmode="numeric"
                                   pattern="[0-9]*"
                                   maxlength="6"
                                   placeholder="000000" 
                                   required
                                   autocomplete="one-time-code"
                                   class="w-full text-center tracking-[0.4em] text-xl font-mono font-bold bg-zinc-800 border border-zinc-700 rounded-xl py-2.5 px-3 text-white focus:outline-none focus:border-sky-400">
                        </div>

                        <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-sky-500 hover:bg-sky-400 text-white font-bold text-xs transition-all shadow-lg shadow-sky-500/20 inline-flex items-center justify-center gap-2">
                            <i data-lucide="check" class="w-4 h-4"></i>
                            <span>Konfirmasi & Aktifkan 2FA</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

    @else
        <!-- ================================================================= -->
        <!-- STATE 2: 2FA SUDAH AKTIF (ACTIVE & PROTECTED)                     -->
        <!-- ================================================================= -->
        <div class="bg-zinc-900/80 border border-zinc-800 rounded-3xl p-6 sm:p-8 space-y-6 shadow-xl">
            <div class="flex items-center justify-between border-b border-zinc-800 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center shadow-md">
                        <i data-lucide="shield-check" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-white flex items-center gap-2">
                            <span>Status 2FA: Aktif & Terlindungi</span>
                            <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-300 font-bold border border-emerald-500/30">
                                ACTIVE
                            </span>
                        </h3>
                        <p class="text-xs text-zinc-400">Setiap kali Anda masuk ke akun, Anda akan diminta memasukkan 6-digit kode OTP dari aplikasi Authenticator.</p>
                    </div>
                </div>

                <div class="text-[11px] font-mono text-zinc-500">
                    Diaktifkan sejak: {{ $user->two_factor_confirmed_at?->format('d M Y') }}
                </div>
            </div>

            <!-- Recovery Codes Section -->
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-xs font-bold text-white uppercase tracking-wider flex items-center gap-1.5">
                            <i data-lucide="key" class="w-4 h-4 text-amber-400"></i>
                            <span>Kode Pemulihan Cadangan (Emergency Recovery Codes)</span>
                        </h4>
                        <p class="text-xs text-zinc-400 mt-0.5">
                            Gunakan salah satu kode ini jika Anda kehilangan akses ke ponsel atau aplikasi Authenticator Anda. Setiap kode hanya dapat digunakan 1 kali.
                        </p>
                    </div>

                    <button type="button" onclick="downloadRecoveryCodes()" class="px-3 py-1.5 rounded-xl bg-zinc-800 hover:bg-zinc-700 text-zinc-300 hover:text-white text-xs font-semibold border border-zinc-700 transition-colors inline-flex items-center gap-1.5">
                        <i data-lucide="download" class="w-3.5 h-3.5"></i>
                        <span>Unduh .txt</span>
                    </button>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 p-4 rounded-2xl bg-zinc-950/80 border border-zinc-800 font-mono text-xs text-center">
                    @forelse($recoveryCodes as $rc)
                        <div class="p-2.5 rounded-xl bg-zinc-900 border border-zinc-800 text-sky-400 font-bold tracking-wider select-all">
                            {{ $rc }}
                        </div>
                    @empty
                        <div class="col-span-full py-2 text-zinc-500 italic">
                            Seluruh kode pemulihan telah terpakai. Harap buat ulang kode baru di bawah.
                        </div>
                    @endforelse
                </div>

                <!-- Regenerate Recovery Codes Form -->
                <form action="{{ route('admin.security.2fa.regenerate') }}" method="POST" class="pt-2 flex flex-col sm:flex-row items-center gap-3">
                    @csrf
                    <input type="password" 
                           name="password" 
                           placeholder="Masukkan kata sandi untuk buat ulang kode..." 
                           required 
                           class="w-full sm:w-80 bg-zinc-800 border border-zinc-700 rounded-xl px-3.5 py-2 text-xs text-white focus:outline-none focus:border-sky-400">
                    <button type="submit" class="w-full sm:w-auto px-4 py-2 rounded-xl bg-zinc-800 hover:bg-zinc-700 text-zinc-300 hover:text-white text-xs font-semibold border border-zinc-700 transition-colors inline-flex items-center justify-center gap-1.5">
                        <i data-lucide="refresh-cw" class="w-3.5 h-3.5 text-sky-400"></i>
                        <span>Buat Ulang Kode Pemulihan</span>
                    </button>
                </form>
            </div>

            <!-- Danger Zone: Disable 2FA -->
            <div class="pt-6 border-t border-zinc-800/80 space-y-3">
                <h4 class="text-xs font-bold text-rose-400 uppercase tracking-wider flex items-center gap-1.5">
                    <i data-lucide="alert-triangle" class="w-4 h-4 text-rose-400"></i>
                    <span>Nonaktifkan Autentikasi Dua Faktor</span>
                </h4>
                <p class="text-xs text-zinc-400">
                    Menonaktifkan 2FA akan menurunkan tingkat keamanan akun Anda ke tingkat standar (hanya kata sandi).
                </p>

                <form action="{{ route('admin.security.2fa.disable') }}" method="POST" class="flex flex-col sm:flex-row items-center gap-3" onsubmit="return confirm('Apakah Anda yakin ingin menonaktifkan 2FA?')">
                    @csrf
                    <input type="password" 
                           name="password" 
                           placeholder="Konfirmasi kata sandi akun Anda..." 
                           required 
                           class="w-full sm:w-80 bg-zinc-800 border border-zinc-700 rounded-xl px-3.5 py-2 text-xs text-white focus:outline-none focus:border-rose-400">
                    <button type="submit" class="w-full sm:w-auto px-4 py-2 rounded-xl bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 text-xs font-bold border border-rose-500/30 transition-colors">
                        Nonaktifkan 2FA
                    </button>
                </form>
            </div>
        </div>
    @endif

</div>

<!-- QR Code Library CDN -->
<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>

<script>
    @if(!$isEnabled && $otpAuthUrl)
        document.addEventListener('DOMContentLoaded', function () {
            const qrContainer = document.getElementById('qrcode');
            if (qrContainer) {
                new QRCode(qrContainer, {
                    text: "{{ $otpAuthUrl }}",
                    width: 140,
                    height: 140,
                    colorDark : "#09090b",
                    colorLight : "#ffffff",
                    correctLevel : QRCode.CorrectLevel.M
                });
            }
        });

        function copySecretKey() {
            const secret = document.getElementById('secretKeyCode').innerText.trim();
            navigator.clipboard.writeText(secret).then(() => {
                const btnText = document.getElementById('copyBtnText');
                btnText.innerText = 'Tersalin!';
                setTimeout(() => {
                    btnText.innerText = 'Salin';
                }, 2000);
            });
        }
    @endif

    @if($isEnabled)
        function downloadRecoveryCodes() {
            const codes = @json($recoveryCodes);
            const textContent = "KODE PEMULIHAN CADANGAN (2FA) - BIOLINK\n" +
                                "Akun: {{ $user->email }}\n" +
                                "Tanggal: {{ now()->format('d M Y H:i') }}\n\n" +
                                "Gunakan salah satu kode ini jika kehilangan ponsel atau authenticator:\n" +
                                "--------------------------------------------------\n" +
                                codes.join("\n") +
                                "\n--------------------------------------------------\n" +
                                "Simpan di tempat rahasia yang aman.";

            const blob = new Blob([textContent], { type: 'text/plain' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = "biolink-2fa-recovery-codes.txt";
            link.click();
        }
    @endif
</script>
@endsection
