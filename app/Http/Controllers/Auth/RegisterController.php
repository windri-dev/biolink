<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Models\BioLink;
use App\Models\Profile;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisterController
{
    public function showRegistrationForm(Request $request): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        $prefilledHandle = strtolower(trim((string) $request->query('handle', '')));
        $prefilledHandle = preg_replace('/[^a-z0-9_-]/', '', $prefilledHandle);

        return view('auth.register', [
            'prefilledHandle' => $prefilledHandle,
        ]);
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'handle' => [
                'required',
                'string',
                'min:3',
                'max:30',
                'regex:/^[a-zA-Z0-9_-]+$/',
                'unique:profiles,handle',
                function ($attribute, $value, $fail) {
                    $reserved = ['admin', 'login', 'register', 'logout', 'api', 'dashboard', 'settings', 'public', 'home', 'app'];
                    if (in_array(strtolower($value), $reserved, true)) {
                        $fail("Handle '{$value}' dicadangkan untuk sistem dan tidak dapat digunakan.");
                    }
                },
            ],
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(6)],
        ], [
            'handle.regex' => 'Username hanya boleh berisi huruf, angka, garis hubung (-), dan garis bawah (_).',
            'handle.unique' => 'Username ini sudah terdaftar oleh pengguna lain. Silakan pilih username lain.',
            'email.unique' => 'Alamat email ini sudah terdaftar.',
        ]);

        $defaultTheme = Theme::where('slug', 'dark-luxury')->first();

        $user = DB::transaction(function () use ($validated, $defaultTheme) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            $cleanHandle = strtolower($validated['handle']);

            $profile = Profile::create([
                'user_id' => $user->id,
                'theme_id' => $defaultTheme?->id,
                'handle' => $cleanHandle,
                'display_name' => $validated['name'],
                'avatar_url' => 'https://ui-avatars.com/api/?name=' . urlencode($validated['name']) . '&background=0284c7&color=fff&size=200',
                'bio' => 'Selamat datang di halaman biolink resmi saya. Temukan tautan dan proyek terbaru saya di sini!',
                'tagline' => 'Creator & Builder',
                'is_verified' => false,
                'show_share_button' => true,
                'ai_assistant_enabled' => true,
                'ai_assistant_name' => 'Aura',
                'ai_greeting_message' => "Halo, saya asisten pintar {$validated['name']}. Ada yang bisa saya bantu terkait proyek atau kontak?",
                'meta_title' => "{$validated['name']} (@{$cleanHandle}) • BioLink",
                'meta_description' => "Profil dan kumpulan tautan resmi {$validated['name']}.",
            ]);

            // Add default welcome starter links
            BioLink::create([
                'profile_id' => $profile->id,
                'type' => 'link',
                'title' => 'Kunjungi Website Saya',
                'subtitle' => 'Jelajahi portofolio dan karya terbaru',
                'url' => 'https://github.com',
                'icon' => 'globe',
                'badge_text' => 'NEW',
                'badge_color' => 'sky',
                'is_highlighted' => true,
                'is_active' => true,
                'sort_order' => 1,
            ]);

            return $user;
        });

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard')->with('success', 'Selamat datang di BioLink! Halaman bio Anda siap disesuaikan. Jangan lupa aktifkan Autentikasi 2FA di menu Keamanan demi perlindungan akun Anda.');
    }
}
