<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TelegramWebhookController;
use App\Http\Controllers\Api\LocationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Geolocation API
Route::post('/detect-region', [LocationController::class, 'detectRegion'])->name('api.detect-region');

// Telegram Webhook (no CSRF protection needed)
Route::match(['get', 'post'], '/telegram/webhook', [TelegramWebhookController::class, 'handle'])->name('api.telegram.webhook');
