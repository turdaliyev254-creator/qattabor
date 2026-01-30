# Telegram Bot Integration - Setup Guide

## ✅ Installation Complete!

The Telegram bot integration has been successfully implemented in your qattabor.uz Laravel project.

## 📋 What Was Implemented

### 1. **Database Structure**
- ✅ Added telegram fields to `users` table:
  - `telegram_chat_id` - Unique identifier for Telegram users
  - `telegram_username` - Telegram username
  - `telegram_first_name` - User's first name
  - `telegram_region_id` - Selected region
  - `telegram_language` - Bot language preference (uz/ru/en)
  - `is_telegram_verified` - Verification status

- ✅ Created `telegram_broadcasts` table:
  - Support for text, photo, and video broadcasts
  - `media_file_id` - Stores Telegram file_id for fast reuse
  - Target region filtering
  - Social media links (Telegram, Instagram, Facebook, YouTube, Phone, Website)
  - Status tracking (draft, sending, completed, failed)
  - Send/fail counters

### 2. **Models & Services**
- ✅ `app/Models/TelegramBroadcast.php` - Broadcast model
- ✅ `app/Models/User.php` - Updated with telegram relationships
- ✅ `app/Services/TelegramService.php` - Telegram API wrapper

### 3. **Controllers**
- ✅ `app/Http/Controllers/Api/TelegramWebhookController.php` - Handles bot commands
- ✅ `app/Http/Controllers/Admin/TelegramBroadcastController.php` - Admin broadcast management

### 4. **Job Queue**
- ✅ `app/Jobs/SendTelegramBroadcast.php` - Async broadcast sending with rate limiting (30 msg/sec)

### 5. **Admin Panel Views**
- ✅ `/admin/telegram` - Dashboard with statistics
- ✅ `/admin/telegram/create` - Create new broadcasts
- ✅ `/admin/telegram/{id}` - View broadcast details
- ✅ `/admin/telegram/statistics` - Detailed statistics
- ✅ `/admin/telegram/webhook` - Webhook configuration

### 6. **Multilingual Support**
- ✅ Bot messages in Uzbek, Russian, and English
- ✅ Translation keys added to all language files

## 🚀 Setup Instructions

### Step 1: Create Your Telegram Bot

1. Open Telegram and search for **@BotFather**
2. Send `/newbot` command
3. Follow the prompts to create your bot
4. Save the **Bot Token** (looks like: `7884993170:AAFX-M-assMcELoJe1hV0sp3tH4PpvRNym4`)
5. Save the **Bot Username** (e.g., `@qattabor_uz_bot`)

### Step 2: Configure Environment Variables

Add these lines to your `.env` file:

```env
# Telegram Bot Configuration
TELEGRAM_BOT_TOKEN=your_bot_token_here
TELEGRAM_BOT_USERNAME=@your_bot_username
TELEGRAM_WEBHOOK_URL=https://yourdomain.com/api/telegram/webhook
TELEGRAM_ADMIN_CHAT_ID=849124681
```

**Important:** Replace `yourdomain.com` with your actual domain!

### Step 3: Set Up Queue Worker

The bot uses Laravel queues for efficient broadcast sending. Start the queue worker:

```bash
php artisan queue:work --tries=3 --timeout=3600
```

For production, add this to your supervisor config or use Laravel Horizon.

### Step 4: Configure Webhook

1. Log in to your admin panel
2. Navigate to **Admin → Telegram Bot → Webhook Settings**
3. Enter your webhook URL: `https://yourdomain.com/api/telegram/webhook`
4. Click **Set Webhook**

**OR** use Artisan Tinker:

```bash
php artisan tinker
```

```php
$telegram = new App\Services\TelegramService();
$telegram->setWebhook('https://yourdomain.com/api/telegram/webhook');
```

### Step 5: Test Your Bot

1. Open Telegram and search for your bot username
2. Send `/start` command
3. Bot should respond with a welcome message and region selection

## 🎯 Bot Commands

User commands:
- `/start` - Welcome message and region selection
- `/region` - Change region
- `/language` - Change bot language
- `/help` - Show help information

## 📢 Creating Broadcasts

### Via Admin Panel:

1. Go to **Admin → Telegram Bot**
2. Click **Create Broadcast**
3. Fill in the form:
   - **Caption** - Your message text (max 1000 chars)
   - **Media** - Optional photo or video (max 20MB)
   - **Target Regions** - Select specific regions or "All Regions"
   - **Social Links** - Add Telegram, Instagram, Facebook, YouTube, Phone, Website

4. Click **Create Broadcast** to save as draft
5. Review the broadcast details
6. Click **Send Broadcast** to queue it for sending

### Features:

- ✅ **file_id Storage** - First upload saves Telegram file_id, subsequent sends are instant
- ✅ **Rate Limiting** - Automatically throttles to 30 messages/second
- ✅ **Progress Tracking** - Real-time sent/failed counters
- ✅ **Region Targeting** - Send to specific regions or all users
- ✅ **Social Buttons** - Inline buttons for social media links
- ✅ **Phone in Caption** - Phone numbers appear in message text, not as buttons

## 📊 Statistics

Access detailed statistics at **Admin → Telegram Bot → Statistics**:

- Total messages sent
- Total failures
- Users by region
- Recent broadcast history

## 🔧 Technical Details

### Webhook vs Long Polling

The bot is configured to use **webhooks** (recommended for production):
- ✅ More efficient
- ✅ No continuous polling
- ✅ Better for aaPanel hosting
- ⚠️ Requires HTTPS

### File ID Strategy

Following **Option C** from requirements:
- First media upload stores the `file_id` in database
- Subsequent broadcasts reuse the `file_id`
- Benefits:
  - ⚡ Much faster delivery
  - 📉 Reduced bandwidth
  - 💾 No server storage needed

### Multilingual Implementation

Bot automatically detects user's language preference:
- User selects language via `/language` command
- Stored in `telegram_language` field
- All bot responses use Laravel's translation system
- Shares translation keys with website (consistent messaging)

## 🛠️ Troubleshooting

### Webhook Not Working?

Check:
1. URL is accessible via HTTPS
2. No firewall blocking Telegram IPs
3. Route is not protected by CSRF middleware (it's not, by design)
4. Run `php artisan route:list | grep telegram` to verify route exists

### Queue Not Processing?

```bash
# Check queue status
php artisan queue:work --once

# Restart queue worker
php artisan queue:restart

# Check failed jobs
php artisan queue:failed
```

### Users Not Receiving Messages?

Check:
1. Queue worker is running
2. Bot token is correct in `.env`
3. Users have `is_telegram_verified = true`
4. Users have selected a region (for targeted broadcasts)

## 📱 Bot User Flow

1. User sends `/start` to bot
2. Bot creates or finds user record
3. User selects region from inline keyboard
4. Bot saves region preference
5. Bot sends recent broadcasts (last 30 days) for that region
6. User receives future broadcasts based on region selection

## 🔐 Security

- ✅ Admin routes protected by `auth` and `admin` middleware
- ✅ Webhook endpoint logs all incoming updates
- ✅ Rate limiting prevents API abuse
- ✅ User data minimal (only chat_id, username, first_name)

## 📦 Dependencies

No additional packages required! Uses:
- Laravel's built-in HTTP client for Telegram API
- Laravel Queue for async processing
- Laravel's translation system for multilingual support

## 🎨 Adding Telegram Link to Admin Sidebar

To add "Telegram Bot" to your admin navigation, edit your admin layout sidebar and add:

```blade
<a href="{{ route('admin.telegram.index') }}" class="sidebar-link">
    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
        <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221l-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.446 1.394c-.14.18-.357.295-.6.295-.002 0-.003 0-.005 0l.213-3.054 5.56-5.022c.24-.213-.054-.334-.373-.121l-6.869 4.326-2.96-.924c-.64-.203-.658-.64.135-.954l11.566-4.458c.538-.196 1.006.128.832.941z"/>
    </svg>
    <span>{{ __('Telegram Bot') }}</span>
</a>
```

## ✨ Next Steps

1. ✅ Configure your bot token in `.env`
2. ✅ Set up webhook
3. ✅ Start queue worker
4. ✅ Test the bot
5. ✅ Create your first broadcast!

## 📞 Support

If you encounter any issues:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Check queue logs: `php artisan queue:failed`
3. Enable debug mode temporarily to see detailed errors

---

**🎉 Your Telegram bot is ready to use!**

Access the admin panel at: `/admin/telegram`
