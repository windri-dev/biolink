<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\AiKnowledgeController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DataExportController;
use App\Http\Controllers\Admin\LinkController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SuperAdminController;
use App\Http\Controllers\Admin\ThemeController;
use App\Http\Controllers\Admin\TwoFactorAuthController;
use App\Http\Controllers\AiChatController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\PublicBioController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\VcardController;
use App\Http\Middleware\EnsureSuperAdmin;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Homepage & SEO Sitemap Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [LandingPageController::class, 'index'])->name('home');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('seo.sitemap');

// Authentication Routes (Login & Register for Multi-User)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/login/2fa', [AuthController::class, 'show2faChallenge'])->name('2fa.challenge');
Route::post('/login/2fa', [AuthController::class, 'verify2faChallenge'])->name('2fa.challenge.verify');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Compatibility Aliases for Admin Login
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');

// Link Click Tracker & AI Assistant API (with anti-spam rate limiter)
Route::get('/l/{id}', [PublicBioController::class, 'trackClick'])->name('public.click');
Route::post('/api/ai-chat', [AiChatController::class, 'chat'])->middleware('throttle:30,1')->name('api.ai.chat');

// Direct User Security Aliases (Accessible by All Registered Users)
Route::middleware('auth')->group(function () {
    Route::get('/security/2fa', [TwoFactorAuthController::class, 'index'])->name('security.2fa');
});

/*
|--------------------------------------------------------------------------
| Protected User Studio Dashboard (Multi-Tenant Scoped)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('admin')->as('admin.')->group(function () {
    Route::get('/', fn() => redirect()->route('admin.dashboard'));
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Link Management
    Route::resource('/links', LinkController::class)->except(['create', 'show', 'edit']);
    Route::post('/links/{id}/toggle', [LinkController::class, 'toggle'])->name('links.toggle');
    Route::post('/links/reorder', [LinkController::class, 'reorder'])->name('links.reorder');

    // Profile & Socials
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/socials', [ProfileController::class, 'updateSocials'])->name('profile.socials');
    Route::post('/profile/socials/add', [ProfileController::class, 'storeSocial'])->name('profile.socials.store');
    Route::put('/profile/socials/{id}', [ProfileController::class, 'updateSocial'])->name('profile.socials.update');
    Route::post('/profile/socials/{id}/toggle', [ProfileController::class, 'toggleSocial'])->name('profile.socials.toggle');
    Route::delete('/profile/socials/{id}', [ProfileController::class, 'destroySocial'])->name('profile.socials.destroy');

    // Themes
    Route::get('/themes', [ThemeController::class, 'index'])->name('themes.index');
    Route::post('/themes/{id}/apply', [ThemeController::class, 'apply'])->name('themes.apply');
    Route::post('/themes/custom', [ThemeController::class, 'storeCustom'])->name('themes.custom');
    Route::delete('/themes/{id}', [ThemeController::class, 'destroy'])->name('themes.destroy');
    Route::post('/themes/reset-background', [ThemeController::class, 'resetBackground'])->name('themes.reset-background');

    // AI Knowledge Base & API Settings
    Route::post('/ai-knowledge/settings', [AiKnowledgeController::class, 'updateAiSettings'])->name('ai.settings.update');
    Route::post('/ai-knowledge/toggle-quick', [AiKnowledgeController::class, 'toggleQuick'])->name('ai.toggle-quick');
    Route::post('/ai-knowledge/test-api', [AiKnowledgeController::class, 'testConnection'])->name('ai.api.test');
    Route::resource('/ai-knowledge', AiKnowledgeController::class)->except(['create', 'show', 'edit']);

    // Analytics
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');

    // Two-Factor Authenticator (2FA) Security
    Route::get('/security/2fa', [TwoFactorAuthController::class, 'index'])->name('security.2fa.index');
    Route::post('/security/2fa/confirm', [TwoFactorAuthController::class, 'confirm'])->name('security.2fa.confirm');
    Route::post('/security/2fa/disable', [TwoFactorAuthController::class, 'disable'])->name('security.2fa.disable');
    Route::post('/security/2fa/regenerate', [TwoFactorAuthController::class, 'regenerateRecoveryCodes'])->name('security.2fa.regenerate');

    // Data Export & Backup
    Route::get('/export/json', [DataExportController::class, 'exportJson'])->name('export.json');
    Route::get('/export/csv', [DataExportController::class, 'exportCsv'])->name('export.csv');

    // Super Admin Master Control Routes
    Route::middleware([EnsureSuperAdmin::class])->prefix('master-control')->as('master.')->group(function () {
        Route::get('/', [SuperAdminController::class, 'index'])->name('index');
        Route::get('/links', [SuperAdminController::class, 'links'])->name('links');
        Route::get('/users/{id}', [SuperAdminController::class, 'showUser'])->name('user.show');
        Route::post('/users/{id}/toggle-status', [SuperAdminController::class, 'toggleUserStatus'])->name('user.toggle-status');
        Route::delete('/users/{id}', [SuperAdminController::class, 'destroyUser'])->name('user.destroy');
        Route::post('/links/{id}/toggle', [SuperAdminController::class, 'toggleLinkStatus'])->name('link.toggle');
        Route::delete('/links/{id}', [SuperAdminController::class, 'destroyLink'])->name('link.destroy');
    });

    // Logout alias inside admin prefix
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Public Bio Profile Routing (Supports /@username and /username)
|--------------------------------------------------------------------------
*/
Route::get('/@{handle}/vcard', [VcardController::class, 'download'])
    ->where('handle', '[a-zA-Z0-9_-]+')
    ->name('public.vcard');

Route::get('/@{handle}', [PublicBioController::class, 'show'])
    ->where('handle', '[a-zA-Z0-9_-]+')
    ->name('public.bio.at');

Route::get('/{handle}', [PublicBioController::class, 'show'])
    ->where('handle', '[a-zA-Z0-9_-]+')
    ->name('public.bio');
