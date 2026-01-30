#!/bin/bash

# Production Server Commands
# Run these in aaPanel Terminal

echo "🔧 Running production deployment commands..."
echo ""

# Clear all caches
echo "1️⃣ Clearing caches..."
php artisan config:clear
php artisan route:clear
php artisan cache:clear
php artisan view:clear

echo ""
echo "2️⃣ Verifying routes..."
php artisan route:list --name=api

echo ""
echo "3️⃣ Testing webhook endpoint..."
curl -X GET http://localhost:8000/api/telegram/webhook

echo ""
echo "4️⃣ Cache for production..."
php artisan config:cache
php artisan route:cache

echo ""
echo "✅ Done! Now test: https://qattabor.uz/api/telegram/webhook"
