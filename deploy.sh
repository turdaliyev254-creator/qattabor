#!/bin/bash

echo "🚀 Начало деплоя Laravel проекта..."

# 1. Обновляем код
echo "📥 Pull последней версии из GitHub..."
git pull origin main

# 2. PHP зависимости
echo "📦 Установка PHP-зависимостей..."
php composer.phar install --no-dev --optimize-autoloader

# 4. Миграции базы данных
echo "🗄️  Запуск миграций..."
php artisan migrate --force

# 5. Очистка и кэширование
echo "🧹 Очистка кэша и пересборка..."
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 6. Перезапуск очередей (если есть)
echo "🔄 Перезапуск очередей..."
php artisan queue:restart || true

echo "✅ Деплой завершён!"