<?php

namespace App\Jobs;

use App\Models\TelegramBroadcast;
use App\Models\User;
use App\Services\TelegramService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendTelegramBroadcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 3600; // 1 hour
    public int $tries = 3;

    public function __construct(
        public TelegramBroadcast $broadcast
    ) {}

    public function handle(TelegramService $telegram): void
    {
        // Update status to sending
        $this->broadcast->update(['status' => 'sending', 'sent_at' => now()]);

        // Get target users
        $users = $this->getTargetUsers();

        if ($users->isEmpty()) {
            $this->broadcast->update(['status' => 'failed']);
            Log::warning("No users found for broadcast #{$this->broadcast->id}");
            return;
        }

        $sentCount = 0;
        $failedCount = 0;
        $messagesSent = 0;
        $lastSentTime = microtime(true);

        foreach ($users as $user) {
            try {
                // Rate limiting: Max 30 messages per second
                if ($messagesSent >= 30) {
                    $elapsed = microtime(true) - $lastSentTime;
                    if ($elapsed < 1) {
                        usleep((int)((1 - $elapsed) * 1000000));
                    }
                    $messagesSent = 0;
                    $lastSentTime = microtime(true);
                }

                $success = $this->sendToUser($telegram, $user);

                if ($success) {
                    $sentCount++;
                } else {
                    $failedCount++;
                }

                $messagesSent++;

                // Update progress every 10 messages
                if (($sentCount + $failedCount) % 10 === 0) {
                    $this->broadcast->update([
                        'sent_count' => $sentCount,
                        'failed_count' => $failedCount,
                    ]);
                }

            } catch (\Exception $e) {
                $failedCount++;
                Log::error("Failed to send broadcast to user #{$user->id}: " . $e->getMessage());
            }
        }

        // Final update
        $this->broadcast->update([
            'status' => 'completed',
            'sent_count' => $sentCount,
            'failed_count' => $failedCount,
        ]);

        Log::info("Broadcast #{$this->broadcast->id} completed. Sent: {$sentCount}, Failed: {$failedCount}");
    }

    protected function getTargetUsers()
    {
        $query = User::whereNotNull('telegram_chat_id')
            ->where('is_telegram_verified', true);

        $targetRegions = $this->broadcast->target_regions ?? [];

        // If "all" is selected or target_regions is empty, send to all users
        if (!in_array('all', $targetRegions) && !empty($targetRegions)) {
            $query->whereIn('telegram_region_id', $targetRegions);
        }

        return $query->get();
    }

    protected function sendToUser(TelegramService $telegram, User $user): bool
    {
        $chatId = $user->telegram_chat_id;
        $caption = $this->formatCaption();
        $keyboard = $this->buildKeyboard();

        // Use file_id if available (much faster)
        if ($this->broadcast->media_type === 'photo' && $this->broadcast->media_file_id) {
            return (bool) $telegram->sendPhoto($chatId, $this->broadcast->media_file_id, $caption, $keyboard);
        }

        if ($this->broadcast->media_type === 'video' && $this->broadcast->media_file_id) {
            return (bool) $telegram->sendVideo($chatId, $this->broadcast->media_file_id, $caption, $keyboard);
        }

        // Text only
        return $telegram->sendMessage($chatId, $caption, $keyboard);
    }

    protected function formatCaption(): string
    {
        $caption = $this->broadcast->caption;

        // Add phone number to caption
        $links = $this->broadcast->links ?? [];
        if (!empty($links['tel'])) {
            $phone = $links['tel'];
            $digits = preg_replace('/[^0-9]/', '', $phone);
            $caption .= "\n\n📞 Aloqa: +{$digits}";
        }

        return $caption;
    }

    protected function buildKeyboard(): ?array
    {
        $links = $this->broadcast->links ?? [];
        
        if (empty($links)) {
            return null;
        }

        $telegram = new TelegramService();
        $buttons = [];
        $icons = [
            'tg' => '✈️ Telegram',
            'inst' => '📸 Instagram',
            'fb' => '🔵 Facebook',
            'yt' => '🎬 Youtube',
            'web' => '🌐 Sayt',
        ];

        foreach ($links as $key => $value) {
            if ($key === 'tel' || empty($value)) {
                continue;
            }

            $url = $value;
            if ($key === 'tg' && !str_starts_with($value, 'http')) {
                $url = "https://t.me/" . ltrim($value, '@');
            } elseif (!str_starts_with($value, 'http')) {
                $url = "https://{$value}";
            }

            $buttons[] = [
                ['text' => $icons[$key] ?? 'Link', 'url' => $url]
            ];
        }

        return empty($buttons) ? null : $telegram->buildInlineKeyboard($buttons);
    }
}
