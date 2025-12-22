#!/bin/bash

# ==========================================
# LARAVEL SHARED HOSTING DEPLOYMENT SCRIPT
# ==========================================
# Usage:
# 1. Upload this script to your hosting root folder (e.g., /home/username/)
# 2. Make it executable: chmod +x deploy.sh
# 3. Run it: ./deploy.sh
# ==========================================

# --- CONFIGURATION ---
REPO_URL="https://github.com/turdaliyev254-creator/qattabor.git"
PROJECT_DIR="public_html" # The folder for your source code (Directly in public_html)
PHP_CMD="php"             # Command to run PHP (e.g., /usr/local/bin/php)

# --- START DEPLOYMENT ---
echo "🚀 Starting Deployment..."

# 1. DOWNLOAD COMPOSER (If missing)
if [ ! -f "composer.phar" ]; then
    echo "📦 Downloading composer.phar..."
    $PHP_CMD -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    $PHP_CMD composer-setup.php
    $PHP_CMD -r "unlink('composer-setup.php');"
fi

# 2. PULL CODE
if [ -d "$PROJECT_DIR/.git" ]; then
    echo "🔄 Pulling latest changes from Git..."
    cd $PROJECT_DIR
    git pull origin main
    cd ..
else
    echo "📥 Cloning repository..."
    # Note: This requires public_html to be empty or not exist. 
    # If it fails, manually empty public_html or clone manually first.
    git clone $REPO_URL $PROJECT_DIR
fi

# 3. INSTALL PHP DEPENDENCIES
echo "📚 Installing PHP dependencies..."
cd $PROJECT_DIR
$PHP_CMD ../composer.phar install --no-dev --optimize-autoloader

# 4. SETUP ENVIRONMENT FILE
if [ ! -f ".env" ]; then
    echo "⚠️  .env file not found! Creating from .env.example..."
    cp .env.example .env
    echo "🔑 Generating Application Key..."
    $PHP_CMD artisan key:generate
    echo "❗ IMPORTANT: Please edit $PROJECT_DIR/.env with your database details!"
fi

# 5. RUN MIGRATIONS
echo "🗄️  Running Database Migrations..."
$PHP_CMD artisan migrate --force

# 6. OPTIMIZE & CACHE
echo "⚡ Optimizing Laravel..."
$PHP_CMD artisan optimize:clear
$PHP_CMD artisan config:cache
$PHP_CMD artisan route:cache
$PHP_CMD artisan view:cache

# 7. (SKIPPED) PUBLISH PUBLIC ASSETS
# User requested to keep files in public_html and use .htaccess redirect.
# No copying or patching needed.
cd ..

# 8. FIX PERMISSIONS (Standard Shared Hosting Permissions)
echo "🔒 Setting permissions..."
chmod -R 775 $PROJECT_DIR/storage
chmod -R 775 $PROJECT_DIR/bootstrap/cache

echo "✅ Deployment Finished Successfully!"
