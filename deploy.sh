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

# 5. Создание символической ссылки для storage
echo "🔗 Создание символической ссылки для storage..."
php artisan storage:link || true

# 5.1. Проверка символической ссылки
echo "✅ Проверка символической ссылки..."
if [ -L "public/storage" ]; then
    echo "   ✓ Символическая ссылка public/storage существует"
    ls -l public/storage
else
    echo "   ❌ ОШИБКА: Символическая ссылка public/storage НЕ существует!"
    echo "   Попробуйте вручную: php artisan storage:link"
fi

# 6. Очистка и кэширование
echo "🧹 Очистка кэша и пересборка..."
php artisan optimize:clear
php artisan route:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan config:clear
php artisan route:clear

# 7. Перезапуск очередей (если есть)
echo "🔄 Перезапуск очередей..."
php artisan queue:restart || true

echo "✅ Деплой завершён!"