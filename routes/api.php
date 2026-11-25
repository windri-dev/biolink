<?php

declare(strict_types=1);

use App\Http\Controllers\AiChatController;
use Illuminate\Support\Facades\Route;

Route::post('/ai-chat', [AiChatController::class, 'chat'])->name('api.ai.chat.route');
