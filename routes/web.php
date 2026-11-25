<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\AiKnowledgeController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DataExportController;
use App\Http\Controllers\Admin\LinkController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ThemeController;
use App\Http\Controllers\AiChatController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\PublicBioController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\VcardController;
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
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Link Click Tracker & AI Assistant API
Route::get('/l/{id}', [PublicBioController::class, 'trackClick'])->name('public.click');
Route::post('/api/ai-chat', [AiChatController::class, 'chat'])->name('api.ai.chat');

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

    // Themes
    Route::get('/themes', [ThemeController::class, 'index'])->name('themes.index');
    Route::post('/themes/{id}/apply', [ThemeController::class, 'apply'])->name('themes.apply');
    Route::post('/themes/custom', [ThemeController::class, 'storeCustom'])->name('themes.custom');

    // AI Knowledge Base & API Settings
    Route::post('/ai-knowledge/settings', [AiKnowledgeController::class, 'updateAiSettings'])->name('ai.settings.update');
    Route::post('/ai-knowledge/test-api', [AiKnowledgeController::class, 'testConnection'])->name('ai.api.test');
    Route::resource('/ai-knowledge', AiKnowledgeController::class)->except(['create', 'show', 'edit']);

    // Analytics
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');

    // Data Export & Backup
    Route::get('/export/json', [DataExportController::class, 'exportJson'])->name('export.json');
    Route::get('/export/csv', [DataExportController::class, 'exportCsv'])->name('export.csv');

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
