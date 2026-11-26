<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController
{
    /**
     * Public registration is closed. Managed exclusively by Master Admin.
     */
    public function showRegistrationForm(Request $request): RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('login')->with('info', 'Pendaftaran akun baru saat ini ditutup untuk umum. Akses platform BioLink dikelola secara privat oleh Master Admin.');
    }

    /**
     * Reject any direct POST registration requests from public.
     */
    public function register(Request $request): RedirectResponse
    {
        return redirect()->route('login')->with('error', 'Pendaftaran akun baru saat ini ditutup untuk umum. Akses hanya dapat diberikan langsung oleh Master Admin.');
    }
}
