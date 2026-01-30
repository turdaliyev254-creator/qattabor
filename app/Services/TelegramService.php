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

    public function sendMessage(int $chatId, string $text, ?array $replyMarkup = null, string $parseMode = 'HTML'): bool
    {
        try {
            $payload = [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => $parseMode,
            ];

            if ($replyMarkup) {
                $payload['reply_markup'] = json_encode($replyMarkup);
            }

            $response = Http::post("{$this->apiUrl}/sendMessage", $payload);
            
            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Telegram sendMessage error: ' . $e->getMessage());
            return false;
        }
    }

    public function sendPhoto(int $chatId, string $photo, ?string $caption = null, ?array $replyMarkup = null): bool|string
    {
        try {
            $payload = [
                'chat_id' => $chatId,
                'photo' => $photo,
                'parse_mode' => 'HTML',
            ];

            if ($caption) {
                $payload['caption'] = $caption;
            }

            if ($replyMarkup) {
                $payload['reply_markup'] = json_encode($replyMarkup);
            }

            $response = Http::post("{$this->apiUrl}/sendPhoto", $payload);
            
            if ($response->successful()) {
                // Return file_id for future reuse
                $result = $response->json();
                return $result['result']['photo'][0]['file_id'] ?? true;
            }

            return false;
        } catch (\Exception $e) {
            Log::error('Telegram sendPhoto error: ' . $e->getMessage());
            return false;
        }
    }

    public function sendVideo(int $chatId, string $video, ?string $caption = null, ?array $replyMarkup = null): bool|string
    {
        try {
            $payload = [
                'chat_id' => $chatId,
                'video' => $video,
                'parse_mode' => 'HTML',
            ];

            if ($caption) {
                $payload['caption'] = $caption;
            }

            if ($replyMarkup) {
                $payload['reply_markup'] = json_encode($replyMarkup);
            }

            $response = Http::post("{$this->apiUrl}/sendVideo", $payload);
            
            if ($response->successful()) {
                // Return file_id for future reuse
                $result = $response->json();
                return $result['result']['video']['file_id'] ?? true;
            }

            return false;
        } catch (\Exception $e) {
            Log::error('Telegram sendVideo error: ' . $e->getMessage());
            return false;
        }
    }

    public function setWebhook(string $url): bool
    {
        try {
            $response = Http::post("{$this->apiUrl}/setWebhook", [
                'url' => $url,
                'drop_pending_updates' => true,
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Telegram setWebhook error: ' . $e->getMessage());
            return false;
        }
    }

    public function getWebhookInfo(): ?array
    {
        try {
            $response = Http::get("{$this->apiUrl}/getWebhookInfo");
            
            if ($response->successful()) {
                return $response->json()['result'];
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Telegram getWebhookInfo error: ' . $e->getMessage());
            return null;
        }
    }

    public function buildInlineKeyboard(array $buttons): array
    {
        return [
            'inline_keyboard' => $buttons
        ];
    }

    public function buildReplyKeyboard(array $buttons, bool $resize = true, bool $oneTime = false): array
    {
        return [
            'keyboard' => $buttons,
            'resize_keyboard' => $resize,
            'one_time_keyboard' => $oneTime,
        ];
    }

    public function removeKeyboard(): array
    {
        return ['remove_keyboard' => true];
    }
}
