#!/bin/bash

# Complete Telegram Bot Deployment Script for Production
# This creates all necessary files on the production server

echo "📦 Creating all Telegram Bot files on production..."
echo ""

# Set production directory
PROD_DIR="/www/wwwroot/qattabor"

echo "1️⃣ Creating TelegramService.php..."
cat > $PROD_DIR/app/Services/TelegramService.php << 'EOFSERVICE'
<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    protected string $botToken;
    protected string $apiUrl;

    public function __construct()
    {
        $this->botToken = config('services.telegram.bot_token');
        $this->apiUrl = "https://api.telegram.org/bot{$this->botToken}";
    }

    public function sendMessage(int $chatId, string $text, ?array $replyMarkup = null, ?array $params = []): ?int
    {
        $data = array_merge([
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML',
        ], $params);

        if ($replyMarkup) {
            $data['reply_markup'] = json_encode($replyMarkup);
        }

        $response = Http::timeout(10)->post("{$this->apiUrl}/sendMessage", $data);
        
        if ($response->successful()) {
            return $response->json('result.message_id');
        }

        Log::error('Telegram sendMessage failed', ['response' => $response->json()]);
        return null;
    }

    public function sendPhoto(int $chatId, string $photo, ?string $caption = null, ?array $replyMarkup = null): ?string
    {
        $data = [
            'chat_id' => $chatId,
            'photo' => $photo,
        ];

        if ($caption) {
            $data['caption'] = $caption;
            $data['parse_mode'] = 'HTML';
        }

        if ($replyMarkup) {
            $data['reply_markup'] = json_encode($replyMarkup);
        }

        $response = Http::timeout(30)->post("{$this->apiUrl}/sendPhoto", $data);

        if ($response->successful()) {
            return $response->json('result.photo.0.file_id');
        }

        Log::error('Telegram sendPhoto failed', ['response' => $response->json()]);
        return null;
    }

    public function sendVideo(int $chatId, string $video, ?string $caption = null, ?array $replyMarkup = null): ?string
    {
        $data = [
            'chat_id' => $chatId,
            'video' => $video,
        ];

        if ($caption) {
            $data['caption'] = $caption;
            $data['parse_mode'] = 'HTML';
        }

        if ($replyMarkup) {
            $data['reply_markup'] = json_encode($replyMarkup);
        }

        $response = Http::timeout(60)->post("{$this->apiUrl}/sendVideo", $data);

        if ($response->successful()) {
            return $response->json('result.video.file_id');
        }

        Log::error('Telegram sendVideo failed', ['response' => $response->json()]);
        return null;
    }

    public function setWebhook(string $url, array $allowedUpdates = ['message', 'callback_query']): bool
    {
        $response = Http::post("{$this->apiUrl}/setWebhook", [
            'url' => $url,
            'allowed_updates' => $allowedUpdates,
        ]);

        return $response->successful() && $response->json('ok') === true;
    }

    public function getWebhookInfo(): array
    {
        $response = Http::get("{$this->apiUrl}/getWebhookInfo");
        return $response->json('result', []);
    }

    public function deleteWebhook(): bool
    {
        $response = Http::post("{$this->apiUrl}/deleteWebhook");
        return $response->successful();
    }
}
EOFSERVICE

echo "✅ TelegramService.php created"
echo ""

echo "2️⃣ Verifying routes/api.php..."
ls -la $PROD_DIR/routes/api.php
echo ""

echo "3️⃣ Verifying app/Http/Controllers/Api/TelegramWebhookController.php..."
ls -la $PROD_DIR/app/Http/Controllers/Api/TelegramWebhookController.php
echo ""

echo "4️⃣ Verifying app/Services/TelegramService.php..."
ls -la $PROD_DIR/app/Services/TelegramService.php
echo ""

echo "5️⃣ Clearing caches..."
cd $PROD_DIR
php artisan optimize:clear
echo ""

echo "6️⃣ Listing API routes..."
php artisan route:list --name=api
echo ""

echo "7️⃣ Testing webhook endpoint locally..."
curl -X GET http://localhost/api/telegram/webhook
echo ""
echo ""

echo "8️⃣ Testing webhook endpoint externally..."
curl -X GET https://qattabor.uz/api/telegram/webhook
echo ""
echo ""

echo "✅ Deployment complete!"
echo ""
echo "If still 404, check:"
echo "1. nginx configuration"
echo "2. .htaccess rules"
echo "3. Laravel logs: tail -f storage/logs/laravel.log"
