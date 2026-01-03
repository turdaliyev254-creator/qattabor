#!/bin/bash

# 🔧 cPanel/Ahost Quick Fix Script
# Run this after uploading to cPanel via Terminal

echo "🚀 QattaBor cPanel Setup Script"
echo "================================"
echo ""

# Get current directory
CURRENT_DIR=$(pwd)
echo "📁 Current directory: $CURRENT_DIR"
echo ""

# 1. Set permissions
echo "🔐 Setting correct permissions..."
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
chmod -R 775 storage bootstrap/cache
echo "   ✓ Permissions set"
echo ""

# 2. Create storage symlink
echo "🔗 Creating storage symlink..."
if [ -L "public/storage" ]; then
    echo "   ✓ Symlink already exists"
elif [ -d "public/storage" ]; then
    echo "   ⚠ Directory exists, removing..."
    rm -rf public/storage
    php artisan storage:link
    echo "   ✓ Symlink created"
else
    php artisan storage:link
    echo "   ✓ Symlink created"
fi
echo ""

# 3. Verify storage link
echo "🔍 Verifying storage link..."
if [ -L "public/storage" ]; then
    echo "   ✓ Symlink verified: $(readlink public/storage)"
else
    echo "   ❌ ERROR: Symlink creation failed!"
    echo "   Manual fix: In cPanel File Manager, copy"
    echo "   FROM: storage/app/public/*"
    echo "   TO: public/storage/"
fi
echo ""

# 4. Install/Update dependencies
echo "📦 Installing dependencies..."
if [ -f "composer.phar" ]; then
    php composer.phar install --no-dev --optimize-autoloader
elif command -v composer &> /dev/null; then
    composer install --no-dev --optimize-autoloader
else
    echo "   ⚠ Composer not found, skipping..."
fi
echo ""

# 5. Run migrations
echo "🗄️  Running migrations..."
php artisan migrate --force
echo ""

# 6. Cache for production
echo "⚡ Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo "   ✓ Cached successfully"
echo ""

# 7. Check banners
echo "🖼️  Checking banners..."
BANNER_COUNT=$(find storage/app/public/banners -type f 2>/dev/null | wc -l)
echo "   Found $BANNER_COUNT banner files"
echo ""

# 8. Final check
echo "✅ Setup Complete!"
echo ""
echo "🔗 Visit: https://your-domain.com/check-banners"
echo "   to verify everything is working"
echo ""
echo "If banners still don't show:"
echo "  1. Check .env file: APP_URL should be https://your-domain.com"
echo "  2. Clear browser cache"
echo "  3. Visit: https://your-domain.com/storage/banners/[filename]"
echo ""
