# 🚀 Quick Start - Telegram Bot Integration

## ⚡ 5-Minute Setup

### 1️⃣ Get Bot Token (2 min)
```
1. Open Telegram → Search @BotFather
2. Send: /newbot
3. Follow prompts
4. Copy token (e.g., 7884993170:AAF...)
```

### 2️⃣ Configure .env (1 min)
```env
TELEGRAM_BOT_TOKEN=7884993170:AAFX-M-assMcELoJe1hV0sp3tH4PpvRNym4_here
TELEGRAM_BOT_USERNAME=@qattabor_bot
TELEGRAM_WEBHOOK_URL=https://qattabor.uz/api/telegram/webhook
TELEGRAM_ADMIN_CHAT_ID=849124681
```

### 3️⃣ Start Queue (30 sec)
```bash
php artisan queue:work --tries=3 --timeout=3600
```

### 4️⃣ Set Webhook (1 min)
**Option A - Admin Panel:**
- Visit: `/admin/telegram/settings/webhook`
- Enter: `https://qattabor.uz/api/telegram/webhook`
- Click: "Set Webhook"

**Option B - Tinker:**
```bash
php artisan tinker
>>> (new App\Services\TelegramService())->setWebhook('https://qattabor.uz/api/telegram/webhook');
```

### 5️⃣ Test Bot (30 sec)
```
1. Open your bot in Telegram
2. Send: /start
3. Select region
4. Done! ✅
```

---

## 📍 Important URLs

| Purpose | URL | Access |
|---------|-----|--------|
| Admin Dashboard | `/admin/telegram` | Admin only |
| Create Broadcast | `/admin/telegram/create` | Admin only |
| Statistics | `/admin/telegram/stats/statistics` | Admin only |
| Webhook Settings | `/admin/telegram/settings/webhook` | Admin only |
| Webhook Endpoint | `/api/telegram/webhook` | Public (Telegram) |

---

## 🎯 Common Tasks

### Create & Send Broadcast
```
1. Go to: /admin/telegram/create
2. Fill form (caption, media, regions, links)
3. Click "Create Broadcast"
4. Review details
5. Click "Send Broadcast"
```

### View Statistics
```
Go to: /admin/telegram/stats/statistics
See:
- Total users by region
- Total messages sent/failed
- Recent broadcast history
```

### Change Webhook URL
```
1. Update TELEGRAM_WEBHOOK_URL in .env
2. Go to: /admin/telegram/settings/webhook
3. Enter new URL
4. Click "Set Webhook"
```

---

## 🐛 Troubleshooting

### Bot Not Responding?
```bash
# 1. Check webhook status
Visit: /admin/telegram/settings/webhook

# 2. Check logs
tail -f storage/logs/laravel.log

# 3. Test route
curl -X POST https://qattabor.uz/api/telegram/webhook
```

### Queue Not Processing?
```bash
# Check queue worker
ps aux | grep queue:work

# Restart queue
php artisan queue:restart
php artisan queue:work

# Check failed jobs
php artisan queue:failed
```

### Broadcasts Not Sending?
```bash
# 1. Ensure queue is running
php artisan queue:work

# 2. Check broadcast status
Visit: /admin/telegram

# 3. Check logs
tail -f storage/logs/laravel.log
```

---

## 📱 Bot Commands Reference

| Command | What It Does |
|---------|--------------|
| `/start` | Welcome message + region selection |
| `/region` | Change your region |
| `/language` | Change bot language (uz/ru/en) |
| `/help` | Show help information |

---

## 🔧 Production Checklist

- [ ] Bot token in `.env`
- [ ] Webhook URL set
- [ ] Queue worker running (systemd/supervisor)
- [ ] HTTPS enabled
- [ ] Test broadcast sent
- [ ] Statistics page accessible
- [ ] Recent broadcasts showing to users
- [ ] Error logging enabled

---

## 💡 Pro Tips

1. **file_id Reuse**: First upload stores file_id → subsequent broadcasts are instant
2. **Rate Limit**: Bot auto-throttles to 30 msg/sec (Telegram limit)
3. **Queue Worker**: Use supervisor in production for auto-restart
4. **Testing**: Use your personal Telegram account for testing
5. **Languages**: Users can switch languages anytime with `/language`
6. **Regions**: Users automatically see recent ads after selecting region

---

## 📞 Support Commands

```bash
# View routes
php artisan route:list --name=telegram

# Check config
php artisan tinker
>>> config('services.telegram')

# Clear caches
php artisan optimize:clear

# Run migrations
php artisan migrate

# Check queue
php artisan queue:work --once
```

---

## 🎉 Success!

Your Telegram bot is ready! 

**Next:** Create your first broadcast at `/admin/telegram/create`

For detailed documentation, see: `TELEGRAM_BOT_SETUP.md`
