<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Services\TotpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $remember = $request->boolean('remember');

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'email' => 'Email atau kata sandi tidak cocok dengan data kami.',
            ])->onlyInput('email');
        }

        if ($user->isSuspended()) {
            return back()->withErrors([
                'email' => 'Akun Anda sedang ditangguhkan oleh administrator platform.',
            ])->onlyInput('email');
        }

        // Two-Factor Authentication Check
        if ($user->hasTwoFactorEnabled()) {
            $request->session()->put('login.2fa.user_id', $user->id);
            $request->session()->put('login.2fa.remember', $remember);

            return redirect()->route('2fa.challenge');
        }

        // Normal Login
        Auth::login($user, $remember);
        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    /**
     * Show Two-Factor Authentication Challenge Screen
     */
    public function show2faChallenge(Request $request): View|RedirectResponse
    {
        $userId = $request->session()->get('login.2fa.user_id');

        if (!$userId) {
            return redirect()->route('login');
        }

        $user = User::find($userId);
        if (!$user) {
            $request->session()->forget(['login.2fa.user_id', 'login.2fa.remember']);
            return redirect()->route('login');
        }

        return view('auth.two-factor-challenge', [
            'user' => $user,
        ]);
    }

    /**
     * Verify 2FA OTP Code or Recovery Code
     */
    public function verify2faChallenge(Request $request, TotpService $totpService): RedirectResponse
    {
        $userId = $request->session()->get('login.2fa.user_id');
        $remember = (bool) $request->session()->get('login.2fa.remember', false);

        if (!$userId) {
            return redirect()->route('login');
        }

        $user = User::findOrFail($userId);

        $code = $request->input('code');
        $recoveryCode = $request->input('recovery_code');

        $isValid = false;

        // Option A: 6-digit TOTP
        if (!empty($code) && !empty($user->two_factor_secret)) {
            $isValid = $totpService->verify($user->two_factor_secret, (string) $code);
        }

        // Option B: Backup Recovery Code
        if (!$isValid && !empty($recoveryCode)) {
            $isValid = $user->consumeRecoveryCode((string) $recoveryCode);
        }

        if (!$isValid) {
            return back()->withErrors([
                'code' => 'Kode autentikasi 6-digit atau kode pemulihan tidak valid.',
            ]);
        }

        // Authentication Successful
        Auth::login($user, $remember);
        $request->session()->forget(['login.2fa.user_id', 'login.2fa.remember']);
        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'))->with('success', 'Berhasil masuk dengan otentikasi dua faktor!');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil keluar dari dashboard.');
    }
}
