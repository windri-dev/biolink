<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Services\TotpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class TwoFactorAuthController
{
    public function __construct(
        protected TotpService $totpService
    ) {}

    /**
     * Show 2FA Settings Page
     */
    public function index(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();
        $isEnabled = $user->hasTwoFactorEnabled();

        $secret = null;
        $otpAuthUrl = null;

        if (!$isEnabled) {
            // Retrieve pending secret from session or generate a fresh one
            $secret = $request->session()->get('2fa_pending_secret');
            if (!$secret) {
                $secret = $this->totpService->generateSecret(16);
                $request->session()->put('2fa_pending_secret', $secret);
            }

            $otpAuthUrl = $this->totpService->getOtpAuthUrl(
                appName: config('app.name', 'BioLink'),
                accountName: $user->email,
                secret: $secret
            );
        }

        return view('admin.security.two-factor', [
            'user' => $user,
            'isEnabled' => $isEnabled,
            'secret' => $secret,
            'otpAuthUrl' => $otpAuthUrl,
            'recoveryCodes' => $isEnabled ? $user->recoveryCodes() : [],
        ]);
    }

    /**
     * Confirm & Activate 2FA with 6-digit Code
     */
    public function confirm(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ]);

        /** @var User $user */
        $user = $request->user();
        $secret = $request->session()->get('2fa_pending_secret');

        if (!$secret) {
            return back()->with('error', 'Sesi pembuatan 2FA telah kedaluwarsa. Silakan coba kembali.');
        }

        $code = trim($request->input('code'));

        if (!$this->totpService->verify($secret, $code)) {
            return back()->with('error', 'Kode verifikasi 6-digit salah atau telah kedaluwarsa. Pastikan jam di perangkat Anda sinkron.');
        }

        // Generate 8 initial recovery codes
        $recoveryCodes = $this->totpService->generateRecoveryCodes(8);

        $user->update([
            'two_factor_secret' => $secret,
            'two_factor_recovery_codes' => json_encode($recoveryCodes),
            'two_factor_confirmed_at' => now(),
        ]);

        $request->session()->forget('2fa_pending_secret');

        return back()->with('success', 'Autentikasi Dua Faktor (2FA) berhasil diaktifkan! Harap simpan kode pemulihan Anda di tempat yang aman.');
    }

    /**
     * Disable 2FA (Requires Password Confirmation)
     */
    public function disable(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'string'],
        ]);

        /** @var User $user */
        $user = $request->user();

        if (!Hash::check($request->input('password'), $user->password)) {
            return back()->with('error', 'Kata sandi saat ini salah. Tidak dapat menonaktifkan 2FA.');
        }

        $user->update([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ]);

        return back()->with('success', 'Autentikasi Dua Faktor (2FA) telah dinonaktifkan.');
    }

    /**
     * Regenerate Fresh Set of Recovery Codes
     */
    public function regenerateRecoveryCodes(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'string'],
        ]);

        /** @var User $user */
        $user = $request->user();

        if (!$user->hasTwoFactorEnabled()) {
            return back()->with('error', '2FA belum aktif pada akun ini.');
        }

        if (!Hash::check($request->input('password'), $user->password)) {
            return back()->with('error', 'Kata sandi saat ini tidak valid.');
        }

        $newCodes = $this->totpService->generateRecoveryCodes(8);

        $user->update([
            'two_factor_recovery_codes' => json_encode($newCodes),
        ]);

        return back()->with('success', '8 Kode pemulihan baru berhasil dibuat. Kode pemulihan lama tidak berlaku lagi.');
    }
}
