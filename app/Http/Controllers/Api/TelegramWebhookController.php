<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Models\TelegramBroadcast;
use App\Models\User;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TelegramWebhookController extends Controller
{
    protected TelegramService $telegram;

    public function __construct(TelegramService $telegram)
    {
        $this->telegram = $telegram;
    }

    public function handle(Request $request)
    {
        try {
            $update = $request->all();
            Log::info('Telegram webhook received', $update);

            // Handle callback queries (inline button clicks)
            if (isset($update['callback_query'])) {
                $this->handleCallbackQuery($update['callback_query']);
                return response()->json(['ok' => true]);
            }

            // Handle regular messages
            if (isset($update['message'])) {
                $message = $update['message'];
                $chatId = $message['chat']['id'];
                $text = $message['text'] ?? '';

                // Handle commands
                if (str_starts_with($text, '/')) {
                    $this->handleCommand($chatId, $text, $message);
                }
            }

            return response()->json(['ok' => true]);
        } catch (\Exception $e) {
            Log::error('Telegram webhook error: ' . $e->getMessage());
            return response()->json(['ok' => true]); // Always return 200 to Telegram
        }
    }

    protected function handleCommand(int $chatId, string $command, array $message): void
    {
        $user = $this->getOrCreateUser($message);
        $lang = $user->telegram_language ?? 'uz';
        app()->setLocale($lang);

        switch (true) {
            case str_starts_with($command, '/start'):
                $this->handleStart($chatId, $user);
                break;

            case str_starts_with($command, '/region'):
                $this->handleRegionSelection($chatId, $user);
                break;

            case str_starts_with($command, '/help'):
                $this->handleHelp($chatId, $user);
                break;

            case str_starts_with($command, '/language'):
                $this->handleLanguageSelection($chatId, $user);
                break;
        }
    }

    protected function handleStart(int $chatId, User $user): void
    {
        $name = $user->telegram_first_name ?? __('bot.friend');
        
        $welcomeText = "👋 " . __('bot.welcome_greeting', ['name' => $name]) . "\n\n";
        $welcomeText .= "🌟 " . __('bot.welcome_description') . "\n\n";
        $welcomeText .= "📍 " . __('bot.welcome_select_region');

        // Remove keyboard first, then send regions
        $this->telegram->sendMessage($chatId, $welcomeText, $this->telegram->removeKeyboard());
        
        // Send region selection with inline keyboard
        usleep(300000); // 300ms delay
        $this->showRegionSelection($chatId, $user);
    }

    protected function handleRegionSelection(int $chatId, User $user): void
    {
        $this->showRegionSelection($chatId, $user);
    }

    protected function showRegionSelection(int $chatId, User $user): void
    {
        $regions = Region::active()->ordered()->get();
        $buttons = [];

        foreach ($regions as $region) {
            $buttons[] = [
                ['text' => $region->localized_name, 'callback_data' => "region_{$region->id}"]
            ];
        }

        $keyboard = $this->telegram->buildInlineKeyboard($buttons);
        $this->telegram->sendMessage(
            $chatId,
            "📍 " . __('bot.select_region'),
            $keyboard
        );
    }

    protected function handleLanguageSelection(int $chatId, User $user): void
    {
        $buttons = [
            [
                ['text' => '🇺🇿 O\'zbekcha', 'callback_data' => 'lang_uz'],
                ['text' => '🇷🇺 Русский', 'callback_data' => 'lang_ru'],
            ],
            [
                ['text' => '🇬🇧 English', 'callback_data' => 'lang_en'],
            ]
        ];

        $keyboard = $this->telegram->buildInlineKeyboard($buttons);
        $this->telegram->sendMessage(
            $chatId,
            "🌐 " . __('bot.select_language'),
            $keyboard
        );
    }

    protected function handleHelp(int $chatId, User $user): void
    {
        $helpText = "ℹ️ <b>" . __('bot.help_title') . "</b>\n\n";
        $helpText .= "📍 /region - " . __('bot.help_change_region') . "\n";
        $helpText .= "🌐 /language - " . __('bot.help_change_language') . "\n";
        $helpText .= "ℹ️ /help - " . __('bot.help_show_help') . "\n\n";
        $helpText .= "🌍 " . __('bot.help_website') . ": https://qattabor.uz";

        $this->telegram->sendMessage($chatId, $helpText);
    }

    protected function handleCallbackQuery(array $callbackQuery): void
    {
        $chatId = $callbackQuery['message']['chat']['id'];
        $data = $callbackQuery['data'];
        $user = User::where('telegram_chat_id', $chatId)->first();

        if (!$user) {
            return;
        }

        $lang = $user->telegram_language ?? 'uz';
        app()->setLocale($lang);

        // Handle region selection
        if (str_starts_with($data, 'region_')) {
            $regionId = (int) str_replace('region_', '', $data);
            $this->selectRegion($chatId, $user, $regionId);
        }

        // Handle language selection
        if (str_starts_with($data, 'lang_')) {
            $language = str_replace('lang_', '', $data);
            $this->selectLanguage($chatId, $user, $language);
        }
    }

    protected function selectRegion(int $chatId, User $user, int $regionId): void
    {
        $region = Region::find($regionId);
        
        if (!$region) {
            return;
        }

        $user->update(['telegram_region_id' => $regionId]);

        // Send confirmation
        $this->telegram->sendMessage(
            $chatId,
            "✅ " . __('bot.region_updated', ['region' => $region->localized_name])
        );

        // Send recent broadcasts for this region
        usleep(500000); // 500ms delay
        $this->sendRecentBroadcasts($chatId, $user, $regionId);
    }

    protected function selectLanguage(int $chatId, User $user, string $language): void
    {
        $user->update(['telegram_language' => $language]);
        app()->setLocale($language);

        $this->telegram->sendMessage(
            $chatId,
            "✅ " . __('bot.language_updated')
        );
    }

    protected function sendRecentBroadcasts(int $chatId, User $user, int $regionId): void
    {
        // Get broadcasts from last 30 days
        $broadcasts = TelegramBroadcast::where('status', 'completed')
            ->where('sent_at', '>=', now()->subDays(30))
            ->orderBy('sent_at', 'desc')
            ->get()
            ->filter(function ($broadcast) use ($regionId) {
                // Check if broadcast targets this region or all regions
                $targets = $broadcast->target_regions ?? [];
                return in_array('all', $targets) || in_array($regionId, $targets);
            });

        if ($broadcasts->isEmpty()) {
            $this->telegram->sendMessage(
                $chatId,
                "📢 " . __('bot.no_recent_ads')
            );
            return;
        }

        $this->telegram->sendMessage(
            $chatId,
            "📢 " . __('bot.recent_ads_header', ['count' => $broadcasts->count()])
        );

        foreach ($broadcasts->take(5) as $broadcast) {
            usleep(300000); // 300ms delay between messages
            $this->sendBroadcastToUser($chatId, $broadcast);
        }
    }

    protected function sendBroadcastToUser(int $chatId, TelegramBroadcast $broadcast): void
    {
        $caption = $this->formatCaption($broadcast);
        $keyboard = $this->buildBroadcastKeyboard($broadcast->links ?? []);

        if ($broadcast->media_type === 'photo' && $broadcast->media_file_id) {
            $this->telegram->sendPhoto($chatId, $broadcast->media_file_id, $caption, $keyboard);
        } elseif ($broadcast->media_type === 'video' && $broadcast->media_file_id) {
            $this->telegram->sendVideo($chatId, $broadcast->media_file_id, $caption, $keyboard);
        } else {
            $this->telegram->sendMessage($chatId, $caption, $keyboard);
        }
    }

    protected function formatCaption(TelegramBroadcast $broadcast): string
    {
        $caption = $broadcast->caption;

        // Add phone number to caption if exists
        $links = $broadcast->links ?? [];
        if (!empty($links['tel'])) {
            $phone = $links['tel'];
            $digits = preg_replace('/[^0-9]/', '', $phone);
            $caption .= "\n\n📞 " . __('bot.contact') . ": +{$digits}";
        }

        return $caption;
    }

    protected function buildBroadcastKeyboard(array $links): ?array
    {
        if (empty($links)) {
            return null;
        }

        $buttons = [];
        $icons = [
            'tg' => '✈️ Telegram',
            'inst' => '📸 Instagram',
            'fb' => '🔵 Facebook',
            'yt' => '🎬 Youtube',
            'web' => '🌐 ' . __('Website'),
        ];

        foreach ($links as $key => $value) {
            if ($key === 'tel' || empty($value)) {
                continue; // Phone is in caption, not button
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

        return empty($buttons) ? null : $this->telegram->buildInlineKeyboard($buttons);
    }

    protected function getOrCreateUser(array $message): User
    {
        $chatId = $message['chat']['id'];
        $firstName = $message['chat']['first_name'] ?? 'User';
        $username = $message['chat']['username'] ?? null;

        $user = User::where('telegram_chat_id', $chatId)->first();

        if (!$user) {
            $user = User::create([
                'name' => $firstName,
                'telegram_chat_id' => $chatId,
                'telegram_username' => $username,
                'telegram_first_name' => $firstName,
                'telegram_language' => 'uz',
                'is_telegram_verified' => true,
                'role' => 'user',
            ]);
        }

        return $user;
    }
}
